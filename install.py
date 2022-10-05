from time import sleep
from tqdm import tqdm
import os

# 產生進度條
# def progress_bar(range_num):
#     for i in tqdm(range(range_num)):
#         sleep(0.01)


# 取得目前的 docker container id
print("目前的 docker container")
os.system("docker ps")
print("請問是否要停止並刪除目前所有的 docker container ? (y/n/container id)")
ans = input()
if ans == 'y':
    os.system("docker stop $(docker ps -a -q)")
    os.system("docker rm $(docker ps -a -q)")
    print("目前的 docker container")
    os.system("docker ps")
elif ans == 'n':
    print("不刪除 docker container")
else:
    print("停止並刪除 container id: " + ans +"? (y/n)")
    ans2 = input()
    if ans2 == 'y':
        os.system("docker stop " + ans)
        os.system("docker rm " + ans)
        print("目前的 docker container")
        os.system("docker ps")
    

#檢查 www 目錄是否存在 ，如果存在的話詢問要不要刪除
if os.path.isdir("www"):
    print("www 目錄已存在，是否要刪除? (y/n)")
    ans = input()
    if ans == 'y':
        os.system("rm -rf www")
        print("刪除 www 目錄完成")
    else:
        print("不刪除 www 目錄")


print("輸入 image 名稱 (default: ladesign):")
imageName = input()
imageName = imageName if imageName else "ladesign"
print("輸入 container 名稱 (default: 繼承 image 名稱):")
containerName = input()
containerName = containerName if containerName else imageName

# 執行 docker build
print("執行 docker build")
os.system("docker build -t " + imageName + " .")

# 執行 docker run
print("執行 docker run")
os.system("docker run -d --name " + containerName + " -p 80:80 -p 3306:3306 -v $PWD:/web  " + imageName)



# 產生進度條120s
def bar(range_num):
    for i in tqdm(range(range_num)):
        sleep(1)
        # 監聽 www/mysqlstart 檔案是否存在 ，如果檔案存在就停止進度條
        if os.path.isfile("www/mysqlstart"):
            break
        if i == range_num:
            bar(range_num)

bar(60)

# cp -r  ./vue3-admin/ $ROOTPATH/vue3admin
#     yes | cp -irf ./over/ $ROOTPATH/vue3admin   
print("複製 vue3-admin 到 www 目錄")
os.system("cp -r  ./files/plugins/VueAdmin/vue3-admin/ ./www/vue3admin")
os.system("yes | cp -irf ./files/plugins/VueAdmin/over/ ./www/vue3admin")
# git init
#     sudo npm -g i pnpm
#     pnpm i 
#     pnpm run dev 
os.chdir("www/vue3admin")
os.system("git init")
os.system("sudo npm -g i pnpm")
os.system("pnpm i")
print("Vue3-admin 安裝完成，請執行 pnpm run dev")
