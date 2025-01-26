<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('New Teacher') }}
            </h2>
            <a href="{{ route('admin.teachers.index') }}"
                class="font-bold py-3 px-6 bg-gray-500 hover:bg-gray-600 text-white rounded-md transition-all">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.teachers.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email User')" />
                        <div class="flex">
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                   <div id="documentSection" class="hidden">
                        <div class="mb-4">
                            <x-input-label for="certificate" :value="__('Teaching Certificate (PDF/DOC/JPEG/PNG)')" />
                            <div class="flex">
                                <x-text-input id="certificate" class="block mt-1 w-full" type="file" name="certificate"
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" />
                                <x-input-error :messages="$errors->get('certificate')" class="mt-2" />
                                <a id="existingCertificate" href="#" target="_blank"
                                   class="ml-2 text-indigo-500 hover:text-indigo-700 hidden">View Existing</a>
                                 <input type="hidden" name="use_existing" id="use_existing" value="0">
                            </div>
                        </div>


                        <div class="mb-4">
                            <x-input-label for="cv" :value="__('Curriculum Vitae (PDF/DOC)')" />
                            <div class="flex">
                                <x-text-input id="cv" class="block mt-1 w-full" type="file" name="cv"
                                  accept=".pdf,.doc,.docx" />
                                <x-input-error :messages="$errors->get('cv')" class="mt-2" />
                                <a id="existingCv" href="#" target="_blank"
                                   class="ml-2 text-indigo-500 hover:text-indigo-700 hidden">View Existing</a>
                            </div>
                        </div>

                    <div class="mb-4">
                        <x-input-label for="activate" :value="__('Activate Immediately')" />
                        <x-checkbox-input id="activate" name="activate" />
                        <x-input-error :messages="$errors->get('activate')" class="mt-2" />
                    </div>
                    <x-primary-button>
                        {{ __('Save Teacher') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('email').addEventListener('blur', function() {
        const email = this.value;
        const documentSection = document.getElementById('documentSection');
        const existingCertificateLink = document.getElementById('existingCertificate');
        const existingCvLink = document.getElementById('existingCv');
        const useExistingCheckbox = document.getElementById('use_existing');


        if (email) {
            fetch('{{ route('admin.teachers.check-documents') }}?email=' + email)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        documentSection.classList.remove('hidden');

                        if (data.certificate) {
                            existingCertificateLink.href = data.certificate;
                            existingCertificateLink.classList.remove('hidden');
                             useExistingCheckbox.value = 1; // Set value for existing documents
                        } else {
                            existingCertificateLink.classList.add('hidden');
                             useExistingCheckbox.value = 0;
                        }

                        if (data.cv) {
                            existingCvLink.href = data.cv;
                            existingCvLink.classList.remove('hidden');

                        } else {
                            existingCvLink.classList.add('hidden');
                        }

                    } else {
                        documentSection.classList.add('hidden');
                        existingCertificateLink.classList.add('hidden');
                        existingCvLink.classList.add('hidden');
                         useExistingCheckbox.value = 0;

                    }
                });
        } else {
            documentSection.classList.add('hidden');
            existingCertificateLink.classList.add('hidden');
            existingCvLink.classList.add('hidden');
             useExistingCheckbox.value = 0;
        }
    });
</script>
