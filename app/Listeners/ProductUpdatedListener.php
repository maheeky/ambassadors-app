<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductUpdatedListener
{
    /**
     * Clear the front and back end cache upon an event updating
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ProductUpdatedEvent $event)
    {
        \Cache::forget('products_frontend');
        \Cache::forget('products_backend');
    }
}
