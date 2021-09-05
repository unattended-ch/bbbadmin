#!/bin/bash
DST=../../locale/
RED=../../README.md
LNG="de fr"

po_update_readme() {
    for VAR in $LNG; do
        if [ -f "README.$VAR.po" ]; then
            echo "README.$VAR.po"
            po4a-updatepo -v -f text -m $RED -p README.$VAR.po
        fi
    done
}

po_update_lang() {
    RED=$DST/en.php
    for VAR in $LNG; do
        if [ -f "$VAR.po" ]; then
            echo "$VAR.po"
            po4a-updatepo -f text -m $RED -p $VAR.po
        fi
    done
}

#po_update_readme
po_update_lang
