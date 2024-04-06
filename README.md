
## Installation & updates

from root folder, run in command line:
`composer create-project codeigniter4/appstarter`
then:
`composer update`
whenever there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`. Be cearfull, don't replace Routes.php, App.php, Constans.php!

## Setup
Copy `env` to `.env` and tailor for your app, specifically the baseURL (hhtp://local/)
and any database settings.
# generate security key in env
>php spark key:generate
# Show all routes
>php spark routes

# CodeIgniter 4 Framework

## What is CodeIgniter?
[official site](https://codeigniter.com).
[development repository](https://github.com/codeigniter4/CodeIgniter4).
**Please** read the user guide for a better explanation of how CI4 works!
[user guide](https://codeigniter.com/user_guide/)
## Repository Management
[forum](http://forum.codeigniter.com)

## Server Requirements
PHP version 7.4 or higher is required, with the following extensions installed:
> [!WARNING]
> The end of life date for PHP 7.4 was November 28, 2022.
> The end of life date for PHP 8.0 was November 26, 2023.
> If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> The end of life date for PHP 8.1 will be November 25, 2024.

Additionally, make sure that the following extensions are enabled in your PHP:
- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
