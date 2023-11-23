## Project Setup

```sh
cp .env.example .env
composer install
npm install
php artisan migrate --seed
```

### Create Database & Compile and Hot-Reload for Development

```sh
php artisan serve
npm run dev
php artisan queue:listen
```
### Note:

```sh
Check your local port and set it to .env add credentails of Mailtrap in .env file.
```
