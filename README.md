# 直接執行安裝包  
``` 
./install.sh
``` 
> 20200907版會安裝:  
> php mysql nginx docker環境  
> codeIgniter 4  
> ladesign 安裝器  
> ladesign Manager    
> vue3admin 


# 初始設定  

`  
docker build -t ladesign .  
docker run -d --name ladesignPackage -p 80:80 -p 3306:3306 -v $PWD:/web  ladesign  
`  
