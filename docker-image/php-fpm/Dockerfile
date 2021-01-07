FROM php:7.3-fpm

ENV TERM xterm
ENV TZ Asia/Taipei

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get update && \
    apt-get install -y supervisor tzdata zip wget

# supervisor config
COPY supervisord.conf /etc/supervisor/supervisord.conf

# composer shell script
COPY composer.sh /etc/composer.sh
RUN sh /etc/composer.sh

WORKDIR /usr/share/nginx/html/

STOPSIGNAL SIGTERM

ENTRYPOINT []

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]

