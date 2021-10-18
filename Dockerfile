FROM php:8.0-cli-alpine

RUN apk add --update \
		autoconf \
		g++ \
		libtool \
		make
RUN docker-php-source extract

RUN pecl install swoole && docker-php-ext-enable swoole

RUN docker-php-source delete

COPY . /opt/app
WORKDIR /opt/app

CMD [ "./bin/console", "swoole:server:start" ]

EXPOSE 9501