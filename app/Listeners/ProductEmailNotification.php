<?php

namespace App\Listeners;

use App\Events\ProductDeleted;
use App\Jobs\NotifyCreatedProductJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductEmailNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ProductDeleted $event)
    {
        $product = $event->product;
        $email = auth()->user()->email;
        NotifyCreatedProductJob::dispatch($product->article, $email);
    }
}
