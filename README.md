### Test App ###

#### Run server app ####

```sh
cd server
composer install
php app/console doctrine:mongodb:schema:create 
php app/console server:run
```
#### Run frontend app ####
```sh
cd client
npm install
bower install
gulp serve
```
#### Run tests ####

```sh
cd server
phpunit -c app/

cd client
gulp test
```


