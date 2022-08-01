<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use App\Establishment;
use App\Observers\TokenCreatorObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Verifica se há um novo VtexJob e roda o comando
        Establishment::observe(TokenCreatorObserver::class);

        // Implement novas opções de query builder
        QueryBuilder::macro(
            'whereNotEmpty',
            function (string $column) {
                return $this->whereNotNull($column)
                    ->where($column, '<>', '');
            }
        );

        EloquentBuilder::macro(
            'whereNotEmpty',
            function (string $column) {
                return $this->getQuery()
                    ->whereNotEmpty($column);
            }
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
