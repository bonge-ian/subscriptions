# Subscription Site

## How to install

Clone this repo in your local machine

```cd ``` into the cloned repository

Run the following

```composer install```

After installing dependencies

Run

```cp .env.example .env```

Configure the ```.env``` for the following keys
- APP_NAME
- DB_CONNECTION
- DB_HOST
- DB_PORT
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD=
- MAIL_MAILER=
-  MAIL_HOST=
-  MAIL_PORT=
-  MAIL_USERNAME= 
-  MAIL_PASSWORD= 
-  MAIL_ENCRYPTION= 

The above will ensure that you have the database and app name configured.

Run 
```php artisan key:generate```

Run 

```php artisan optimize:clear```

```php artisan optimize```


To run a command to notify users of a new post, run
```php artisan notify-subscribed-users```

The above will push the jobs to the background.

You could either 
1. Run ```php artisan queue:work --queue=notification-emails```
Or run task scheduler which will execute this every hour (preferred)
2. Run ```php artisan schedule:work```
