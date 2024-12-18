<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
class Comment extends Model
{
    protected $fillable = [
        'comment',
        'user_id',
        'product_id',
    ];


    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }
}