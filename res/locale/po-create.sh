#!/bin/bash
DST=../../locale/
LNG="de fr"
RED=../../README.md
PAR="-f text"
for VAR in $LNG; do
    if [ ! -f "README.${VAR}.po" ]; then
        echo "README.${VAR}.po"
        po4a-gettextize $PAR -m $RED -p README.${VAR}.po
    fi
done
RED=$DST/en.php
PAR="-f text"
for VAR in $LNG; do
    if [ ! -f "$VAR.po" ]; then
        echo "$VAR.po"
        po4a-gettextize $PAR -m $RED -p $VAR.po
    fi
done
