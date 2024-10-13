<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    // Allow mass assignment of the 'name', 'path', and 'user_id' fields
    protected $fillable = ['name', 'path', 'user_id'];

    // Define the relationship between files and users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
