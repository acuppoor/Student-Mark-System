########## System Admin Login Details #######

email: ```admin@admin.ac.za```
password: ```1234567```

########## Developers (Team Members) Details #####

Team Leader: CUPPOOR Kushal, CPPKUS001;

2nd Member: PAIDEYA Shanay, PDYSHA008;

3rd Member: WOODMAN Dillon, WDMDIL001


################# Running the Website ######################################################################################
Two ways:
1st one is using docker; 

please refer to other sections

2nd one: run on an ubuntu terminal: ```$ php artisan serve```

################# Install Docker ###########################################################################################
 First Step is to install docker
 Linux : execute the following command in bash: 
 ```$ sudo apt-get install docker-ce```

############### Starting the application servers ############################################################################
   - Rename the project folder as studentmarksystem.dev
   - cd into the project folder
   
   Then run the following:
   - docker-compose up -d
   Note this will download(if not downloaded yet) the following images:
    - PHP, Apache, MySQL and any other images as required
    and it will start their respective containers
    The PHP image comes installed with composer,npm, bower and phpunit, webpack
```
    http://localhost:8080 - website
    hhtp://localhost:8000 - phpmyadmin
```
############### Working with core Laravel components inside containers ######################################################
    (After the starting the application server, then do as follows)
   - Type: docker exec -ti studentmarksystemdev_workspace_1 bash
    Then run the following commands (can skip till the need arise):
    - composer install
    - composer update
    - npm install
    Note you can always run npm,gulp, bower, phpunit commands in this container

  Continue typing the following:
 - php artisan clear-compiled
 - php artisan config:cache
 - php artisan migrate
 - npm run dev

Note this is the container whereby you will be typing all your commands

 Finally
 Go to your browser and open the app on localhost:8080
 
############### MySQL Connection & Logging Into phpMyAdmin For Database Management ###############

You can use any database manager you wish 
The Login details would be as such

Username: root
Password: studentmarksystem

The application automatically connects to MYSQL,this is done in the .env file

To Login Using the phpMyAdmin Web Interface head to localhost:8000 and use the following details:

Server/Host: studentmarksystemdev_mysql_1
Username: root
Password: studentmarksystem

######################################################################################################

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](http://patreon.com/taylorotwell):

- **[Vehikl](http://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Styde](https://styde.net)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
