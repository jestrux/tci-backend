# Pier
Headless CMS setup for Laravel prrojects.

## Quick demo of how Pier works
- https://www.youtube.com/watch?v=6Y8Yb8Qyhhs

## High level plan

- Create a generic API system following API standards
- Create a very easy way for a user(developer) to set up models
- Create a url generator for complex endpoints and option to copy the generated URL or create a shortened version
- Create a generic CMS solution with option for user to customize based on needs
- Create a mobile app with the basic model generation features so a user can update the models on the go


## Seting up
Copy .env.example and create .env file adding your setup details,
most relevant ones are...

```
MIX_UNSPLASH_CLIENT_ID=[UNSPLASH_CLIENT_ID]

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=[YOUR DATABASE NAME]
```

```bash
# Install laravel/php dependencies
composer install

# Install frontend dependencies
yarn
```

## Run

```bash
# Generate application key
php artisan key:gen

# Run laravel server
php artisan serve

# in separate window run
yarn watch
```
