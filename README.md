# php_atproto

A light weight implementation of the atproto protocol to have fun with Bluesky

## Why?
After looking into the already available libraries to communicate with atproto I decided to go my own way.
I somehow abstain from using libraries which include a dozen other libraries in their composer.json while the real communication functionality can be covered by way fewer 3rd party components.

Currently (I would call it pre-alpha) I include only one 3rd party library, namely

* "tcdent/php-restclient"

Maybe it will become more in the future. 

#### V0.0.0.5 remark
To make it all less of a mess, I renamed almost all functions.....
You can find a list of the functions I implemented here:

[Implemented functions  sorted by Endpoint.md](doc/Implemented_sorted_by_Endpoint.md)

[Implemented functions sorted by the name of the function.md](doc/Implemented_sorted_by_Funtions.md)

## Installation

### Composer installation
You can install the library with composer by executing

`composer require schnoog/php_atproto`

This will install the library in the usual vendor directory.
Now copy the file 
`/vendor/schnoog/php_atproto/src/config.dist.php`
to your install directory and rename it to `config.php`



or use the following command from within your install directory to copy the file automatically (if there's alreay a file name `config.php` in the install directory it will not be overwritten.

`php -r 'if(!file_exists(__DIR__ . "/config.php"))   copy (__DIR__ . "/vendor/schnoog/php_atproto/src/config.dist.php", __DIR__ . "/config.php");'`

Change the content of the `config.php` and enter your credentials

### Package installation
**This is the way to go if you don't have installed composer at all.**

I created a second repository which includes all files required to run this thing. 

Download the zipped version from here:
[Packed php_atproto version](https://github.com/schnoog/php_atproto_packed)

Just unzip it, set your credentials in the `config.php` and you're ready to go. 
Yes, it's really that easy 






### Manual installation
This means you have a copy of the whole repository either by
 * Cloning from Github
 * * git clone git@github.com:schnoog/php_atproto.git ->your install directory<-
 *  * git clone https://github.com/schnoog/php_atproto.git ->your install directory<-

 or
 
 *  Downloading the [zip archive from Github ](https://github.com/schnoog/php_atproto/archive/refs/heads/main.zip) and extracting it to ->your install directory<-
 * 
 
After you have the files in your desired directory, copy the file 
`config.dist.php` into your install directory and rename it to `config.php`

Don't forget to install the dependency by executing
`composer install`

Change the content of the `config.php` and enter your credentials




## My requirements
I have (currently) only a few:
* Login (create auth token)
* Locally store the token
* If I call a function to f.e. post on Bluesky, I should only be required to call the functions with its' parameteres, the rest should happen behind the scenes

## How  does it work
I'm not the biggest fan of OOP. Not everything in my digital world has to be a class. So I'll keep the interface purely function (evenso that especially creating a post would be easier to encapsulate in a class)

## What's alread there
OK, let's check what's available

### Authentification

This small example just authentificates against the server and stores the token locally. If a local stored token is available and the last validity check was performed more than specified in `$config['atproto']['storedsession_validity']` seconds ago, the validity will be checked against the backend (in my case BlueSky)

And here a remindes for myself:
Paste `if (!atp_session_get())return false; `
at the beginning of the interface (post, get timeline...) functions.

```
<?php 
require_once(__DIR__ . "/src/includer.php");


if (!atp_session_get()){
    echo "UNABLE TO ESTABLISH SESSION" . PHP_EOL;
    print_r($config['error']);
}else{
    echo "Session estalished and checked"  . PHP_EOL;
}
```

### Posting (into the own timeline)

Yes, this thing actually can post into the own timeline. 
All you need to do (after including the includer.php) is calling the function.

But this comes with limitations (as everything on earth):

* Only up to 4 images alles (jpg or png), each up to 1 000 000 bytes
* Either Webcard or additional images, both together doesn't work

**Here's a little bit about the parameters for the main function atp_create_post**

* Thats the text you're sending

`$text =  "This is the text to post, \n containing mentioning @develobot.bsky.social and a link https://github.com/schnoog/php_atproto";`  

* A simple array of the language keys, but you can also use **null** instead

`$lang = ['de','en'];`  

* This will make entered URLs clickable, otherwise they will remain simple text
* 
`$add_link_facets = true;` 

* This will place mentions if you mention someobody in the text, if true the person you mentioned will be informed about it

`$add_mentions_facets = true;`  

* Here I'm defining 2 images in the root path of this script which will be uploaded. You can also use URLs to images. But even if you only use one image, you have to provide the filename/url within an array 

`$images = [ __DIR__ . "/pic01.jpg" , __DIR__ . "/pic02.jpg"];` 

* Here we add an alternative text to the second image. As you can see this requires the alt text for the first image to be empty

`$images_alts = [ '', 'Alt text for second image'];` 

* That's the URL for a webcard

As mentioned before, you can either have images or a webcard. If you defined both (and provide the function with them ;) ), only the webcard will be displayed

`$website_uri  = "https://github.com/schnoog/php_atproto";` 

* The title displayed on the webcard. If I leave this empty, the script will try to read the title defined by the website

`$website_title = "My user defined title";`

* And the description of the website. Just like $website_title this is scrapped by the script if left empty

`$website_description = "My user defined description";` 

* The filename (or url) to the image to use for the webcard. If none is supplied, the scrapper script tries to find one in the meta tags of the website


`$website_image = __DIR__ . "/website_image.png";` 

OK, let's look how some calls you be done

```
<?php 
require_once(__DIR__ . "/src/includer.php");

/*
Let's define some variables
*/
$text = "This is the text to post, \n containing mentioning @develobot.bsky.social and a link https://github.com/schnoog/php_atproto";
$lang = ['de','en'];
$add_link_facets = true;
$add_mentions_facets = true;
$images = [ __DIR__ . "/pic01.jpg" , __DIR__ . "/pic02.jpg"];  
$images_alts = [ '', 'Alt text for second image']; 
$website_uri  = "https://github.com/schnoog/php_atproto"; 
$website_title = "My user defined title"; 
$website_description = "My user defined description";
$website_image = __DIR__ . "/website_image.png"; 

//The most simple text post - parsing of mentions and links is ENABLED by default
$answer = atp_create_post($text);

//Now a post, just like above, but this time with the 2 defined images attached, and the $lang keys
$answer = atp_create_post($text,$lang,true,true,$images,$images_alts);

//And now a post which includes a webcard, for which we only provide the URL
$answer = atp_create_post($text,$lang,true,true,[],[],$website_uri);

//Why not a post with a full user defined webcard? Own title, description and image
$answer = atp_create_post($text,null,true,true,[],[],$website_uri,$website_title,$website_description,$website_image);

```

### Reading the own timeline

Yes, also reading the own timeline (or feed or however it's called) is also quite easy. Tbh, the most easiest thing available



```
<?php 
require_once(__DIR__ . "/src/includer.php");

//Get 27 entries of the own timeline and print it by DebugOut
$timeline = atp_get_own_timeline(27);

DebugOut($timeline);

```

### Search posts

This function is somehow limited. I'm currently unable to receive any valid result from `app.bsky.feed.searchPosts`.
So instead I'm reading from `https://search.bsky.social/search/posts`

Not nice, but it works however

```
<?php 
require_once(__DIR__ . "/src/includer.php");

//Search for posts containing "Arduino" and print the result
$answer = atp_search_posts_by_term("Arduino");
DebugOut($answer);


```

## More info

I'll create a list with the functions and endpoints implemented and will try to keep it up to date.

[Implemented_sorted_by_Endpoint.md](doc/Implemented_sorted_by_Endpoint.md)

[Implemented_sorted_by_Funtions.md](doc/Implemented_sorted_by_Funtions.md)











