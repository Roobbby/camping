<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camping extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'camping';

    public function images()
    {
        return $this->hasMany(Image::class, 'cover');
    }


}
