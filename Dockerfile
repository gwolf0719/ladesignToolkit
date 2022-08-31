FROM alpine:3.14

# nginx php
RUN apk add --update ca-certificates openssl nginx nginx-mod-http-headers-more && \
    apk add --update-cache --repository http://dl-3.alpinelinux.org/alpine/v3.10/community/ php7 php7-pear php7-tokenizer php7-gd php7-fpm php7-xml php7-json php7-zlib php7-dom php7-phar php7-curl php7-xmlrpc php7-soap php7-openssl php7-mbstring php7-session php7-mysqli php7-mysqlnd php7-intl php7-pdo php7-mysqli php7-pdo_mysql php7-ctype && \
    mkdir /web && \
    rm -rf /var/cache/apk/*

# mysql
RUN apk update && \
	apk add mysql mysql-client && \
	addgroup mysql mysql && \
	rm -rf /var/cache/apk/*

RUN apk add composer nodejs npm curl bash

RUN npm install gulp  gulp-sass -g


COPY files/etc/php7 /etc/php7
COPY files/etc/nginx /etc/nginx
COPY files/etc/mysql /etc/mysql
COPY files/start.sh /start.sh

RUN chown -R nginx:www-data /web  && \ 
    chown -R nginx /var/lib/nginx && \
    chmod +x /start.sh

WORKDIR /web



CMD ["/start.sh"]


EXPOSE 3306
EXPOSE 80