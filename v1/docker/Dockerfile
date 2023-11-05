#FROM ubuntu:latest
FROM php:5.6-apache
RUN sed -i -e 's/deb.debian.org/archive.debian.org/g' \
           -e 's|security.debian.org|archive.debian.org/|g' \
           -e '/stretch-updates/d' /etc/apt/sources.list
RUN apt update
RUN #apt install apache2 -y
RUN apt install htop -y
RUN apt install curl -y
RUN apt install nano -y
RUN apt install git -y
RUN apt install libcurl4-openssl-dev zlib1g-dev libpng-dev libonig-dev libxml2-dev libzip-dev -y
RUN #DEBIAN_FRONTEND=noninteractive apt install php -y
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install curl
RUN docker-php-ext-install fileinfo
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install session
RUN docker-php-ext-install xml
RUN docker-php-ext-install zip
RUN #pecl install xdebug && docker-php-ext-enable xdebug
WORKDIR /root
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN echo ' \n\
service apache2 restart \n\
sleep infinity ' >> ./start.sh

# add xdebug configurations
#RUN { \
#    echo 'zend_extension=xdebug'; \
#    echo '[xdebug]'; \
#    # echo 'zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20151012/xdebug.so'; \
#
#    echo 'xdebug.mode = debug';\
#    echo 'xdebug.client_host = host.docker.internal';\
#    echo 'xdebug.client_port = 9003';\
#    echo 'xdebug.start_with_request=yes';\
#    echo 'xdebug.log="/var/log/apache2/xdebug.log"';\
##    echo 'xdebug.idekey = PHPSTORM';\
#    echo 'xdebug.discover_client_host=false';\
#} > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /etc/apache2/sites-available
RUN echo ' \
<VirtualHost *:80>\n\
     ServerAdmin admin@$domain\n\
     ServerName $domain\n\
     ServerAlias www.$domain\n\
     DocumentRoot /var/www/html\n\
\n\
     <Directory /var/www/html>\n\
        #Options Indexes FollowSymLinks MultiViews\n\
        #AllowOverride All\n\
        #Order allow,deny\n\
        #allow from all\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
     </Directory>\n\
\n\
     ErrorLog /var/www/html/error.log\n\
     CustomLog /var/www/html/access.log combined\n\
</VirtualHost>\n\
' >> ./gitftp.conf
RUN a2ensite gitftp
RUN a2enmod rewrite
WORKDIR /var/www/html/
#EXPOSE 88
#WORKDIR /root
#CMD ["sh", "start.sh"]
#    command: ["sh", "/root/start.sh"]
