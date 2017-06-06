# LaravelContactApp

Laravel App for manipulating users contact. Mainly its CRUD functionality. Frontend part is made using beatiful ReactJS which are connected to database across Laravel API. 

User sign-up and login can be done regular or acroas Facebook. Contact/s can be exported to VCard.. 

Implemented functionalities are:

- view layer is all done using ReactJS; 
- UI is responsive using mostly media queries and Twitter Bootsrap
- backend communication with MySQL is done using Laravel 
- CRUD fetaures for user contacts. User can only see their list of contacts;
- Exporting a single contacts to vCard in .vcf files (PATH:storage/app/public/vcf);
- Searching Contacts (real live search);
- Record change/audit logging (record last changes for logged in user contacts);
- Authentication with Facebook, Google and Github with standard Login/Sign Up;
- Friendly URLs (URL slugs)
- code is cleared and fixed by CodeSniffer and Javascript code by EsLint;

Application have unit/acceptance test using PHPUnit. Please type in your CLI:

$ composer test 

for automate testing with results. Failed and succcess cases covered.

For watch development changes just run in new CLI session:

$npm run watch

For get the app up and running on your system please do the following in main project path in your choosen  server environment:

- install your local environment by simply download from Web. Most popular are XAMPP/LAMP/WAMP preinstalled environments on Apache server.I used Xampp here.You can too or if you want maybe try Nginx/Vagrant/Homestead, for better simulation of production with Docker integration.

In your CLI go to Xampp/installation/folder/path and create folder laravel-contact-app:

$ cd your/xampp/installation/folder/path
$ cd htdocs
$ mkdir laravel-contact-app
$ cd laravel-contact-app
$ git clone https://github.com/rajikaimal/react-laravel.git
$ npm install
$ composer install

echo "create database lara_contacts" | mysql -u root -p
# type password here

On local environment I'm using root user for mysql but you can change it according to your setup. Fill in .env with your credentials and finally migrate database:

$ php artisan migrate

Create the scaffold for login:

$ php artisan make:auth

Make app listen to strictly on port 8000 in localhost:

$ php artisan serve --port=8000

Start the local server (XAMPP, WAMP, LAMP) and visit the page http://localhost:8000/. This is built-in server very flexible for testing although not so stable as local web servers or even more like hosting servers.

In footer is provided link to ContactApp Github repository.

Thanks for your time,
Antonio

