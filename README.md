# SavingWallet


### Create your .env File
> you can copy and paste .env.example file ;)
or use command:
```bash
$ cp .env.example .env
```

### Install packages
```bash
$ composer install
```

### Generate Application Key
```bash
$ php artisan key:generate
```

### Link storage
```bash
$ php artisan storage:link
```

### Give storage folder permission (For linux users)
```bash
$ chmod -R 777 storage/
```

### Migrate Database
```bash
$ php artisan migrate
```

### Seeding Database
```bash
php artisan db:seed
```
------------

### For unit test
```bash
vendor/bin/phpunit
```
------------

### Run Project
```bash
php artisan serve
```
------------

### For login as admin
```bash
email: admin@test.com
password: 123456
```
------------
