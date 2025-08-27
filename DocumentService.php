<?php

namespace App\Services;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    public function createDocument(array $data): Document
    {
        
        return Document::create($data);
    }

    public function updateDocument(Document $document, array $data): Document
    {
        $document->update($data);
        return $document;
    }

    public function getAllDocuments()
    {
        return Document::all();
    }

    public function getDocumentById($id): ?Document
    {
        return Document::find($id);
    }

    public function deleteDocument(Document $document): bool
    {
        return $document->delete();
    }
}