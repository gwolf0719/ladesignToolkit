#!/bin/sh

# codeIgniter
if [ ! -d  "www" ]; then
	echo "mkdir====="
	cp -R files/ci4 www
	cp -R files/phpMyAdmin www/public
	cp files/env www/.env 
	chmod -R 777 www/writable
fi



# http
echo "http====="
php-fpm7 -D
nginx -c /etc/nginx/nginx.conf &

# mysql
echo "mysql====="
MYSQL_ROOT_PWD="dev"
MYSQL_USER_DB="dev"

if [ ! -d "/run/mysqld" ]; then
	mkdir -p /run/mysqld
	chown -R mysql:mysql /run/mysqld
    chown -R mysql:mysql /etc/mysql
fi

if [ -d /var/lib/mysql/mysql ]; then
	echo '[i] MySQL directory already present, skipping creation'
else
	echo "[i] MySQL data directory not found, creating initial DBs"

	chown -R mysql:mysql /var/lib/mysql

	# init database
	echo 'Initializing database'
	cd /var/lib/mysql && mysql_install_db --user=mysql --datadir=/var/lib/mysql > /dev/null
	echo 'Database initialized'

	echo "[i] MySql root password: $MYSQL_ROOT_PWD"

	# create temp file
	tfile=`mktemp`
	if [ ! -f "$tfile" ]; then
	    return 1
	fi

	# save sql
	echo "[i] Create temp file: $tfile"
	cat << EOF > $tfile
USE mysql;
FLUSH PRIVILEGES;
GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' IDENTIFIED BY '$MYSQL_ROOT_PWD' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '$MYSQL_ROOT_PWD' WITH GRANT OPTION;
EOF
	# Create new database
	if [ "$MYSQL_USER_DB" != "" ]; then
		echo "[i] Creating database: $MYSQL_USER_DB"
		echo "CREATE DATABASE IF NOT EXISTS \`$MYSQL_USER_DB\` CHARACTER SET utf8 COLLATE utf8_general_ci;" >> $tfile

	fi

	echo 'FLUSH PRIVILEGES;' >> $tfile

	# run sql in tempfile
	echo "[i] run tempfile: $tfile"
	/usr/bin/mysqld --user=mysql --bootstrap --verbose=0 < $tfile
	#rm -f $tfile
fi


# 建立一個實體檔案 mysqlstart 在 www 資料夾下
# 並且在這個檔案中寫入以下內容
# mkdir www
# touch www/mysqlstart
echo 'mysql start' > /web/mysqlstart

echo '[i] start running mysqld'
exec /usr/bin/mysqld --user=mysql --console --skip_networking=0



