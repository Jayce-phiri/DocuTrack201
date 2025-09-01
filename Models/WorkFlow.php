<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkFlow extends Model
{
    
    protected $fillable = [
        'document_id',
        'initiator_id',
        'origin_department',
        'destination_department',
        'action',
        'comments',
    ];

    public function initiator()
    {
        return $this->belongsTo(Employee::class, 'initiator_id', 'nrc');
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id', 'doc_id');
    }

    public function originDepartment()
    {
        return $this->belongsTo(Department::class, 'origin_department', 'department_code');
    }

    public function destinationDepartment()
    {
        return $this->belongsTo(Department::class, 'destination_department', 'department_code');
    }
}
