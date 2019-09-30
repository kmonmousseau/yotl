FROM debian:jessie

# TODO add git user init

ARG APT_MIRROR=cdn-fastly.deb.debian.org
ENV DEBIAN_FRONTEND=noninteractive

RUN echo "export TERM=xterm" >> /etc/bash.bashrc

RUN apt-get update && apt-get install -y git wget curl ca-certificates apt-transport-https
RUN echo "deb https://packages.sury.org/php/ jessie main" > /etc/apt/sources.list.d/php.list && \
    wget -q https://packages.sury.org/php/apt.gpg -O- | apt-key add -

RUN echo "deb http://packages.dotdeb.org jessie all" > /etc/apt/sources.list.d/dotdeb.list && \
    wget -O- https://www.dotdeb.org/dotdeb.gpg | apt-key add -

# Install packages (multiple apt-get install due to debian http-redir error not yet fixed)
RUN apt-get clean && apt-get update && apt-get install -y \
    mysql-client \
    php7.2
RUN apt-get install -y \
    libapache2-mod-php7.2 \
    php7.2-mysql \
    php7.2-curl \
    php7.2-json \
    php7.2-msgpack \
    php7.2-memcached \
    php7.2-intl \
    php7.2-gmp \
    php7.2-geoip \
    php7.2-mbstring \
    php7.2-xml \
    php7.2-zip \
    php7.2-imagick
RUN apt-get install -y \
    php7.2-xdebug

# Php config (fix .so directories)
RUN sed -i 's/memory_limit = .*/memory_limit = '512M'/' /etc/php/7.2/apache2/php.ini && \
    sed -i 's/memory_limit = .*/memory_limit = '512M'/' /etc/php/7.2/cli/php.ini && \
    sed -i "s/^;date.timezone =$/date.timezone = \"Europe\/Paris\"/" /etc/php/7.2/cli/php.ini &&\
    sed -i "s/^;date.timezone =$/date.timezone = \"Europe\/Paris\"/" /etc/php/7.2/apache2/php.ini

# Configure xDebug extension
RUN sed -i '1 a xdebug.remote_autostart=true' /etc/php/7.2/mods-available/xdebug.ini && \
    sed -i '1 a xdebug.remote_connect_back=1 ' /etc/php/7.2/mods-available/xdebug.ini && \
    sed -i '1 a xdebug.remote_enable=1' /etc/php/7.2/mods-available/xdebug.ini && \
    sed -i '1 a xdebug.max_nesting_level=1200' /etc/php/7.2/mods-available/xdebug.ini && \
    sed -i '1 a xdebug.idekey=PHPSTORM' /etc/php/7.2/mods-available/xdebug.ini

# Configure default site (apache)
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ADD vhost /etc/apache2/sites-available/000-default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    a2enmod rewrite ssl vhost_alias && \
    mkdir /var/www/html/web && \
    /etc/init.d/apache2 restart

# Composer & Symfony installer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Deployer
RUN curl -LO https://deployer.org/deployer.phar && \
    mv deployer.phar /usr/local/bin/dep && \
    chmod +x /usr/local/bin/dep

EXPOSE 22 80

# Clean docker image
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/html

ADD start.sh /start.sh
RUN chmod +x /start.sh

CMD /start.sh
