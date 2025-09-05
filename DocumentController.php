<?php

namespace App\Http\Controllers;
use App\Services\DocumentService;
use App\Models\Document;
use App\Http\Requests\DocumentRequest;

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
 public function dashboard()
{
    $documents = $this->documentService->getAllDocuments();
    return view('dashboard', compact('documents'));
}


    public function show($id)
    {
        $document = $this->documentService->getDocumentById($id);
        return response()->json($document);
    }
//for rendering the document in the dashboard
    public function showDocument($id)
{
    $document = $this->documentService->getDocumentById($id);

    if (!$document) {
        abort(404, 'Document not found');
    }

    // Load employee relationship if it exists
    $document->load('employee');

    return view('documents.show', compact('document'));
}


public function store(DocumentRequest $request)
{
    // dd($request->validated()); // Debug inputs first

    try {
        $validatedData = $request->validated();
        $file = $request->file('file');

        $user = $request->user();

        $validatedData['employee_nrc'] = $user->employee->nrc;

        // Set current department (from employee relation)
        $validatedData['current_department'] = $user->employee->department_code; 

        $validatedData['status'] = 'submitted';

        $document = $this->documentService->createDocument($validatedData, $file);

        return redirect()->route('dashboard')
            ->with('success', 'Document uploaded successfully!');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Upload failed: ' . $e->getMessage())
            ->withInput();
    }
}


    public function update(DocumentRequest $request, $id)
    {
        $document = $this->documentService->getDocumentById($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        $file = $request->file('file');
        $updatedDocument = $this->documentService->updateDocument($document, $request->validated(), $file);

        return response()->json($updatedDocument);
    }

  public function destroy(Document $doc)
{
    $this->documentService->deleteDocument($doc);

    return redirect()->route('dashboard')->with('success', 'Document deleted successfully.');
}
}
