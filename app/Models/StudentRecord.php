<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentRecord extends Eloquent
{
    use HasFactory;

    protected $fillable = [
        'session', 'user_id', 'my_class_id', 'section_id', 'my_parent_id', 'dorm_id', 'dorm_room_no', 'adm_no',
        'year_admitted', 'wd', 'wd_date', 'grad', 'grad_date', 'house', 'age', 'marital_status', 'occupation',
        'education_level', 'district_residence', 'subcounty_residence', 'parish_residence', 'village_residence',
        'district_home', 'subcounty_home', 'parish_home', 'village_home', 'challenge', 'challenge_notes', 'support',
        'support_notes', 'nin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function my_parent()
    {
        return $this->belongsTo(User::class);
    }

    public function my_class()
    {
        return $this->belongsTo(MyClass::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }
}
