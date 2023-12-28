<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDevelopmentNeed extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'business_types_id', 'business_name', 'is_registered', 'business_address', 'duration', 'business_trainings_id',
        'location_of_training', 'current_revenue', 'access_to_finance', 'type_of_finance', 'bank_usage', 'male_employed', 'female_employed',
        'digitalized', 'digital_usage', 'created_by', 'updated_by'
    ];
}
