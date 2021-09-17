<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation

To start using this project is very simple, you just have to clone and install the dependencies with Composer. Once this is done, you must to copy file ".env.example" in ".env" fil and configure the information. After that, you must to create the encryption key of the projects. The commands to use are the following:

> install laravel project and dependencies

```shell
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
```

When you finish this steep, you will need to generate app.css and app.js for generate vue files, and style files.

> install node dependencies

```shell
npm install
npm run dev
```
