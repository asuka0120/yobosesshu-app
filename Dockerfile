FROM php:8.1-apache
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libcurl4-openssl-dev \
    libxml2-dev
RUN docker-php-ext-install curl xml pdo_mysql bcmath
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs
RUN a2enmod rewrite
COPY . /var/www/html
WORKDIR /var/www/html
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN echo '<Directory ${APACHE_DOCUMENT_ROOT}>\n\tAllowOverride All\n\tRequire all granted\n</Directory>' >> /etc/apache2/sites-available/000-default.conf