# Use Ubuntu 22.04 as base image
FROM ubuntu:22.04

# Set noninteractive mode to avoid prompts
ENV DEBIAN_FRONTEND=noninteractive

# Install dependencies
RUN apt-get update && apt-get install -y \
    software-properties-common \
    zip unzip git nginx mysql-server \
    libfreetype6-dev libpng-dev libjpeg-dev libwebp-dev \
    cron \
    && add-apt-repository ppa:ondrej/php -y \
    && apt-get update && apt-get install -y \
    php8.3 php8.3-fpm php8.3-cli php8.3-mbstring php8.3-xml \
    php8.3-curl php8.3-zip php8.3-bcmath php8.3-intl php8.3-mysql php8.3-gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install the latest cURL from source
RUN apt-get remove -y curl || true && \
    apt-get update && apt-get install -y wget build-essential libssl-dev && \
    wget https://curl.se/download/curl-8.7.1.tar.gz && \
    tar -xvzf curl-8.7.1.tar.gz && cd curl-8.7.1 && \
    ./configure --with-ssl && make && make install && \
    rm -rf /curl-8.7.1*

# Install Postfix for sending emails
RUN echo "postfix postfix/main_mailer_type string Internet Site" | debconf-set-selections && \
    echo "postfix postfix/mailname string localhost" | debconf-set-selections && \
    apt-get update && apt-get install -y postfix mailutils && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Set the working directory
WORKDIR /var/www/html

# Copy Matomo application
COPY . /var/www/html

# Ensure necessary directories exist
RUN mkdir -p /var/www/html/storage

# Set permissions
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 775 /var/www/html/storage/ 

# Copy the database configuration script
COPY configure-matomo.sh /usr/local/bin/configure-matomo.sh
RUN chmod +x /usr/local/bin/configure-matomo.sh

# Copy NGINX configuration
COPY nginx.conf /etc/nginx/conf.d/default.conf
COPY default /etc/nginx/sites-available
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default
RUN nginx -t

# Create /run/php as root and give ownership to www-data
RUN mkdir -p /run/php && chown -R www-data:www-data /run/php

# Expose port 80 for NGINX
EXPOSE 80

# Start services
CMD /bin/bash -c "service postfix start && cron -f & /usr/local/bin/configure-matomo.sh && php-fpm8.3 -D && nginx -g 'daemon off;'"