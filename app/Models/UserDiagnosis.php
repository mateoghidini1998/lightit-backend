<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDiagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'issue_name',
        'issue_ProfName',
        'issue_accuracy',
        'specialisations',
    ];

    public function user()
    {

        return $this->belongsTo(User::class);
    }
}
