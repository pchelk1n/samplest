FROM php:8.2.30-cli

RUN apt-get update; \
    apt-get install -y --no-install-recommends unzip git;

COPY --from=composer:2.9.5 /usr/bin/composer /usr/bin/composer

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions intl sysvsem bcmath

RUN ln -sf /usr/share/zoneinfo/UTC /etc/localtime

ARG USER_ID
RUN groupadd --gid "$USER_ID" dev \
    && useradd --uid "$USER_ID" --gid dev --shell /bin/bash --create-home dev

USER dev
WORKDIR /app/

RUN mkdir -p /home/dev/.composer/
