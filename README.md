# php_atproto

A light weight implementation of the atproto protocol to have fun with Bluesky

## Why?
After looking into the already available libraries to communicate with atproto I decided to go my own way.
I somehow abstain from using libraries which include a dozen other libraries in their composer.json while the real communication functionality can be covered by way fewer 3rd party components.

Currently (I would call it pre-alpha) I include only one 3rd party library, namely

* "tcdent/php-restclient"

Maybe it will become more in the future. 

## My requirements
I have (currently) only a few:
* Login (create auth token)
* Locally store the token
* If I call a function to f.e. post on Bluesky, I should only be required to call the functions with its' parameteres, the rest should happen behind the scenes

## How  does it work
I'm not the biggest fan of OOP. Not everything in my digital world has to be a class. So I'll keep the interface purely function

### What's alread there
OK, let's check what's available

**Authentification**

This small example just authentificates against the server and stores the token locally. If a local stored token is available and the last validity check was performed more than specified in `$config['atproto']['storedsession_validity']` seconds ago, the validity will be checked against the backend (in my case BlueSky)

And here a remindes for myself:
Paste `if (!atp_session_get())return false; `
at the beginning of the interface (post, get timeline...) functions.

```
<?php 
require_once(__DIR__ . "/includer.php");


if (!atp_session_get()){
    echo "UNABLE TO ESTABLISH SESSION" . PHP_EOL;
    print_r($config['error']);
}else{
    echo "Session estalished and checked"  . PHP_EOL;
}
```


