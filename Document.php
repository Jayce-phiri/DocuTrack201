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
    'title', 
    'type', 
    'name', 
    'format'
];
}
