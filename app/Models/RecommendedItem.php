<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendedItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function camping()
    {
        return $this->belongsTo(Camping::class, 'camping_id');
    }

    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class);
    }
}
