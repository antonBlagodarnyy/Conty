# Use the official PHP image with Apache
FROM php:8.2-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy project files to the container
COPY ./src /var/www/html

# Install PHP extensions and dependencies (e.g., mysqli for MySQL)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set permissions for the Apache web server
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose the default Apache port
EXPOSE 80
