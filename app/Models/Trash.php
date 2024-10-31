<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trash extends Model
{
    protected $table = 'trashes';
    protected $fillable = ['picture', 'label', 'co', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
