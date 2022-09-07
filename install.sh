#!/bin/sh
docker ps

echo '====================='
echo '請輸入要刪除的容器ID'
docker ps
read containerID

docker stop $containerID
docker rm $containerID

echo '====================='
echo '刪除無用的 image'
docker image prune -a

echo '====================='
echo '輸入 image 名稱 (default: ladesign)'

read imageName
imageName=${imageName:-"ladesign"}
docker build -t $imageName .

echo '====================='
echo '輸入 container 名稱 (default: 繼承 image 名稱)'
read containerName
containerName=${containerName:-$imageName}
docker run -d --name $containerName -p 80:80 -p 3306:3306 -v $PWD:/web  $imageName

echo '====================='
echo '環境部署中請稍後....'
t=30
while [ $t -gt 0 ]
do
    echo -n "$t "
    sleep 1
    t=$(($t-1))
done


echo '====================='
echo '安裝 install 環境'
cd ./files/plugins/install
sh install.sh

echo '====================='
echo '安裝 Manager 環境'
cd ../Manager
sh install.sh

echo '====================='
echo '安裝 VueAdmin 環境'
cd ../VueAdmin
sh install.sh

