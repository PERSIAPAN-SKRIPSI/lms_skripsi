<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-900 leading-tight"> {{-- Ukuran font header lebih besar --}}
            {{ __('Detail Opsi') }} <span class="text-indigo-600">{{ $question->question }}</span>
        </h2>
        <p class="text-gray-500 text-sm">Informasi lengkap mengenai opsi jawaban.</p> {{-- Deskripsi detail --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-2xl overflow-hidden"> {{-- Shadow dan radius lebih besar --}}
                <div class="px-6 py-6 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200"> {{-- Gradient header --}}
                    <h3 class="text-lg font-medium text-gray-900">
                        Informasi Opsi
                    </h3>
                </div>
                <div class="p-6 space-y-6"> {{-- Spasi antar detail lebih besar --}}
                    <div>
                        <dt class="text-sm font-semibold text-gray-700"> {{-- Label detail lebih tebal --}}
                            Teks Opsi
                        </dt>
                        <dd class="mt-1 text-lg text-gray-900"> {{-- Text detail lebih besar --}}
                            {{ $option->option_text }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-semibold text-gray-700"> {{-- Label detail lebih tebal --}}
                            Jawaban Benar?
                        </dt>
                        <dd class="mt-1 text-lg text-gray-900"> {{-- Text detail lebih besar --}}
                            {{ $option->is_correct ? 'Ya' : 'Tidak' }}
                        </dd>
                    </div>

                    <div class="flex justify-start gap-2"> {{-- Gunakan gap untuk jarak tombol --}}
                        <a href="{{ route('admin.options.edit', [$quiz->id, $question->id, $option->id]) }}"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm font-semibold text-sm rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                            Edit Opsi
                        </a>
                        <a href="{{ route('admin.options.index', [$quiz->id, $question->id]) }}"
                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm font-semibold text-sm rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-200">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
