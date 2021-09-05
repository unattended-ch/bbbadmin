#!/bin/bash
DST=../../locale/
LNG="de fr"

po_create_readme() {
    RED=../../README.md
    PAR="-f text"
    for VAR in $LNG; do
        if [ ! -f "README.${VAR}.po" ]; then
            echo "README.${VAR}.po"
            po4a-gettextize $PAR -m $RED -p README.${VAR}.po
        fi
    done
}

po_create_lang() {
    RED=$DST/en.php
    PAR="-f text"
    for VAR in $LNG; do
        if [ ! -f "$VAR.po" ]; then
            echo "$VAR.po"
            po4a-gettextize $PAR -m $RED -p $VAR.po
        fi
    done
}

#po_create_readme
po_create_lang
