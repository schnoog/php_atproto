#!/bin/bash

STARTDIR=$(dirname $(realpath $0))

cd "$STARTDIR"
cd ..
cd "atproto_info"
git pull
sleep 1
cd "$STARTDIR"



IFS="
"
id=""
de=""

echo "Extracted "$(date)":" > endpoints_and_descs.txt
ALL=$(grep -hr -A10 '"id":' ../atproto_info/lexicons/app/ | grep -e '"id":\|description"' | grep -B 1 'descrip' | grep -v '\-\-' | grep -v 'DEPRECATED') #> endpoints_and_descs.txt

for LINE in $ALL
do
#echo "$LINE"
if [ $(echo "$LINE" | grep '"id":') ]
then
    id=$(echo "$LINE" | cut -d '"' -f 4)
    de=""

else

    if [ $(echo "$LINE" | grep 'description') ]
    then
        de=$(echo "$LINE" | cut -d '"' -f 4)        
        echo "$id"":""$de" 
        echo "$id"":""$de" >> endpoints_and_descs.txt


    fi

fi



done