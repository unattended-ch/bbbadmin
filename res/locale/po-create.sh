#!/bin/bash
DST=../../locale/
RED=$DST/en.php
LNG="de fr"
PAR="-f text"
for VAR in $LNG; do
    if [ ! -f "$VAR.po" ]; then
        echo "$VAR.po"
        po4a-gettextize $PAR -m $RED -p $VAR.po
    fi
done
