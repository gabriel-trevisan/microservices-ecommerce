<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['customer_id'];

    /**
     * Define a relação com os itens do carrinho.
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
