<p align="center"><img src="http://elp.gearhostpreview.com/files/xXxTopCliP9hPgoAa1zfCoELkuNT9ie5tq3d15fb.png" width="200"></p>

<p align="center">
<img src="http://elp.gearhostpreview.com/files/81WvtWAOq7QhW1aW8R6ZyOHms7YA9wWpj35jekVj.jpeg" width="300">
<img src="http://elp.gearhostpreview.com/files/tE6bsOmW8B9xdtzAextwk4GYK8oKbKIhigWob754.jpeg" width="300">
<img src="http://elp.gearhostpreview.com/files/Yj6WkYJj6n9iSd7VFpthP3KJ6AMvXTdVOPOekx2I.jpeg" width="300">
</p>

## About

ELP is a one-page site template with a control panel. This application consists of two parts:

- **[Backend is an API made by Laravel(this page)](https://github.com/IgnatBulychov/elp-back/)**
- **[Frontend by Nuxt.js](https://github.com/IgnatBulychov/elp-back/)**

## Installation

```
git clone https://github.com/IgnatBulychov/elp-back.git
```

```
composer install
```

```
cp .env.example .env
```

```
php artisan key:generate
```

```
php artisan jwt:secret
```

Set .env file

```
php artisan migrate
```

```
php artisan db:seed
```

```
php artisan storage link
```
