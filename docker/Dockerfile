#FROM ubuntu:latest
FROM php:apache
RUN apt update --fix-missing
RUN #apt install apache2 -y
RUN apt install htop -y
RUN apt install curl -y
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
WORKDIR /root
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN echo ' \n\
service apache2 restart \n\
sleep infinity ' >> ./start.sh
WORKDIR /etc/apache2/sites-available
RUN echo ' \
<VirtualHost *:80>\n\
     ServerAdmin admin@$domain\n\
     ServerName $domain\n\
     ServerAlias www.$domain\n\
     DocumentRoot /var/www/html/public\n\
     #DirectoryIndex index.php\n\
     #Alias /api "/var/www/html/api/public"\n\
     #Alias /old "/var/www/html/i/repo"\n\
\n\
     <Directory /var/www/html/public>\n\
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
