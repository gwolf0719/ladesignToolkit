from distutils.file_util import copy_file
import os
import shutil
import json


rootDir = '../../../'
wwwDir = rootDir + "www/"
# 記錄原始路徑
cwd = os.getcwd()


def getOldMenu():
    os.chdir(cwd)
    print(rootDir + 'www/vue3admin/src/api/main-menu.json')
    with open(rootDir + 'www/vue3admin/src/api/main-menu.json', 'r') as f:
        return json.load(f)

def install():
    # 讀取 setting.json
    with open('./setting.json', 'r') as f:
        setting = json.load(f)
        # 複製後端檔案
        
        for i in setting['install']['codeigniter4']:
            os.system
            copy_file('./'+i, wwwDir + i)
        
        os.chdir(cwd)
        for i in setting['install']['panel']:
            # 如果 vue3admin/src/views/manager/ 不存在就建立
            if not os.path.isdir(wwwDir + 'vue3admin/src/views/article/'):
                os.mkdir(wwwDir + 'vue3admin/src/views/article/')
            copy_file('./'+i, wwwDir + i)
        os.chdir(cwd)
        os.chdir(wwwDir)
        # 執行系統指令
        for i in setting['install']['shell']:
            os.system(i)
        # 如果 menu 有值，就把 menu 複製到 main-menu.json
        if 'menu' in setting['install']:
            menuData = setting['install']['menu']
            oldMenuData = getOldMenu()
            oldMenuData.append(menuData)
            os.chdir(cwd)
            # 回存檔案
            with open(rootDir + 'www/vue3admin/src/api/main-menu.json', 'w') as f:
                json.dump(oldMenuData, f, indent=4)


        
        

act = input("請輸入您要執行的動作(1:安裝, 2:封裝): ")
if act == '1':
    print("安裝中...")
    install()
else:
    print("封裝中...")



