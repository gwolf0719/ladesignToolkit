#!/bin/sh
ROOTPATH=../../../www/
PROJECTNAME='Manager'
cp -r  ./app $ROOTPATH

cd $ROOTPATH
php spark migrate
php spark db:seed $PROJECTNAME
apidoc -i app/Controllers/ -o public/doc