# Home-Connect
Team A Web Application for BITS-OUA-119

## Getting Started
Ensure you have the latest version of PHP, MySQL & Apache intalled on your local machine.
* Clone the repo
* Place/Replace `httpd.conf` inside your Apache conf folder.
* Place/Replace `php.ini` inside your php conf folder.

## Create and seed database 

Create database,

```sh
cd db && ./create-db.sh
```

Seed database,

```sh
cd db && ./seed-db.sh
```

## Running the app

It's requried to have a mysql database and the database must be created and seeded using the instructions above. The application can be hosted in apache server, however, the latest PHP has a built in development sever, and the application can be started using the following commandline

```sh
 php -S localhost:8000
```

Click [http://localhost:8000/app/](http://localhost:8000/app/) to view the application.

## Logins

Landlord,

```
username: landlord1@homeconnect.com
password: pass123
```

Landlord,

```
username: tenant1@homeconnect.com
password: pass123
```