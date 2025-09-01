<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    use HasFactory; 
    protected $primaryKey = 'doc_id';
    protected $keyType = 'int';
    public $incrementing = true;

    public const ALLOWED_TYPES = [
        'clearanceForm',
        'AttachmentLetter',
        'RecommendationLetter'
    ];

    protected $fillable = [
    
    'type', 
    'format',
    'status',
    'file_path',

];

public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_nrc', 'nrc');
}

}
