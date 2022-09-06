# 初始設定  

`  
docker build -t ladesign .  
docker run -d --name ladesignPackage -p 80:80 -p 3306:3306 -v $PWD:/web  ladesign  
`  