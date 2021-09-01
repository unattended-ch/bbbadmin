#!/bin/bash
DST=../../locale/
RED=$DST/en.php
LNG="de fr"

PAR="-f text -k 10"
for VAR in $LNG; do
    if [ -f "$VAR.po" ]; then
        echo "$VAR.po"
        po4a-translate $PAR -m $RED -p $VAR.po -l $DST/$VAR.php
    fi
done
