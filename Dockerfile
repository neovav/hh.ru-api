FROM alpine:3.12
LABEL Maintainer="Neovav <neovav@ukr.net>" \
      Description="Api hh.ru"

RUN echo "http://dl-cdn.alpinelinux.org/alpine/edge/community" >> /etc/apk/repositories \
    && apk update && apk upgrade \
    && apk add --no-cache  --repository http://dl-cdn.alpinelinux.org/alpine/edge/community php \
    && apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ --allow-untrusted gnu-libiconv \
    && apk --no-cache add php7-opcache php7-mysqli php7-json php7-openssl php7-curl \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-ctype php7-session \
    php7-mbstring php7-gd php-tokenizer php-iconv php-intl php-pdo php-pdo_mysql nginx supervisor wget \
    openssl ca-certificates curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && mkdir /app

ADD . /app

WORKDIR /app

RUN composer install

COPY ./entrypoint.sh /usr/bin/entrypoint.sh

CMD ["/bin/ash","-c","/usr/bin/entrypoint.sh"]