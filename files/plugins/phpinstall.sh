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


ROOTPATH=../../www

function selectPlugin(){
    echo '請選擇要安裝的套件'
    echo '=============================================='
    options=("init" "Manager" "Member" "Products" "Media" "Contact" "Exit")
    
    select v in "${options[@]}"; do
        case $v in
            "init")
                cd install
                sh ./install.sh
                cd ../
                selectPlugin
                break
                ;;
            "Manager")
                cd Manager
                sh ./install.sh
                cd ../
                selectPlugin
                break
                ;;
            "Member")
                cd Member
                sh ./install.sh
                cd ../
                selectPlugin
                break
                ;;
            "Products")
                cd Products
                sh ./install.sh
                cd ../
                selectPlugin
                break
                ;;
            "Media")
                cd Media
                sh ./install.sh
                cd ../
                selectPlugin
                break
                ;;
            "Contact")
                cd Contact
                sh ./install.sh
                cd ../
                selectPlugin
                break
                ;;
            "Exit")
            echo "Bye"
            echo '=============================================='
                exit
                ;;
            *) echo "invalid option $REPLY";;
        esac
    done
}

# 檢查 mysqlstart 檔案存在
function chkMysqlStart(){
    if [ ! -f $ROOTPATH/mysqlstart ]; then
        echo "系統設定中"
        bar 30
        chkMysqlStart
    fi
}

chkMysqlStart
selectPlugin