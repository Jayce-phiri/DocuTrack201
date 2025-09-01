<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model

{
    protected $primaryKey = 'department_code';
    protected $keyType = 'string';
    public $incrementing = false;

    public const ALLOWED_DEPARTMENTS_NAMES = ['Section_Head', 'Finance', 'DEAN', 'stores'];
    protected $fillable =[
        'department_code',
        'name',
        'description',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_code', 'department_code');
    }
}
