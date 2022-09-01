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
fi

# 抓取目前 app 資料夾相關檔案
# 如果 www/app/Config/Routes/Install.php 存在則
#     cp www/app/Config/Routes/Install.php $PROJECTNAME/Install.php
if [ -f $ROOTPATH/app/Config/Routes/$PROJECTNAME.php ]; then
    
    mkdir $PROJECTNAME/app/Config
    mkdir $PROJECTNAME/app/Config/Routes
    cp $ROOTPATH/app/Config/Routes/$PROJECTNAME.php $PROJECTNAME/app/Config/Routes/$PROJECTNAME.php

    mkdir $PROJECTNAME/app/Controller
    cp $ROOTPATH/app/Controller/$PROJECTNAME.php $PROJECTNAME/app/Controller/$PROJECTNAME.php

    mkdir $PROJECTNAME/app/Model
    cp $ROOTPATH/app/Model/$PROJECTNAME.php $PROJECTNAME/app/Model/$PROJECTNAME.php

    mkdir $PROJECTNAME/app/Database
    mkdir $PROJECTNAME/app/Database/Migrations
    mkdir $PROJECTNAME/app/Database/Seeds
    cp $ROOTPATH/app/Database/Migrations/*$PROJECTNAME.php $PROJECTNAME/app/Database/Migrations/
    cp $ROOTPATH/app/Database/Seeds/$PROJECTNAME.php $PROJECTNAME/app/Database/Seeds/$PROJECTNAME.php
fi