FROM php:8.2-cli

RUN apt-get update && \
    apt-get install -y supervisor libonig-dev libzip-dev zip && \
    docker-php-ext-install pcntl pdo_mysql && \
    rm -rf /var/lib/apt/lists/*

COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

CMD ["supervisord", "--nodaemon", "--configuration", "/etc/supervisor/supervisord.conf"]