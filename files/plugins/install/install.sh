#!/bin/sh

ROOTPATH=../../../www/

cp -r  ./app $ROOTPATH
# 加入路由設定
SCRIPT_STR='foreach(glob(APPPATH . "Config/Routes/*.php") as $routeFile) {$filename = basename($routeFile);require APPPATH . "Config/Routes/".$filename;}'
RoutesFile=$ROOTPATH/app/Config/Routes.php


echo $SCRIPT_STR | tee -a $RoutesFile

# cd $ROOTPATH
cd $ROOTPATH
php spark migrate
php spark db:seed Install
apidoc -i app/Controllers/ -o public/doc
