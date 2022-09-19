#!/bin/sh
# 進度條
function bar(){
    s=$1
    i=0
    str='#'
    ch=('|' '\' '-' '/')
    index=0
    while [ $i -le $s ]
    do
        printf "[%-${s}s][%d%%][%c]\r" $str $(($i*4)) ${ch[$index]}
        str+='#'
        let i++
        let index=i%4
        sleep 0.1
    done
    printf "\n"
}







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


cd ./files/plugins/
sh ./phpinstall.sh

# bar 30  




# echo '====================='
# echo '安裝 VueAdmin 環境'
# cd ./files/plugins/VueAdmin
# sh install.sh ; 

# ^z
# bg %1



