<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArsipHeader extends Model
{
    protected $fillable = ['tahun', 'tentang', 'user_id'];

    public function details()
    {
        return $this->hasMany(ArsipDetail::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
