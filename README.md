# Sykes Search

Laravel based simple search facility with pagination

## Installation

```bash
composer require richard-parnaby-king/sykes-search
php artisan vendor:publish
php artisan migrate

```

## Usage

Once installed, search is available at the /search endpoint.

## Test Data

This will add 300 properties and 1,000 bookings to the respective tables.

```bash
php artisan db:seed --class=SykesSeeder
```

## Dependencies

This package requires the following dependencies:

* laravel/laravel

## License
[MIT](https://choosealicense.com/licenses/mit/)