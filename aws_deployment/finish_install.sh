#!/bin/bash

#Setup env file
environment=$(</var/www/html/environment.txt)
sudo rm -rf /var/www/html/weerman-api/.env
aws s3 cp s3://wm-tc-artifacts/$environment/weerman-api/.env /var/www/html/weerman-api/.env

find /var/www/html/weerman-api -type d -exec chmod 755 {} +
find /var/www/html/weerman-api -type f -exec chmod 644 {} +
sudo chgrp -R www-data /var/www/html/weerman-api/storage /var/www/html/weerman-api/bootstrap/cache
sudo chmod -R ug+rwx /var/www/html/weerman-api/storage /var/www/html/weerman-api/bootstrap/cache
sudo chmod 777 -R /var/www/html/weerman-api/public
#remove /files form admin nad shop sites

# Install dependencies
export COMPOSER_ALLOW_SUPERUSER=1
composer install -d  /var/www/html/weerman-api/

# Clear any previous cached views and optimize the application
php /var/www/html/weerman-api/artisan cache:clear
php /var/www/html/weerman-api/artisan view:clear
php /var/www/html/weerman-api/artisan config:cache
php /var/www/html/weerman-api/artisan optimize
php /var/www/html/weerman-api/artisan route:cache

# Migrate DB
php /var/www/html/weerman-api/artisan migrate --step
yarn install

#Gulp
#sudo npm rebuild node-sass svugdje osim na api i debtor -api
sudo gulp --production

#restart Datadog Agent

# Reload PHP-FPM so that any cached code is subsequently refreshed
sudo service php7.1-fpm reload
sudo service apache2 reload

# Supervisor enable
sudo supervisorctl restart all
#or  /var/www/html/weerman-api/artisan queue:restart

# Bring up application
php /var/www/html/weerman-api/artisan up
