# Currency converter

## Build

For API/backend part run:
```
composer install
```

For frontend part first, make sure you [install Node.js](https://nodejs.org/en/download/) and also the [Yarn package manager](https://yarnpkg.com/lang/en/docs/install/#debian-stable).
Then run:
```
yarn install
``` 
to download necessary js modules
```
yarn encore dev
``` 
to compile assets

## Test

```
php bin/phpunit
```

## Run

1. create vhost pointing to ***/public*** directory as DocumentRoot

OR

2. Move into your new project and start the server:
```
php bin/console server:run
``` 

As it is Symfony based project you will find more details here: https://symfony.com/doc/current/setup.html
