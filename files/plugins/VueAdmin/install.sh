#!/bin/sh
ROOTPATH=../../../www
mkdir $ROOTPATH
mkdir $ROOTPATH/vue3admin
cp -r  ./vue3-admin/ $ROOTPATH/vue3admin

yes | cp -irf ./over/* $ROOTPATH/vue3admin