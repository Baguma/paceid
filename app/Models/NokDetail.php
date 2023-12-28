<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NokDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname', 'lname', 'phone1', 'phone2', 'relationship', 'address', 'studentid', 'created_by', 'updated_by'
    ];
}
