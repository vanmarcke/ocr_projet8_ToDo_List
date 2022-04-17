# Project 8 OpenClassrooms - ToDo&Co

## Application Developer Formation - PHP / Symfony

Enhance an existing ToDo&Co app

## App

![php](https://img.shields.io/badge/php-8.1.1-blue)
![symfony](https://img.shields.io/badge/symfony-6.0.7-succes)
![doctrine](https://img.shields.io/badge/doctrine-%5E3.4-succes)

## Serveur Web

![php-unit](https://img.shields.io/badge/serveur-MariaDB-green)
![Apache](<https://img.shields.io/badge/Apache-2.4.51%20(Win64)%20OpenSSL%2F1.1.1l%20PHP%2F8.1.1-green>)
![phpMyAdmin](https://img.shields.io/badge/phpMyAdmin-5.1.1-green)

## Code Quality

![php-cs-fixer](https://img.shields.io/badge/php--cs--fixer-%5E3.8-succes)
![Dependabot](https://img.shields.io/badge/Dependabot-security%20updates-success)
![Travis-CI](https://img.shields.io/badge/Travis%20CI-PHP%3A8.1-success)

**SymfonyInsight:**

[![SymfonyInsight](https://insight.symfony.com/projects/5d1c1fa2-64f9-4500-8d6d-630df6bfc8ed/big.svg)](https://insight.symfony.com/projects/5d1c1fa2-64f9-4500-8d6d-630df6bfc8ed)

## Context

You have just joined a startup whose core business is an application to manage daily tasks. The company has just been set up, and the application had to be developed at full speed to show potential investors that the concept is viable (we talk about Minimum Viable Product or MVP).

The choice of the previous developer was to use the Symfony PHP framework, a framework that you are starting to know well!

Good news ! ToDo&Co has finally succeeded in raising funds to allow the development of the company and especially of the application.

Your role here is therefore to improve the quality of the application. Quality is a concept that encompasses many subjects: we often talk about code quality, but there is also the quality perceived by the user of the application or the quality perceived by the company's collaborators, and finally the quality you perceive when you have to work on the project.

## Project description

## Bug fixes

### A task must be attached to a user

Currently, when a task is created, it is not attached to a user. You are asked to make the necessary corrections so that automatically, when saving the task, the authenticated user is attached to the newly created task.

When editing the task, the author cannot be changed.

For tasks already created, they must be attached to an “anonymous” user.

### Choose a role for a user

When creating a user, it must be possible to choose a role for it. The roles listed are:

- user role (ROLE_USER);
- administrator role (ROLE_ADMIN).

When modifying a user, it is also possible to change the role of a user.

## Implementation of new features

### Authorisation

Only users with the administrator role (ROLE_ADMIN) should be able to access the user management pages.

Tasks can only be deleted by users who created the task in question.

Tasks attached to the “anonymous” user can only be deleted by users with the administrator role (ROLE_ADMIN).

### Implementation of automated tests

You are asked to implement the automated tests (unit and functional tests) necessary to ensure that the operation of the application is in line with the requests.

These tests must be implemented with PHPUnit; you can also use Behat for the functional part.

You will provide test data in order to be able to prove operation in the cases explained in this document.

You are required to provide a code coverage report at the end of the project. The coverage rate must be greater than 70%.

## Libraries added

- yarn install
- symfony/var-dumper
- dev orm-fixtures
- friendsofphp/php-cs-fixer
- symfony/test-pack
- dama/doctrine-test-bundle

## Installation

### Prerequisites

- [Symfony CLI version v4.28.1](https://symfony.com/download)
- [PHP version 8.1.1](https://www.php.net/downloads)
- [Composer version 2.2.5](https://getcomposer.org/download/)
- [A Management System (SGBD) type 'phpMyAdmin'](https://www.apachefriends.org/fr/index.html)

### Step 1: Clone your machine's repository to a folder of your choice

```powershell
git clone git@github.com:vanmarcke/ocr_projet8_ToDo_List.git
```

### Step 2: Configure database access

- Create an .env.local file in the root of the project.
- In this file copy/paste the code below.
- Modify the 'DATABASE_URL'.

```code
###> doctrine/doctrine-bundle ###
DATABASE_URL="mysql://db_user:db_password@db_host:db_port/db_name?serverVersion=db_server_name"
###< doctrine/doctrine-bundle ###
```

Example:

DATABASE_URL="mysql://root:@127.0.0.1:3306/todolist?serverVersion=mariadb-10.4.11"

### Step 3: Make sure your Apache and Mysql Modules (or others depending on your configuration) are running. In a powershell-like terminal or that of your code editor, run the command below at the root of the project

This command will install all dependencies, webpack-encore-bundle, database with Fixtures dataset and start the web server

```powershell
composer run-script install-projet --dev
```

### Step 4: The site is now functional, you can use the identifiers below

- User profile

  - username: user1
  - password: 123456

or

- Administrator profile

  - username: admin
  - password: 123456

## Testing

Unit and functionnal tests have been implemented with [PHPUnit](https://symfony.com/doc/current/components/phpunit_bridge.html).

- To run tests on your local machine, you need a test database. As mentioned above, please do not modify the `.env.test` file.

- Create a `.env.test.local` file where you can configure your DATABASE_URL environment variable with your local database credentials.

- Create your test database environment by running:

```powershell
composer run-script install-db-test
```

- To run all the tests:

```powershell
symfony php bin/phpunit
```

- To run specific tests:

```powershell
symfony php bin/phpunit --filter `name of the test file without the .php`
```

Example:

```powershell
symfony php bin/phpunit --filter DefaultController
```

- To Get code coverage report:

```powershell
vendor/bin/phpunit --coverage-html web/test-coverage
```

Test-coverage will be accessible from the root of the project in the folder: web\test-coverage\index.html

## Contributing Future Developments

- Please refer to [CONTRIBUTING.md](CONTRIBUTING.md)

## Author

**Frédéric Vanmarcke** - Student Openclassrooms school path PHP / Symfony application developer
