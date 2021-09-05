#!/bin/bash
DST=../../locale
RED=../../README.md
LNG="de fr"

po_trasnlate_readme() {
    PAR="-f text -k 10"
    for VAR in $LNG; do
        if [ -f "README.$VAR.po" ]; then
            echo "README.$VAR.po"
            po4a-translate $PAR -v -m $RED -p README.$VAR.po -l ../README.$VAR.md
        fi
    done
}

po_translate_lang() {
    RED=$DST/en.php
    PAR="-f text -k 1"
    for VAR in $LNG; do
        if [ -f "$VAR.po" ]; then
            echo "[$VAR.po] -> [$DST/$VAR.php]"
            po4a-translate $PAR -m $RED -p $VAR.po -l $DST/$VAR.php
        fi
    done
}

#po_translate_readme "$LNG"
po_translate_lang
rm -f *.po~
