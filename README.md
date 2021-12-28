# Project 5 : Blog PHP (Application developer - PHP / Symfony - OpenClassrooms)

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/6cb1192c39f74feca26b2957e935ce68)](https://www.codacy.com/gh/ashk74/P5_blog/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ashk74/P5_blog&amp;utm_campaign=Badge_Grade)

## CONFIGURATION REQUIRE
### 1.  Web Server
You need a web server with PHP7 and MySQL DBMS.
Versions used in this project :
*   Apache 2.4.51
*   MySQL 8.0.27
*   PHP 7.4.26

### 2.  SMTP Server
*   Used for contact form

### 3.  Composer

#### a.  [How to install Composer ?](https://getcomposer.org/download/)

#### b.  Production packages
*   twig/twig : 3.3
*   phpmailer/phpmailer : 6.5
*   devcoder-xyz/php-dotenv : 1.1

#### c.  Development packages
*   squizlabs/php_codesniffer : 3.6

### 4.  CSS Framework
*   Bootstrap 5.1.3 (load in templates/layout.twig)

### 5.  Icons toolkit
*   Font-awesome 6 (load in templates/layout.twig)

## Installation
### 1.  Download zip files or clone the project repository with github - [GitHub documentation](https://docs.github.com/en/github/creating-cloning-and-archiving-repositories/cloning-a-repository)

### 2.  Create database
*   Import **blog.sql** file in your DBMS (sql/blog.sql)

### 3.  Configure SMTP server
*   Go to **app/utils** folder and complete the **.env** file with your SMTP informations
*   Exceptionally for this project, the .env file is filled but normally an empty file like the code below is provided to avoid sharing sensitive data
```
HOST =
USERNAME =
PASSWORD =
RECIPIENT =
RECIPIENT_NAME =
SUBJECT =
```

### 4.  Configure access to the database
Go to **database** folder and add your DBMS informations on **line 20, 25 and 30**
```PHP
private const DSN = 'mysql:dbname=blog;host=localhost'
private const USERNAME = 'root'
private const PASSWORD = ''
```

### 5.  Install Composer dependencies
Use the command below to install all the packages needed to run the blog
```
$ composer install
```

### 6.  Customize the homepage
1.  Go to **app/public/index.php** at **line 13 to 20** to see the code below
```PHP
// Used in homepage.twig
define('CREATOR_NAME', 'Your Name');
define('QUOTE', 'Your favorite quote');
define('QUOTE_AUTHOR', 'Author of your favorite quote');

// Used in layout.twig
define('GITHUB_LINK', 'https://github.com/your_name');
define('LINKEDIN_LINK', 'https://www.linkedin.com/in/your_name');
define('TWITTER_LINK', 'https://twitter.com/your_name');
```
2.  Define *CREATOR_NAME* value to display your name
3.  Define the *QUOTE* and the *QUOTE_AUTHOR* value to display your favorite quote
4.  Define *GITHUB_LINK* to display your GitHub link into the footer
5.  Define *LINKEDIN_LINK* to display your Linkedin link into the footer
6.  Define *TWITTER_LINK* to display your Twitter link into the footer
7.  Choose your avatar image, rename it to *creator-avatar.png* and place it to **app/public/avatars** folder
8.  Choose your CV, rename it to *cv.pdf* and place it **app/public/cv** folder

### 7.  Create your admin account
1.  Use the code below to generate a valid password hash and copy the result
```PHP
var_dump(password_hash('yourSecretPassword', PASSWORD_BCRYPT, ['cost' => 9]));
```
2.  Go to your DBMS
3.  Create a new user with your informations and the hash you have save
4.  Set *is_validate* to 1
5.  Set *is_admin* to 1

----
### Great ! Now you can connect to the blog and create your first post :)
