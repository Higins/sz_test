docker-compose up

php artisan migrate:install

php artisan migrate

php artisan db:seed --class=CompaniesSeeder

----------------------------------------------------------------
api/company -- list all

api/company/activity -- list by activity

api/company/save -- save or update, if you get an id then update

api/company/{id?} -- get company by id/ids

api/company/bydate -- list by date



----------------------------------------------------------------
another db connect issue(maybe):

sudo nano /etc/hosts

add :

127.0.0.1       szallas_mysql_1

localhost       szallas_mysql_1
