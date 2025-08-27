<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    private DocumentService $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function index()
    {
        $documents = $this->documentService->getAllDocuments();
        return response()->json($documents);
    }

    public function show($id)
    {
        $document = $this->documentService->getDocumentById($id);
        return response()->json($document);
    }

    public function store(Request $request)
    {
        $document = $this->documentService->createDocument($request->all());
        return response()->json($document, 201);
    }

    public function update(Request $request, $id)
    {
        $document = $this->documentService->getDocumentById($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        $updatedDocument = $this->documentService->updateDocument($document, $request->all());
        return response()->json($updatedDocument);
    }

    public function destroy($id)
    {
        $document = $this->documentService->getDocumentById($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        $this->documentService->deleteDocument($document);
        return response()->json(['message' => 'Document deleted successfully']);
    }
}
