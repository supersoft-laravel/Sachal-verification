<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_name',
        'training_name',
        'start_date',
        'end_date',
        'course_type',
        'status',
        'certificate_id',
    ];
}
