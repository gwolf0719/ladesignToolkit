#!/bin/sh
ROOTPATH=../../www
# 如果沒有輸入 $1則詢問使用者輸入
if [ -z $1 ]; then
    echo "請輸入插件名稱"
    read -p "插件名稱: " PROJECTNAME
else
    PROJECTNAME=$1
fi

# 如果 PROJECTNAME 資料夾不存在則建立資料夾
if [ ! -d $PROJECTNAME ]; then
    mkdir $PROJECTNAME
    mkdir $PROJECTNAME/app
    cp install_sample $PROJECTNAME/install.sh
fi

# 抓取目前 app 資料夾相關檔案
if [ -f $ROOTPATH/app/Config/Routes/$PROJECTNAME.php ]; then
    
    mkdir $PROJECTNAME/app/Config
    mkdir $PROJECTNAME/app/Config/Routes
    cp $ROOTPATH/app/Config/Routes/$PROJECTNAME.php $PROJECTNAME/app/Config/Routes/$PROJECTNAME.php

    mkdir $PROJECTNAME/app/Controllers
    cp $ROOTPATH/app/Controllers/$PROJECTNAME.php $PROJECTNAME/app/Controllers/$PROJECTNAME.php

    mkdir $PROJECTNAME/app/Models
    cp $ROOTPATH/app/Models/$PROJECTNAME.php $PROJECTNAME/app/Models/$PROJECTNAME.php

    mkdir $PROJECTNAME/app/Database
    mkdir $PROJECTNAME/app/Database/Migrations
    mkdir $PROJECTNAME/app/Database/Seeds
    cp $ROOTPATH/app/Database/Migrations/*$PROJECTNAME.php $PROJECTNAME/app/Database/Migrations/
    cp $ROOTPATH/app/Database/Seeds/$PROJECTNAME.php $PROJECTNAME/app/Database/Seeds/$PROJECTNAME.php
fi