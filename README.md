[![Codacy Badge](https://app.codacy.com/project/badge/Grade/f2852b96fc6346babb25b88ae73f0ca5)](https://www.codacy.com/gh/nvendeville/P8_ToDoList/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=nvendeville/P8_ToDoList&amp;utm_campaign=Badge_Grade)
<a href="https://codeclimate.com/github/nvendeville/P8_ToDoList/maintainability"><img src="https://api.codeclimate.com/v1/badges/9e8a476d715cdfea2d43/maintainability" /></a>

# To Do List
Simply manage all your to do tasks !

## Prerequest
Composer https://getcomposer.org/download/

## Install and run the application

- **Step 1** : In your Terminal run ``git clone https://github.com/nvendeville/P8_ToDoList.git``

- **Step 2** : In your Terminal run ``cd P8_todolist``

- **Step 3** : In your Terminal run the command ``composer install``

- **Step 4** : Rename the file **.env.dist** to **.env**

- **Step 5** : Choose a name for your DataBase

- **Step 6** : Update ``###> doctrine/doctrine-bundle ###`` in your file **.env**

    - Uncomment the ligne related to your SGBQ

      DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db" **for sqlite**
      DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name" **for mysql**
      DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=13&charset=utf8" **for postgresql**
      DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=mariadb-10.5.8" **for mariadb**
      DATABASE_URL="oci8://db_user:db_password@127.0.0.1:1521/db_name **for oracle**

    - Set the db_user and/or db_password and/or db_name (name chosen on step 4)

- **Step 7** : In your Terminal, create and set your database
    - Run ``php bin/console doctrine:database:create`` give the name chosen on step 4
    - Run ``php bin/console make:migration``
    - Run ``php bin/console doctrine:migrations:migrate``

- **Step 8** : In your Terminal, load the available set of data
    - Run ``php bin/console doctrine:fixtures:load``
    - Available data :
        - 1 user with username "user1" with ROLE_ADMIN
        - 1 user with username "user2" with ROLE_USER
        - 1 user with username "anonymous" with ROLE_ADMIN
          (These 3 created users have "coucou" as password)
        - 3 task for each created user
          (These tasks will be marked as "done" randomly)

- **Step 9** : In your Terminal run the command ``symfony serve``

- **Step 10** : From your browser go to http://locahost:8000. This will route you to the application homepage.

## Contribute to the application

### Prerequests to any new commit
- **Code quality and best practices** :
    - **Code quality** :
  
  Please consider the official recommendations to manage your **code style** by consulting https://www.php-fig.org/psr/
  To help you to check your code, run the commande ``composer run linter``. PhpCS, PhpMessDetector and PhpStan are installed in the project.
  You can also register your repository to Codacy and CodeClimate. This tool will run other linters to check your code.
  Today, the reached badge is A, please don't commit any codes if the result in Codacy and CodeClimate is given under this level.
    - **Best practices** :
  
  Please apply Symfony best practices mentioned in https://symfony.com/doc/current/best_practices.html for any new features


- **Test coverage**

  The application is covered by functional and unit tests. Please cover any new features with tests and ensure the test coverage of the application does not fall below 90%.
  To run the tests, in your terminal, run the command ``php bin/phpunit --coverage-html web/testcoverage``

  - **Unit tests** :
  
  All unit tests have been written with PHPUnit. Follow their recommendations explained in the official documentation https://phpunit.readthedocs.io/
    
  - **Functional tests** :
  
  All functional tests have been written using the WebTestCase of Symfony. Find help in the Symfony official documentation https://symfony.com/doc/current/testing.html

### Push a commit
No commit is allowed to the master branch. To contribute to the application, please follow the following steps :
- Create a new branch
- Commit and push your code to this created branch
- In the github repository, create a pull request
- Your commit will be reviewed
- If the review is not ok, you will be in touch with the reviewers
- If the review is ok, your branch will be merged to the master branch
