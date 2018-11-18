Movie Test App
==============

Live demo at: [http://xait_test.wingover.ro/](http://xait_test.wingover.ro/)

Apache user/pass: dan / dan2018!

Predefined user with 600 tree records for testing app behavior
with large data set:

bigdata@example.com / 123123

Swagger endpoint for API documentation:
[http://xait_test.wingover.ro/api/documentation](http://xait_test.wingover.ro/api/documentation)

Installation / Usage
--------------------

Run the following commands in a shell:

```
git clone git@github.com:danvdumitriu/xait_test.git
cd xait_test
composer install
npm install
cp .env.example .env
php artisan key:generate

```

Create a new mysql database.
Edit .env file and fill in the mysql connection params. 

Then run:

```
php artisan migrate --seed
chmod -R 777 storage/
npm run build
```