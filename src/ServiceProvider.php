<?php
 
namespace RichardPK\Search;
 
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Pagination\Paginator;
 
class ServiceProvider extends BaseServiceProvider
{

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function boot()
    {
        //Add /search as a route
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        
        //Views directory
        $this->loadViewsFrom(__DIR__ . '/views', 'search');
        
        //Add db migration
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        
        //DB Seed logic
        $this->publishes([
            __DIR__ . '/database/seeders/Seeder.php' => database_path('seeders/SykesSeeder.php'),
        ], 'sykes-seeds');
        
        //Show Pagination numbers.
        Paginator::useBootstrap();
    }
}