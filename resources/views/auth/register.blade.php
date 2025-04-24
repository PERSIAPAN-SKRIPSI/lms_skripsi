<x-guest-layout>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Gambar Latar & Logo -->
        <div class="hidden lg:flex lg:w-1/2 justify-center items-center relative">
            <img class="object-cover w-full h-full opacity-80"
                src="{{ asset('frontend/assets/images/login_img_2.jpg') }}" alt="login" loading="lazy">

            <a class="absolute top-8 left-8" href="/">
                <img class="h-12 md:h-16 max-w-xs" src="{{ asset('frontend/assets/images/logo.png') }}"
                    alt="EduCore" loading="lazy">
            </a>
        </div>

        <!-- Right Side Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gradient-to-br from-gray-50 to-white">
            <x-auth-card class="w-full max-w-lg p-8 bg-white rounded-2xl shadow-xl">
                <div class="text-center mb-10">
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
                        Join <span
                            class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-500">EduCore</span>
                    </h1>
                    <p class="text-gray-500 mt-4">
                        Already a member?
                        <a class="font-semibold text-blue-600 hover:text-blue-800 transition-colors"
                            href="{{ route('login') }}">
                            Sign in here
                        </a>
                    </p>
                </div>

                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form class="space-y-6" id="registerForm" method="POST" action="{{ route('register') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <div class="relative">
                            <x-text-input class="w-full pl-10" id="name" name="name" type="text"
                                placeholder="Full name" :value="old('name')" required autofocus
                                autocomplete="name" />
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="relative mt-4">
                        <x-text-input class="w-full pl-10" id="email" name="email" type="email"
                            placeholder="Email address" :value="old('email')" required />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <x-text-input class="w-full pl-10" id="password" name="password" type="password"
                            placeholder="Password" required />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative">
                        <x-text-input class="w-full pl-10" id="password_confirmation" name="password_confirmation"
                            type="password" placeholder="Confirm Password" required />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Occupation -->
                    <div>
                        <x-input-label for="occupation" :value="__('Occupation')" />
                        <x-text-input class="block mt-1 w-full" id="occupation" name="occupation" type="text"
                            :value="old('occupation')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('occupation')" />
                    </div>

                    <!-- Role Selection -->
                    <div class="relative">
                        <select
                            class="w-full pl-10 pr-3 py-3 rounded-lg border border-gray-200 focus:border-blue-500
                                        focus:ring-2 focus:ring-blue-200 transition-all appearance-none bg-white
                                        text-gray-700 placeholder-gray-400"
                            id="role" name="role">
                            <option value="">Select Your Role</option>
                            <option value="employee">Employee</option>
                            {{-- <option value="admin">Admin</option> --}}
                            <option value="teacher">Teacher</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <!-- Avatar Upload -->
                    <div>
                        <input class="sr-only" id="avatar" name="avatar" type="file" accept="image/*">
                        <label
                            class="block w-full px-4 py-3 border-2 border-dashed border-gray-200 rounded-lg
                                       hover:border-blue-400 transition-colors cursor-pointer text-center"
                            for="avatar">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-600">Upload Profile Photo</span>
                            </div>
                        </label>
                        <div class="mt-2 hidden" id="avatarPreviewContainer">
                            <img class="rounded-lg w-24 h-24 object-cover mx-auto" id="avatarPreview" src="#"
                                alt="Avatar Preview">
                        </div>
                    </div>

                    <!-- Employee Specific Fields -->
                    <div class="space-y-6 mt-4 hidden" id="employeeFields">
                        <!-- NIK -->
                        <div>
                            <x-input-label for="nik" :value="__('NIK')" />
                            <x-text-input class="block mt-1 w-full" id="nik" name="nik" type="text"
                                :value="old('nik')" placeholder="{{ __('NIK') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                        </div>
                        <!-- Gender -->
                        <div>
                            <x-input-label for="gender" :value="__('Gender')" />
                            <select
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                id="gender" name="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                        </div>
                        <!-- Date of Birth -->
                        <div>
                            <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                            <x-text-input class="block mt-1 w-full" id="date_of_birth" name="date_of_birth"
                                type="date" :value="old('date_of_birth')" placeholder="{{ __('Date of Birth') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
                        </div>
                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input class="block mt-1 w-full" id="address" name="address" type="text"
                                :value="old('address')" placeholder="{{ __('Address') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>
                        <!-- Phone Number -->
                        <div>
                            <x-input-label for="phone_number" :value="__('Phone Number')" />
                            <x-text-input class="block mt-1 w-full" id="phone_number" name="phone_number"
                                type="text" :value="old('phone_number')" placeholder="{{ __('Phone Number') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                        </div>
                        <!-- Division -->
                        <div>
                            <x-input-label for="division" :value="__('Division')" />
                            <x-text-input class="block mt-1 w-full" id="division" name="division" type="text"
                                :value="old('division')" placeholder="{{ __('Division') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('division')" />
                        </div>
                        <!-- Position -->
                        <div>
                            <x-input-label for="position" :value="__('Position')" />
                            <x-text-input class="block mt-1 w-full" id="position" name="position" type="text"
                                :value="old('position')" placeholder="{{ __('Position') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('position')" />
                        </div>
                        <!-- Employment Status -->
                        <div>
                            <x-input-label for="employment_status" :value="__('Employment Status')" />
                            <select
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                id="employment_status" name="employment_status">
                                <option value="Permanent">Permanent</option>
                                <option value="Contract">Contract</option>
                                <option value="Internship">Internship</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('employment_status')" />
                        </div>
                        <!-- Join Date -->
                        <div>
                            <x-input-label for="join_date" :value="__('Join Date')" />
                            <x-text-input class="block mt-1 w-full" id="join_date" name="join_date" type="date"
                                :value="old('join_date')" placeholder="{{ __('Join Date') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('join_date')" />
                        </div>
                    </div>
                    <!-- Teacher Specific Fields -->
                    <div class="space-y-6 mt-4 hidden" id="teacherFields">
                        <!-- Sertifikat Mengajar -->
                        <div>
                            <x-input-label for="certificate"
                                :value="__('Teaching Certificate (PDF, DOC, DOCX, JPEG, PNG, JPG, max 5MB)')" />
                            <x-text-input class="block mt-1 w-full" id="certificate" name="certificate"
                                type="file" accept=".pdf,.doc,.docx,.jpeg,.png,.jpg" />
                            <x-input-error class="mt-2" :messages="$errors->get('certificate')" />
                        </div>
                        <!-- CV/Dokumen Kualifikasi -->
                        <div>
                            <x-input-label for="cv" :value="__('Curriculum Vitae (PDF, DOC, DOCX, max 5MB)')" />
                            <x-text-input class="block mt-1 w-full" id="cv" name="cv" type="file"
                                accept=".pdf,.doc,.docx" />
                            <x-input-error class="mt-2" :messages="$errors->get('cv')" />
                        </div>
                    </div>
                    <!-- Terms -->
                    <div class="flex items-start space-x-3">
                        <input class="mt-1 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            id="terms" name="terms" type="checkbox" required>
                        <label class="text-sm text-gray-600" for="terms">
                            I agree to the <a class="text-blue-600 hover:underline" href="#">Terms of
                                Service</a> and
                            <a class="text-blue-600 hover:underline" href="#">Privacy Policy</a>
                        </label>
                    </div>
                    <!-- Submit Button -->
                    <button
                        class="w-full py-3.5 px-6 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700
                                    hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg
                                    transition-all duration-300 transform hover:-translate-y-0.5"
                        type="submit">
                        Create Free Account
                    </button>
                </form>
            </x-auth-card>
        </div>
    </div>
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const employeeFields = document.getElementById('employeeFields');
        const teacherFields = document.getElementById('teacherFields');
        const employeeInputs = employeeFields.querySelectorAll('input, select');
        const teacherInputs = teacherFields.querySelectorAll('input');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');

        function hideAllFields() {
            employeeFields.classList.add('hidden');
            teacherFields.classList.add('hidden');
        }

        function removeAllRequired() {
            employeeInputs.forEach(input => {
                input.removeAttribute('required');
                input.required = false; // For better cross-browser compatibility
            });
            teacherInputs.forEach(input => {
                input.removeAttribute('required');
                input.required = false;
            });
        }

        function showEmployeeFields() {
            employeeFields.classList.remove('hidden');
            document.getElementById('nik').setAttribute('required', 'required');
            document.getElementById('nik').required = true;
            document.getElementById('gender').setAttribute('required', 'required');
            document.getElementById('gender').required = true;
            document.getElementById('date_of_birth').setAttribute('required', 'required');
            document.getElementById('date_of_birth').required = true;
            document.getElementById('address').setAttribute('required', 'required');
            document.getElementById('address').required = true;
            document.getElementById('phone_number').setAttribute('required', 'required');
            document.getElementById('phone_number').required = true;
            document.getElementById('division').setAttribute('required', 'required');
            document.getElementById('division').required = true;
            document.getElementById('position').setAttribute('required', 'required');
            document.getElementById('position').required = true;
            document.getElementById('employment_status').setAttribute('required', 'required');
            document.getElementById('employment_status').required = true;
            document.getElementById('join_date').setAttribute('required', 'required');
            document.getElementById('join_date').required = true;
        }

        function showTeacherFields() {
            teacherFields.classList.remove('hidden');
            document.getElementById('certificate').setAttribute('required', 'required');
            document.getElementById('certificate').required = true;
            document.getElementById('cv').setAttribute('required', 'required');
            document.getElementById('cv').required = true;
        }

        function handleRoleChange() {
            hideAllFields();
            removeAllRequired();

            const role = roleSelect.value;

            if (role === 'employee') {
                showEmployeeFields();
            } else if (role === 'teacher') {
                showTeacherFields();
            }
        }

        roleSelect.addEventListener('change', handleRoleChange);

        // Initial call to handleRoleChange in case the page is loaded with a pre-selected role
        handleRoleChange();

        // Avatar preview handling
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatarPreview');
        const avatarPreviewContainer = document.getElementById('avatarPreviewContainer');

        avatarInput.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                    avatarPreviewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                avatarPreview.src = '#';
                avatarPreviewContainer.classList.add('hidden');
            }
        });

        confirmPassword.addEventListener('input', function() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity("Passwords do not match");
            } else {
                confirmPassword.setCustomValidity('');
            }
        });

        password.addEventListener('input', function() {
            confirmPassword.dispatchEvent(new Event('input'));
        });
    });
</script>
