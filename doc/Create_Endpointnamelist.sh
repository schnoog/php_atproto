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

here=':white_check_mark:'


echo "Extracted "$(date)":" > endpoints_and_descs.txt
ALL=$(grep -hr -A10 '"id":' ../atproto_info/lexicons/app/ | grep -e '"id":\|description"' | grep -B 1 'descrip' | grep -v '\-\-' | grep -v 'DEPRECATED') #> endpoints_and_descs.txt

cat tmp_atproto.info > ATProto_Endpoints.md
echo '| | Endpoint | Description |' >> ATProto_Endpoints.md
echo '| --- | -------- | ----------- |' >> ATProto_Endpoints.md

for LINE in $ALL
do
#echo "$LINE"
if [ $(echo "$LINE" | grep '"id":') ]
then
    id=$(echo "$LINE" | cut -d '"' -f 4)
    de=""

else
    in=$(grep "$id" "Implemented_functions.info" | wc -l)
    if [ "$in" != "0" ]
    then
        check="$here"
    else
        check=':black_square_button:'
    fi

    

    if [ $(echo "$LINE" | grep 'description') ]
    then
        de=$(echo "$LINE" | cut -d '"' -f 4)        
        echo "$id"":""$de" 
        echo "$id"":""$de" >> endpoints_and_descs.txt

        echo '|'"$check"'|'"$id"'|'"$de"'|' >> ATProto_Endpoints.md





    fi

fi



done