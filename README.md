
# Estore

A unified backend solution designed to efficiently manage multiple online stores with distinct front-end interfaces, streamlining inventory, orders, and customer data while offering seamless integration and customization for each storefront.

## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`DB_DATABASE`
`DB_USERNAME`
`DB_PASSWORD`

## Installation

Clone Estore

``` 
  git clone https://github.com/indigitalin/Estore.git
```

Go to the project directory

```bash
  cd Estore
```

Install dependencies

``` 
  composer install
  npm install
```

Run migration

``` 
  php artisan migrate
```

Run seeder

``` 
  php artisan db:seed
```

Start application

``` 
  php artisan serve
  npm run dev/build
```

Login to admin

``` 
  email    : admin@example.com
  password : 12345678
```

## Screenshots

![App Screenshot](https://res.cloudinary.com/rr6/image/upload/v1729605139/FireShot_Capture_291_-_Estore_-_127.0.0.1_gmprx1.png)

