#!/bin/bash
DT=$(date +%Y%m%d_%H%M)
SRC=../res/locale
DST=../locale
REPO=/media/master/repo
RASPI=/media/master/raspi
USR=$USER
LNG="de fr"
SRC=.
LCL=$SRC/../locale
FILEVERSION=$(grep "version" ../bbb_load.php  | awk '{print $3}'| tr -dc '[:alnum:].')

cleanup() {
    PAK=$1
    DST=$SRC/$PAK
    rm -rf $DST/opt
    rm -f $DST/DEBIAN/md5sums
}

copy_repository() {
    if [ -d "$REPO" ]; then
        sudo cp -v $1 $REPO/
    fi
    if [ -d "$RASPI" ]; then
        sudo cp -v $1 $RASPI/
    fi
}

sign_package() {
    DEFAULTKEY=$(gpg --list-secret-key | sed -n 4p | tr -d '[:space:]')
    dpkg-sig --batch --gpg-options "--pinentry-mode loopback" -k "$DEFAULTKEY" --sign builder $1
    dpkg-sig --verify $1
    gpg --list-secret-keys
}

createPackage() {
    PAK=$1
    DST=$SRC/$PAK
    echo "----------------------------------------------------------------------------------------------"
    echo "Create Package [${PAK}_${FILEVERSION}-generic.deb]"
    echo "----------------------------------------------------------------------------------------------"
    if [ -d "$DST" ]; then
        rm -rf $DST/opt/$PAK
    fi
    if [ ! -d "$DST/DEBIAN" ]; then
        mkdir -vp $DST/DEBIAN
    fi
    if [ ! -d "$DST/opt/$PAK" ]; then
        mkdir -vp $DST/opt/$PAK
    fi
    if [ ! -f "$DST/DEBIAN/control" ]; then
        cp -v $SRC/../res/control.$PAK $DST/DEBIAN/control
    fi
    REPL='s/Version:.*/Version: '$FILEVERSION'/g'
    sed -i 's/Version:.*/Version: '$FILEVERSION'/g' $DST/DEBIAN/control
    rsync --exclude=".git/*" --exclude="build/*"  --exclude="releases/*" --exclude="res/*" --exclude="sql/*" -ar $SRC/.. $DST/opt/$PAK/
    rm -rf $DST/opt/$PAK/.git
    rm -rf $DST/opt/$PAK/build
    rm -rf $DST/opt/$PAK/releases
    rm -rf $DST/opt/$PAK/res/*
    rm -rf $DST/opt/$PAK/sql
    rm -f  $DST/opt/$PAK/*.sh
    rm -f  $DST/opt/$PAK/.gitignore
    rm -f  $DST/opt/$PAK/*.md
    rm -f  $DST/opt/$PAK/CHANGELOG
    cp $SRC/../res/*.tmpl $DST/opt/$PAK/res/
    if [ "$PAK" == "bbbusers" ]; then
        cp $SRC/../res/bbb_users.json $DST/opt/$PAK/res/bbb_admin.json
        rm -f $DST/opt/$PAK/index.php
        rm -f $DST/opt/$PAK/bbb_create.php
        rm -f $DST/opt/$PAK/bbb_delrec.php
        rm -f $DST/opt/$PAK/bbb_invite.php
        rm -f $DST/opt/$PAK/bbb_invite.tmpl
        rm -f $DST/opt/$PAK/bbb_join.php
        rm -f $DST/opt/$PAK/bbb_record.php
        rm -f $DST/opt/$PAK/bbb_info.php
        rm -f $DST/opt/$PAK/bbb_send.php
        rm -f $DST/opt/$PAK/bbb_stop.php
        mv -v $DST/opt/$PAK/bbb_user.php $DST/opt/$PAK/index.php
    else
        cp $SRC/../res/bbb_admin.json $DST/opt/$PAK/res/
    fi
    pushd $DST
        rm -f ./DEBIAN/md5sums
        find opt/ -type f -name "*" -exec md5sum {} >> ./DEBIAN/md5sums \;
    popd
    sudo chown root.root $DST/* -R
    dpkg-deb -b $PAK
    sudo mv -v $PAK.deb $SRC/../releases/${PAK}_$FILEVERSION-generic.deb
    pushd $SRC/../releases/
        md5sum ${PAK}_$FILEVERSION-generic.deb > ${PAK}_$FILEVERSION-generic.deb.md5
        sha1sum ${PAK}_$FILEVERSION-generic.deb > ${PAK}_$FILEVERSION-generic.deb.sha1
        sha256sum ${PAK}_$FILEVERSION-generic.deb > ${PAK}_$FILEVERSION-generic.deb.sha256
    popd
    sudo chown $USR.$USR $DST/* -R
    #sign_package "$SRC/../releases/${PAK}_$FILEVERSION-generic.deb"
    copy_repository "$SRC/../releases/${PAK}_$FILEVERSION-generic.deb"
    cleanup "$PAK"
}

createPackage "bbbadmin"
createPackage "bbbusers"
