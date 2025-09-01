<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-6 space-y-8">

        <!-- KPIs -->
      <div class="bg-white shadow rounded-xl p-6">
    <h2 class="text-xl font-semibold text-gray-700 mb-6">📂 Document Approval Workflow</h2>

    <!-- Stepper -->
    <div class="flex items-center justify-between">
        @php
            $sequence = ['Employee','Section Head', 'Finance', 'Dean', 'Stores'];
            $currentStage = 'Employee'; // Example: dynamic stage from DB
        @endphp

        @foreach ($sequence as $stage)
            <div class="flex-1 flex items-center">
                <div class="relative flex flex-col items-center">
                    <!-- Circle Icon -->
                    <div
                        class="h-10 w-10 rounded-full flex items-center justify-center
                        {{ $stage == $currentStage ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600' }}">
                        @if($stage == 'Employee')
                            🧑🏽
                        @elseif($stage == 'Section Head')
                            👤
                        @elseif($stage == 'Finance')
                            💰
                        @elseif($stage == 'Dean')
                            👤
                        @elseif($stage == 'Stores')
                            📦
                        @endif
                    </div>
                    <!-- Label -->
                    <span class="mt-2 text-sm font-medium text-gray-700">{{ $stage }}</span>
                </div>

                <!-- Connector Line (except last) -->
                @if (!$loop->last)
                    <div class="flex-1 h-1
                        {{ $sequence[array_search($stage, $sequence)] == $currentStage ? 'bg-green-500' : 'bg-gray-300' }}">
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Status -->
    <div class="mt-6">
        <span class="px-4 py-2 rounded-lg bg-yellow-100 text-yellow-800 text-sm font-semibold">
            Current Stage: {{ $currentStage }}
        </span>
    </div>
</div>


        {{-- <!-- Kanban -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="bg-white shadow-sm rounded-xl p-5">
                <h3 class="font-semibold text-sm text-gray-600 mb-4">📥 Submitted</h3>
                <div id="col-submitted" class="space-y-3"></div>
            </div>
            <div class="bg-white shadow-sm rounded-xl p-5">
                <h3 class="font-semibold text-sm text-gray-600 mb-4">🔎 In Review</h3>
                <div id="col-review" class="space-y-3"></div>
            </div>
            <div class="bg-white shadow-sm rounded-xl p-5">
                <h3 class="font-semibold text-sm text-gray-600 mb-4">✅ Approved</h3>
                <div id="col-approved" class="space-y-3"></div>
            </div>
            <div class="bg-white shadow-sm rounded-xl p-5">
                <h3 class="font-semibold text-sm text-gray-600 mb-4">⛔ Rejected</h3>
                <div id="col-rejected" class="space-y-3"></div>
            </div>
        </div> --}}

        <!-- Workflow Steps -->
        {{-- <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-lg font-bold text-gray-700 text-center mb-6">📋 Workflow Dashboard</h2>

            <div class="space-y-4">
                <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                    <strong>Step 1:</strong> Upload Document → Pending Approval
                </div>
                <div class="p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                    <strong>Step 2:</strong> Department Review → Processing
                </div>
                <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded">
                    <strong>Step 3:</strong> Approval/Decline → Finalized
                </div>
            </div>
        </div> --}}

        <!-- Upload Section -->
@if (auth()->user() && auth()->user()->employee)
    <div class="bg-white shadow rounded-xl p-6 text-center">
        
        {{-- Upload button --}}
        <button id="toggle-upload-form"
                style="background-color:#007bff; 
                       color:white; 
                       padding:10px 20px; 
                       border:none; 
                       border-radius:5px; 
                       cursor:pointer;">
            📂 Upload Document
        </button>

        {{-- Upload Form (hidden by default) --}}
        <form id="upload-form" action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data"
      class="space-y-4 mt-4 hidden">
    @csrf

    {{-- Dropdown for type --}}
    <select name="type" required class="block w-full border rounded p-2">
        <option value="" disabled selected>-- Select Document Type --</option>
        @foreach(\App\Models\Document::ALLOWED_TYPES as $type)
            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
        @endforeach
    </select>

    {{-- File upload --}}
    <input type="file" name="file" required
           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                  file:rounded-full file:border-0 file:text-sm file:font-semibold
                  file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />

    <button type="submit"
            style="background-color:#28a745; 
                   color:white; 
                   padding:10px 20px; 
                   border:none; 
                   border-radius:5px; 
                   cursor:pointer;">
        Submit
    </button>
</form>

    </div>
@else
    <div class="upload-section bg-yellow-50 border border-yellow-300 p-4 rounded-md">
        <p class="text-yellow-700">
            You must complete your employee profile before uploading documents.
        </p>
    </div>
@endif

<!-- Document Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
    @foreach($documents as $doc)
        <div class="bg-white p-4 rounded shadow relative">
            <div class="font-semibold text-gray-700 mb-2">{{ ucfirst($doc->type) }}</div>
            <div class="text-sm text-gray-500 mb-2">Status: {{ ucfirst($doc->status) }}</div>

            <button class="view-btn text-blue-600 hover:underline text-sm"
                    data-doc-id="{{ $doc->doc_id }}">
                View
            </button>

            <!-- Hidden card for document details -->
            <div class="doc-card hidden absolute top-0 left-0 w-full h-full bg-white shadow-lg p-4 rounded z-10">
                <div class="mb-2"><strong>Uploaded By:</strong> {{ $doc->employee->name ?? 'Unknown' }}</div>
                <div class="mb-2"><strong>Department:</strong> {{ $doc->employee->department ?? 'N/A' }}</div>
                <div class="mb-2"><strong>Position:</strong> {{ $doc->employee->position ?? 'N/A' }}</div>
                <div class="mb-2"><strong>Uploaded At:</strong> {{ $doc->created_at->format('d M Y, H:i') }}</div>
                <div class="mb-2"><strong>Format:</strong> {{ $doc->format }}</div>

                <div class="mb-4">
                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                        View / Download File
                    </a>
                </div>

                <form action="{{ route('documents.destroy', $doc->doc_id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this document?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Delete Document</button>
                </form>

                <button class="close-btn mt-2 text-gray-500 hover:text-gray-700">Close</button>
            </div>
        </div>
    @endforeach
</div>

   
    </div>

@push('scripts')
<script>
    // Toggle upload form
   document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('toggle-upload-form');
  const form = document.getElementById('upload-form');
  if (btn && form) {
    btn.addEventListener('click', () => form.classList.toggle('hidden'));
  }
});

// toggle upload for view document card 
document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const card = this.closest('div').querySelector('.doc-card');
        card.classList.toggle('hidden');
    });
});

document.querySelectorAll('.close-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const card = this.closest('.doc-card');
        card.classList.add('hidden');
    });
});

    // Sample board items
    const items = [
        { id: 101, title: "Clearance Form — A. Banda", stage: "submitted" },
        { id: 102, title: "Attachment Letter — M. Ngoma", stage: "review" },
        { id: 103, title: "Recommendation — S. Mwila", stage: "approved" },
        { id: 104, title: "Clearance Form — T. Zulu", stage: "rejected" },
    ];

    function render() {
        ["submitted", "review", "approved", "rejected"].forEach(stage => {
            const col = document.getElementById(`col-${stage}`);
            if (!col) return; // avoid error if col not on page
            col.innerHTML = "";
            items.filter(i => i.stage === stage).forEach(it => {
                const div = document.createElement("div");
                div.className = "p-3 bg-gray-50 border border-gray-200 rounded-lg shadow-sm";
                div.textContent = `${it.title}`;
                col.appendChild(div);
            });
        });
    }

    render();
</script>
@endpush
</x-app-layout>
