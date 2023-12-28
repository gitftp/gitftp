FROM php:5.6-apache
RUN sed -i -e 's/deb.debian.org/archive.debian.org/g' \
           -e 's|security.debian.org|archive.debian.org/|g' \
           -e '/stretch-updates/d' /etc/apt/sources.list
RUN apt update
RUN apt install htop -y
RUN apt install curl -y
RUN apt install nano -y
RUN apt install git -y
RUN #DEBIAN_FRONTEND=noninteractive apt install php -y
RUN echo ' \n\
service apache2 restart \n\
sleep infinity ' >> /root/start.sh
WORKDIR /etc/apache2/sites-available
RUN echo ' \
<VirtualHost *:80>\n\
     ServerAdmin admin@boniface.pe\n\
     DocumentRoot /var/www/html/\n\
\n\
     <Directory /var/www/html/>\n\
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
WORKDIR /root
