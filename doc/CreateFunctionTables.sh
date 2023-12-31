#!/usr/bin/env bash

#Uses Josh Fails markdown-table script
#https://josh.fail/2022/pure-bash-markdown-table-generator/
IFS="
"

WHEREIWAS=$(pwd)

cd $(dirname $(realpath $0))

pwd

function findLabel {
    LABEL="$1"
    FF=$(dirname $(pwd))"/src/"
    PART1=$(grep -B 30 -r "function $LABEL" "$FF" | grep "\* $LABEL" | cut -d '*' -f 2 | cut -d '-' -f 2- | head -n 1)
    echo "$PART1"
}



RAWINPUT="Implemented_functions.info"
INPUT="tmp.info"



rm "$INPUT" 2>/dev/null
head -n 1 "$RAWINPUT" > $INPUT
ALL=$(tail -n+2 "$RAWINPUT" |  cut -d ";" -f -2)
for CL in $ALL
do
echo "CL:   $CL"
    FN=$(echo "$CL" | cut -d ';' -f 2)
    FD=$(findLabel "$FN")
    OUT="$CL"";""$FD"
echo "$OUT"
    echo "$OUT" >> "$INPUT"

done




#(sed -u 1q; sort -t ';' -k 2)


EPLIST="Implemented_sorted_by_Endpoint.md"
FLIST="Implemented_sorted_by_Funtions.md"


echo '# php_atproto' > "$EPLIST"
echo '' >> "$EPLIST"
echo '## Implemented endpoints sorted by endpoint' >> "$EPLIST"
echo '' >> "$EPLIST"
cat "$INPUT" | (sed -u 1q; sort -t ';' -k 1) | markdown-table -s';' >> "$EPLIST"

echo '# php_atproto' > "$FLIST"
echo '' >> "$FLIST"
echo '## Implemented endpoints sorted by function' >> "$FLIST"
echo '' >> "$FLIST"
cat "$INPUT" | (sed -u 1q; sort -t ';' -k 2) | markdown-table -s';' >> "$FLIST"








cd "$WHEREIWAS"
