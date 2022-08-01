<?php

namespace App\Observers;

use App\Establishment;
use App\Jobs\CreateIntegrationToken;

class TokenCreatorObserver
{
    /**
     * Handle the vtex update "created" event.
     *
     * @param  \App\Establishment  $Establishment
     * @return void
     */
    public function created(Establishment $Establishment)
    {
        CreateIntegrationToken::dispatch($Establishment);
    }

    /**
     * Handle the vtex update "updated" event.
     *
     * @param  \App\Establishment  $Establishment
     * @return void
     */
    public function updated(Establishment $Establishment)
    {
        //
    }

    /**
     * Handle the vtex update "deleted" event.
     *
     * @param  \App\Establishment  $Establishment
     * @return void
     */
    public function deleted(Establishment $Establishment)
    {
        //
    }

    /**
     * Handle the vtex update "restored" event.
     *
     * @param  \App\Establishment  $Establishment
     * @return void
     */
    public function restored(Establishment $Establishment)
    {
        //
    }

    /**
     * Handle the vtex update "force deleted" event.
     *
     * @param  \App\Establishment  $Establishment
     * @return void
     */
    public function forceDeleted(Establishment $Establishment)
    {
        //
    }
}