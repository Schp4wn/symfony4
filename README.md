# RomDB - A Symfony 4 Test

A simple Database application for RetroGames

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

Symfony 4
Doctrine
Angular-cli

### Installing

You need a PHP server, composer and npm installed on your machine. You can find help to install these on their official websites.

Let's say you want to install RomDB in the "RomDB" folder :

   ** Clone this repository: **
    (get the author's code) git clone https://github.com/Schp4wn/synfony4.git
    ** Install the software **
    (Angular and Symfony need to set up a lot of dependancies missing from the Github release)
    - cd symfony ;
    - composer install
    - cd ../angular ;
    - npm install
    Ensure your PHP server is online

    ** Reset the database (creation, and filling with default data): **
    - cd../XXX/
    - php bin/console doctrine:database:create 
    - php bin/console doctrine:migrations:diff 
    - php bin/console doctrine:migrations:migrate 
    - php bin/console doctrine:fixtures:load
    Launch the Node server for the frontend part : cd ../angular ; ng serve

That's it ! You can now access :

## Built With

* [Symfony4](https://github.com/symfony/symfony) - Backend
* ~~ [Angular-cli](https://github.com/angular/angular-cli) - Frontend ~~
* [Twig](https://github.com/twigphp/Twig) - templating

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Authors

* **Steven Poscher** - *Initial work* - [Schp4wn](https://github.com/Schp4wn)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Senvisage
