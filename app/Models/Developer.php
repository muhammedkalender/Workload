<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    public $timestamps = null;

    public function Jobs()
    {
        return $this->hasMany('App\Models\Job', 'difficult', 'difficult')
            ->orderBy('estimated_duration');
    }
}
