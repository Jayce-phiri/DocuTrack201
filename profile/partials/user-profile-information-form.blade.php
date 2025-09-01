<section class="max-w-2xl mx-auto mt-6">
    <header class="mb-4">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('User Profile Information') }}
        </h2>
       
    </header>

    <div class="bg-white shadow rounded-xl p-6 space-y-4">
        <div class="flex items-center space-x-4">
            {{-- <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-xl font-bold text-gray-500">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div> --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Name: {{ Auth::user()->name }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-gray-700">
            <div>
                <span class="font-semibold">NRC:</span> {{ Auth::user()->nrc ?? Auth::user()->employee?->nrc }}
            </div>
            <div>
                <span class="font-semibold">Position:</span> {{ Auth::user()->employee?->position ?? '-' }}
            </div>
            <div>
                <span class="font-semibold">Department:</span> {{ Auth::user()->employee?->department_code ?? '-' }}
            </div>
            <div>
                <span class="font-semibold">Email:</span> {{ Auth::user()->email }}
            </div>
        </div>
    </div>
</section>
