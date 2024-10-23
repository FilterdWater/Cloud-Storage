<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    // Define which columns are mass assignable
    protected $fillable = ['file_id', 'owner_email', 'recipient_email'];

    // Define the relationship with the File model
    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
