#!/bin/sh
ROOTPATH=../../../www
mkdir $ROOTPATH
mkdir $ROOTPATH/vue3admin

cpinstall(){
    cp -r  ./vue3-admin/ $ROOTPATH/vue3admin
    yes | cp -irf ./over/ $ROOTPATH/vue3admin   
}
reset(){
    cd $ROOTPATH/vue3admin
    git init
    sudo npm -g i pnpm
    pnpm i 
    pnpm run dev 
}



Message='請選擇要使用的動作'
options=("重新安裝" "單純重新執行" "封裝")

select v in "${options[@]}"; do
    case $v in
        "重新安裝")
            cpinstall
            reset
            break
            ;;
        "單純重新執行")
            reset
            break
            ;;
        "封裝")
            cd $ROOTPATH/vue3admin
            git init
            pnpm run build
            break
            ;;
        *) echo "invalid option $REPLY";;
    esac
done



# yes | cp -irf ./over/.* $ROOTPATH/vue3admin



