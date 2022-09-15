#!/bin/sh
ROOTPATH=../../www

function selectPlugin(){
    echo '請選擇要安裝的套件'
    echo '=============================================='
    options=("init" "Manager" "Member" "Products" "Exit")
    
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
            "Exit")
            echo "Bye"
            echo '=============================================='
                exit
                ;;
            *) echo "invalid option $REPLY";;
        esac
    done
}

selectPlugin