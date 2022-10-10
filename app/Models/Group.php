<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function Users()
    {
        return $this->hasMany(User::class);
    }

    public static function getAllOrderByUpdated_at()
    {
        return self::orderBy('updated_at', 'desc')->get();
    }
}
