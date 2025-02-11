<x-guest-layout>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Gambar Latar & Logo -->
        <div class="hidden lg:flex lg:w-1/2 justify-center items-center mt-5">
            <img src="{{ asset('frontend/assets/images/login_img_2.jpg') }}" alt="login"
                class="object-cover w-full h-full" style="opacity: 0.8;"
                loading="lazy">

            <a href="/" class="absolute top-8 left-8">
                <img src="{{ asset('frontend/assets/images/logo.png') }}" alt="EduCore" class="h-12 md:h-16"  loading="lazy"
                     style="max-width: 200px">
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
                        <a href="{{ route('login') }}"
                            class="font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            Sign in here
                        </a>
                    </p>
                </div>

                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6" id="registerForm">
                    @csrf
                    <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

                    <!-- Email -->
                    <div class="mt-5">
                        <x-text-input id="email" class="w-full pl-10" type="email" name="email"
                            placeholder="Email address" :value="old('email')" required />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mt-5">
                        <x-text-input id="password" class="w-full pl-10" type="password" name="password"
                            placeholder="Password" required />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-5">
                        <x-text-input id="password_confirmation" class="w-full pl-10" type="password"
                            name="password_confirmation" placeholder="Confirm Password" required />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                   <!-- Occupation -->
                   <div class="mt-5">
                        <x-input-label for="occupation" :value="__('Occupation')" />
                        <x-text-input id="occupation" class="block mt-1 w-full" type="text" name="occupation"
                           :value="old('occupation')" required />
                        <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                   </div>

                   <!-- Role Selection -->
                   <div class="mt-5 relative">
                      <select id="role" name="role"
                            class="w-full pl-10 pr-3 py-3 rounded-lg border border-gray-200 focus:border-blue-500
                            focus:ring-2 focus:ring-blue-200 transition-all appearance-none bg-white
                            text-gray-700 placeholder-gray-400">
                         <option value="">Select Your Role</option>
                            <option value="employee">Employee</option>
                            <option value="admin">Admin</option>
                           <option value="teacher">Teacher</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                       </div>
                   </div>
                    <!-- Avatar Upload -->
                    <div class="mt-5">
                        <input id="avatar" type="file" name="avatar"
                            class="w-full file:hidden absolute opacity-0 cursor-pointer" accept="image/*">
                        <label for="avatar"
                            class="block w-full px-4 py-3 border-2 border-dashed border-gray-200 rounded-lg
                                   hover:border-blue-400 transition-colors cursor-pointer text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-600">Upload Profile Photo</span>
                            </div>
                         </label>
                          <div id="avatarPreviewContainer" class="mt-2 hidden">
                             <img id="avatarPreview" src="#" alt="Avatar Preview" class="rounded-lg w-24 h-24 object-cover mx-auto">
                        </div>
                    </div>

                    <!-- Employee Specific Fields -->
                    <div id="employeeFields" class="space-y-6 mt-4 hidden">
                        <!-- NIK -->
                        <div>
                            <x-input-label for="nik" :value="__('NIK')" />
                            <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik"
                                :value="old('nik')" placeholder="{{ __('NIK') }}" />
                            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                        </div>
                        <!-- Gender -->
                        <div>
                            <x-input-label for="gender" :value="__('Gender')" />
                            <select id="gender" name="gender"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>
                        <!-- Date of Birth -->
                        <div>
                            <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                            <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date"
                                name="date_of_birth" :value="old('date_of_birth')" placeholder="{{ __('Date of Birth') }}" />
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                        </div>
                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                                :value="old('address')" placeholder="{{ __('Address') }}" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                        <!-- Phone Number -->
                        <div>
                            <x-input-label for="phone_number" :value="__('Phone Number')" />
                            <x-text-input id="phone_number" class="block mt-1 w-full" type="text"
                                name="phone_number" :value="old('phone_number')" placeholder="{{ __('Phone Number') }}" />
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                       </div>
                         <!-- Division -->
                        <div>
                            <x-input-label for="division" :value="__('Division')" />
                            <x-text-input id="division" class="block mt-1 w-full" type="text" name="division"
                                :value="old('division')" placeholder="{{ __('Division') }}" />
                            <x-input-error :messages="$errors->get('division')" class="mt-2" />
                        </div>
                         <!-- Position -->
                         <div>
                             <x-input-label for="position" :value="__('Position')" />
                             <x-text-input id="position" class="block mt-1 w-full" type="text" name="position"
                                  :value="old('position')" placeholder="{{ __('Position') }}" />
                            <x-input-error :messages="$errors->get('position')" class="mt-2" />
                        </div>
                         <!-- Employment Status -->
                       <div>
                             <x-input-label for="employment_status" :value="__('Employment Status')" />
                             <select id="employment_status" name="employment_status"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                  <option value="Permanent">Permanent</option>
                                 <option value="Contract">Contract</option>
                                 <option value="Internship">Internship</option>
                            </select>
                              <x-input-error :messages="$errors->get('employment_status')" class="mt-2" />
                         </div>
                       <!-- Join Date -->
                        <div>
                              <x-input-label for="join_date" :value="__('Join Date')" />
                             <x-text-input id="join_date" class="block mt-1 w-full" type="date" name="join_date"
                                :value="old('join_date')" placeholder="{{ __('Join Date') }}" />
                            <x-input-error :messages="$errors->get('join_date')" class="mt-2" />
                         </div>
                    </div>
                     <!-- Teacher Specific Fields -->
                   <div id="teacherFields" class="space-y-6 mt-4 hidden">
                        <!-- Sertifikat Mengajar -->
                        <div>
                             <x-input-label for="certificate" :value="__('Teaching Certificate (PDF, DOC, DOCX, JPEG, PNG, JPG, max 5MB)')" />
                            <x-text-input id="certificate" class="block mt-1 w-full" type="file"
                                name="certificate" accept=".pdf,.doc,.docx,.jpeg,.png,.jpg" />
                            <x-input-error :messages="$errors->get('certificate')" class="mt-2" />
                        </div>
                         <!-- CV/Dokumen Kualifikasi -->
                        <div>
                           <x-input-label for="cv" :value="__('Curriculum Vitae (PDF, DOC, DOCX, max 5MB)')" />
                            <x-text-input id="cv" class="block mt-1 w-full" type="file" name="cv"
                               accept=".pdf,.doc,.docx" />
                            <x-input-error :messages="$errors->get('cv')" class="mt-2" />
                        </div>
                        <!-- Specialization -->
                        <div>
                            <x-input-label for="specialization" :value="__('Specialization')" />
                            <x-text-input id="specialization" class="block mt-1 w-full" type="text"
                                 name="specialization" :value="old('specialization')" placeholder="{{ __('Specialization') }}" />
                            <x-input-error :messages="$errors->get('specialization')" class="mt-2" />
                       </div>
                   </div>
                     <!-- Terms -->
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="terms" name="terms" required
                            class="mt-1 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                         <label for="terms" class="text-sm text-gray-600">
                             I agree to the <a href="#" class="text-blue-600 hover:underline">Terms of
                                Service</a> and
                            <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                         </label>
                     </div>
                     <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-3.5 px-6 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700
                               hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg
                               transition-all duration-300 transform hover:-translate-y-0.5">
                        Create Free Account
                   </button>
                </form>
           </x-auth-card>
      </div>
  </div>
</x-guest-layout>

<script>
    document.getElementById('role').addEventListener('change', function() {
      const role = this.value;
      const employeeFields = document.getElementById('employeeFields');
      const teacherFields = document.getElementById('teacherFields');
        employeeFields.classList.add('hidden');
        teacherFields.classList.add('hidden');

        if (role === 'employee') {
            employeeFields.classList.remove('hidden');
        } else if (role === 'teacher') {
           teacherFields.classList.remove('hidden');
        }
    });

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
    const registerForm = document.getElementById('registerForm');
      registerForm.addEventListener('submit', function(event) {
       alert('thnks you.');
    });
</script>
