#!/bin/sh

ROOTPATH=../../www/
# 如果沒有輸入 $1則詢問使用者輸入
if [ -z $1 ]; then
    echo "請輸入插件名稱"
    read -p "插件名稱: " PROJECTNAME
else
    PROJECTNAME=$1
fi




cd $ROOTPATH
echo '<?php $routes->add("/'$PROJECTNAME'", "'$PROJECTNAME'::index");$routes->add("/'$PROJECTNAME'/(:any)", "'$PROJECTNAME'::$1");' >> app/Config/Routes/$PROJECTNAME.php
php spark make:controller $PROJECTNAME  
php spark make:model $PROJECTNAME
php spark make:migration $PROJECTNAME
php spark make:seeder $PROJECTNAME

