FROM php:7.3.19-fpm-alpine3.12

RUN apk add --no-cache shadow \
                       openssl \
                       bash \
                       mysql-client \
                       nodejs \
                       npm \
                       freetype-dev \
                       libjpeg-turbo-dev \
                       libpng-dev

RUN touch /root/.bashrc | echo "PS1='\w\$ '" >> /root/.bashrc
RUN touch /home/www-data/.bashrc | echo "PS1='\w\$ '" >> /home/www-data/.bashrc

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www
RUN rm -rf /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.38.0/install.sh | bash && \
    export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")" && \
    [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" && \
    nvm install 14.17.4

RUN usermod -u 1000 www-data

RUN ln -s public html

USER www-data

EXPOSE 9000

ENTRYPOINT ["php-fpm"]