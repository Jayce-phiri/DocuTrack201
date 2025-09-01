<?php

namespace App\Services;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    public function createDocument(array $data,$file = null): Document
    {
        if ($file) {
            // store file in storage/app/public/documents
            $path = $file->store('documents', 'public');
            $data['file_path'] = $path;
            $data['format'] = $file->getClientOriginalExtension(); // e.g. pdf, docx
        }

        $data['status'] = $data['status'] ?? 'submitted';

        return Document::create($data);
    }

    
    public function updateDocument(Document $document, array $data, $file = null): Document
    {
        if ($file) {
            // delete old file if exists
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $path = $file->store('documents', 'public');
            $data['file_path'] = $path;
        }

        $document->update($data);
        return $document;
    }

    public function getAllDocuments()
    {
        return Document::orderBy('created_at', 'desc')->get();
    }

    public function getDocumentById($id): ?Document
    {
        return Document::find($id);
    }

    public function deleteDocument(Document $document): bool
   {
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        return $document->delete();
    }
}