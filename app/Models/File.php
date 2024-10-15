<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;

    // Allow mass assignment of the 'name', 'path', and 'user_id' fields
    protected $fillable = ['name', 'path', 'user_id'];

    // 'deleted_at' column for soft deletes
    protected $dates = ['deleted_at'];

    // Define the relationship between files and users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
