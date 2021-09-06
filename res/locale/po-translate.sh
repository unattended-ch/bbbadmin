#!/bin/bash
DST=../../locale
RED=../../README.md
WWW=/var/www/bbb/locale
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

update_www() {
    if [ -d "$WWW" ]; then
        for VAR in $LNG; do
            if [ -f "$VAR.po" ]; then
                cp -v $DST/$VAR.php $WWW/
            fi
        done
    fi
}

#po_translate_readme "$LNG"
po_translate_lang
update_www
rm -f *.po~
