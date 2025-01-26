<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Occupation -->
        <div class="mt-4">
            <x-input-label for="occupation" :value="__('Occupation')" />
            <x-text-input id="occupation" class="block mt-1 w-full" type="text" name="occupation" :value="old('occupation')"
                required />
            <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
        </div>

        <!-- Avatar -->
        <div class="mt-4">
            <x-input-label for="avatar" :value="__('Avatar')" />
            <x-text-input id="avatar" class="block mt-1 w-full" type="file" name="avatar" required />
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required>
                <option value="employee">Employee</option>
                 <option value="admin">Admin</option>
                <option value="teacher">Teacher</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>


        <!-- Employee Specific Fields -->
        <div id="employeeFields" class="space-y-6 mt-4 hidden">
            <!-- NIK -->
            <div>
                <x-input-label for="nik" :value="__('NIK')" />
                <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')"
                    placeholder="{{ __('NIK') }}" />
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
                <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth"
                    :value="old('date_of_birth')" placeholder="{{ __('Date of Birth') }}" />
                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
            </div>

            <!-- Address -->
            <div>
                <x-input-label for="address" :value="__('Address')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"
                    placeholder="{{ __('Address') }}" />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>
            <!-- Phone Number -->
            <div>
                <x-input-label for="phone_number" :value="__('Phone Number')" />
                <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number"
                    :value="old('phone_number')" placeholder="{{ __('Phone Number') }}" />
                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
            </div>

            <!-- Division -->
            <div>
                <x-input-label for="division" :value="__('Division')" />
                <x-text-input id="division" class="block mt-1 w-full" type="text" name="division" :value="old('division')"
                    placeholder="{{ __('Division') }}" />
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
                <x-text-input id="certificate" class="block mt-1 w-full" type="file" name="certificate"
                accept=".pdf,.doc,.docx,.jpeg,.png,.jpg" />
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
                    <x-text-input id="specialization" class="block mt-1 w-full" type="text" name="specialization"
                        :value="old('specialization')" placeholder="{{ __('Specialization') }}" />
                    <x-input-error :messages="$errors->get('specialization')" class="mt-2" />
                </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
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
</script>
