<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnswerDetail extends Model
{
    protected $casts = [
        'judgment' => 'boolean'
    ];
}
