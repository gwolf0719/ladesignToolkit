# 初始設定  

`  
docker build -t ladesign .  
docker run -d --name mainCart -p 80:80 -v $PWD:/web -v $PWD/mysqlfile:/var/lib/mysql ladesign  
`  