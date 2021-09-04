#!/bin/bash
DST=../../locale/
RED=../../README.md
LNG="de fr"

PAR="-f text -k 10"
for VAR in $LNG; do
    if [ -f "README.$VAR.po" ]; then
        echo "README.$VAR.po"
        po4a-translate $PAR -v -m $RED -p README.$VAR.po -l ../README.$VAR.md
    fi
done

RED=$DST/en.php
PAR="-f text -k 10"
for VAR in $LNG; do
    if [ -f "$VAR.po" ]; then
        echo "$VAR.po"
        po4a-translate $PAR -m $RED -p $VAR.po -l $DST/$VAR.php
    fi
done

rm -f *.po~
