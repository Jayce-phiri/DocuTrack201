<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'nrc';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'nrc',
        'email',
        'position',
        'department_code',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_code', 'department_code');
    }
    public function user (){
        return $this->belongsTo(User::class);
    }
}
