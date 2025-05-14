<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('products');
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->product->id,
            'name' => $this->product->name,
            'created_at' => $this->product->created_at->toDateTimeString(),
            'deletor' => $this->product->deletor->name,
        ];
    }

    public function broadcastAs(): string
    {
        return 'product.deleted';
    }
}
