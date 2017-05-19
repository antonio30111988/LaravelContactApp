# LaravelContactApp

Laravel App for manipulating users contact. Mainly its CRUD functionality. Frontend part is made using beatiful ReactJS which are connected to database across Laravel API. 

User sign-up and login can be done regular or acroas Facebook. Contact/s can be exported to VCard.. 

Implemented functionalities are:

- Exporting a single contact or all contacts to vCard
- Searching
- Record change/audit logging
- Authentication with Facebook or other OAuth providers
- Friendly URLs (URL slugs)
- Interface i18n to any language(s) you like, even if it’s a made-up language like pirate or l33t speak.

Application have unit/acceptance test using PHPUnit. For run it, please type in your CLI:

-...

For get the app up and running on their system please do the following in main project path:

$ git clone https://github.com/rajikaimal/react-laravel.git
$ cd laravel-contact-app
$ npm install
$ php artisan migrate
$ php -S localhost:3000 -t public

Thanks for your time ;)

