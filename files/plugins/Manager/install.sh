#!/bin/sh
ROOTPATH=../../../www/
PROJECTNAME='Manager'
cp -r  ./app $ROOTPATH
cp -r ./vue3admin $ROOTPATH

cd $ROOTPATH
php spark migrate
php spark db:seed $PROJECTNAME
apidoc -i app/Controllers/ -o public/doc

# 修改 main-menu.json
newJSON=''
cd ../files/plugins/$PROJECTNAME
while read nl;do
    newJSON=$newJSON$nl
done < menu.json
newJSON=$newJSON,
echo '======================='
echo $newJSON | jq .
work_path=$(dirname $0)
echo $work_path
ls
# ROOTPATH=../../../www/
cd $ROOTPATH
F=vue3admin/src/api/main-menu.json

JSON=''
count="0"
while read line;do
    if [ $count -eq 1 ];then
        JSON=$JSON$newJSON
    fi
    count=$(($count+1))
    JSON=$JSON$line
done < $F

echo $JSON | jq . > $F
