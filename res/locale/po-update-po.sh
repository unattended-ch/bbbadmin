#!/bin/bash
DST=../../locale/
RED=$DST/en.md
LNG="de fr"
for VAR in $LNG; do
    if [ -f "$VARpo" ]; then
        echo "$VAR.po"
        po4a-updatepo -f text -m $RED -p $VAR.po
    fi
done
