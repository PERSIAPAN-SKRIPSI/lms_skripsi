{{-- resources/views/components/sidebar.blade.php --}}
<x-perfect-scrollbar
   class="flex flex-col flex-1 gap-4 px-3 py-6 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
   aria-label="main" as="nav">

   <div class="space-y-6">
      @if (auth()->user()->hasRole('admin'))
         <div>
            <h3 class="font-semibold text-gray-900 mb-3 px-3 leading-tight dark:text-white">ADMINISTRATION</h3>
            <x-sidebar.link href="{{ route('admin.dashboard') }}" title="Dashboard" :isActive="request()->routeIs('admin.dashboard')">
               <x-slot name="icon">
                  <x-icons.dashboard class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400" aria-hidden="true" />
               </x-slot>
            </x-sidebar.link>

            <x-sidebar.dropdown title="Course Management" :isActive="Str::startsWith(request()->route()->getName(), 'admin.courses.') ||
                Str::startsWith(request()->route()->getName(), 'admin.categories.')">
               <x-slot name="icon">
                  <x-heroicon-o-collection class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400"
                     aria-hidden="true" />
               </x-slot>
               <x-sidebar.sublink href="{{ route('admin.courses.index') }}" title="Courses" :isActive="request()->routeIs('admin.courses.index')" />
               <x-sidebar.sublink href="{{ route('admin.categories.index') }}" title="Categories" :isActive="request()->routeIs('admin.categories.index')" />
            </x-sidebar.dropdown>

            <x-sidebar.dropdown title="Teacher Management" :isActive="Str::startsWith(request()->route()->getName(), 'admin.teachers.')">
               <x-slot name="icon">
                  <x-heroicon-o-user-group class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400"
                     aria-hidden="true" />
               </x-slot>
               <x-sidebar.sublink href="{{ route('admin.teachers.index') }}" title="Teachers" :isActive="request()->routeIs('admin.teachers.index')" />
            </x-sidebar.dropdown>

            {{-- Tambahkan dropdown untuk Quiz Management --}}
            <x-sidebar.dropdown title="Quiz Management" :isActive="Str::startsWith(request()->route()->getName(), 'admin.quizzes.')">
               <x-slot name="icon">
                  <x-heroicon-o-question-mark-circle class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400"
                     aria-hidden="true" />
               </x-slot>
               <x-sidebar.sublink href="{{ route('admin.quizzes.index') }}" title="All Quizzes" :isActive="request()->routeIs('admin.quizzes.index')" />
               {{-- Tautan baru untuk memulai kuis --}}
               <x-sidebar.sublink href="{{ route('admin.quizzes.admin_start') }}" title="Try Quizzes"
                  :isActive="request()->routeIs('admin.quizzes.admin_start')" />
            </x-sidebar.dropdown>

            <x-sidebar.dropdown title="Quiz Monitoring" :isActive="Str::startsWith(request()->route()->getName(), 'admin.quizzes.monitoring.')">
               <x-slot name="icon">
                  <x-heroicon-o-chart-bar class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400"
                     aria-hidden="true" />
               </x-slot>
               <x-sidebar.sublink href="{{ route('admin.quizzes.monitoring.performance') }}" title="Quiz Performance"
                  :isActive="request()->routeIs('admin.quizzes.monitoring.performance')" />
               <x-sidebar.sublink href="{{ route('admin.quizzes.monitoring.completion') }}" title="Quiz Completion"
                  :isActive="request()->routeIs('admin.quizzes.monitoring.completion')" />
               <x-sidebar.sublink href="{{ route('admin.quizzes.monitoring.user-attempts') }}" title="User Attempts"
                  :isActive="request()->routeIs('admin.quizzes.monitoring.user-attempts')" />
            </x-sidebar.dropdown>
         </div>
         <hr class="border-gray-200 dark:border-gray-700">
      @endif

      @if (auth()->user()->hasRole('teacher') && auth()->user()->teacher && auth()->user()->teacher->is_active)
         <div>
            <h3 class="font-semibold text-gray-900 mb-3 px-3 leading-tight dark:text-white">TEACHER</h3>
            <x-sidebar.link href="{{ route('admin.teacher.dashboard') }}" title="Dashboard" :isActive="request()->routeIs('admin.teacher.dashboard')">
               <x-slot name="icon">
                  <x-icons.dashboard class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400"
                     aria-hidden="true" />
               </x-slot>
            </x-sidebar.link>

            <x-sidebar.dropdown title="Course Management" :isActive="Str::startsWith(request()->route()->getName(), 'teacher.courses.')">
               <x-slot name="icon">
                  <x-heroicon-o-collection class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400"
                     aria-hidden="true" />
               </x-slot>
               <x-sidebar.sublink href="{{ route('admin.courses.index') }}" title="My Courses" :isActive="request()->routeIs('teacher.courses.index')" />
               <x-sidebar.sublink href="{{ route('admin.categories.index') }}" title="Categories" :isActive="request()->routeIs('teacher.categories.index')" />
            </x-sidebar.dropdown>

            <x-sidebar.dropdown title="Quiz Management" :isActive="Str::startsWith(request()->route()->getName(), 'teacher.quizzes.')">
               <x-slot name="icon">
                  <x-heroicon-o-question-mark-circle class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400"
                     aria-hidden="true" />
               </x-slot>
               <x-sidebar.sublink href="{{ route('admin.quizzes.index') }}" title="All Quizzes" :isActive="request()->routeIs('teacher.quizzes.index')" />
               <x-sidebar.sublink href="{{ route('admin.quizzes.create') }}" title="Create Quiz" :isActive="request()->routeIs('teacher.quizzes.create')" />
            </x-sidebar.dropdown>
            <x-sidebar.dropdown title="Employee Course Management" :isActive="Str::startsWith(request()->route()->getName(), 'admin.teacher.employee-courses.')">
                <x-slot name="icon">
                   <x-heroicon-o-briefcase class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400"
                      aria-hidden="true" />
                </x-slot>
                <x-sidebar.sublink href="{{ route('admin.teacher.employee-courses.index') }}" title="Employee Courses" :isActive="request()->routeIs('admin.teacher.employee-courses.index')" />
                <x-sidebar.sublink href="{{ route('admin.teacher.employee-courses.index') }}" title="Approve Courses" :isActive="request()->routeIs('admin.teacher.employee-courses.index')" />
            </x-sidebar.dropdown>
         </div>
         <hr class="border-gray-200 dark:border-gray-700">
      @endif

      @if (auth()->user()->hasRole('employee'))
         <div>
            <h3 class="font-semibold text-gray-900 mb-3 px-3 leading-tight dark:text-white">EMPLOYEE</h3>
            <x-sidebar.link href="{{ route('employees-dashboard.dashboard') }}" title="My Resume" :isActive="request()->routeIs('employees-dashboard.dashboard')">
               <x-slot name="icon">
                  <x-icons.dashboard class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400"
                     aria-hidden="true" />
               </x-slot>
            </x-sidebar.link>
            <x-sidebar.link href="{{ route('employees-dashboard.learning-progress.index') }}" title="Learning Progress"
               :isActive="request()->routeIs('employees-dashboard.learning-progress.index')">
               <x-slot name="icon">
                  <x-heroicon-o-chart-bar class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400"
                     aria-hidden="true" /> {{-- Ganti icon sesuai keinginan --}}
               </x-slot>
            </x-sidebar.link>
            <x-sidebar.link href="{{ route('employees-dashboard.courses.index') }}" title="My Courses"
               :isActive="request()->routeIs('employees-dashboard.courses.index')">
               <x-slot name="icon">
                  <x-heroicon-o-collection class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400"
                     aria-hidden="true" />
               </x-slot>
            </x-sidebar.link>
         </div>
         <hr class="border-gray-200 dark:border-gray-700">
      @endif

      @if (!auth()->user()->hasRole(['admin', 'teacher', 'employee']))
         <div>
            <h3 class="font-semibold text-gray-900 mb-3 px-3 leading-tight dark:text-white">GENERAL</h3>
            <x-sidebar.link href="{{ route('dashboard') }}" title="Dashboard" :isActive="request()->routeIs('dashboard')">
               <x-slot name="icon">
                  <x-icons.dashboard class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400"
                     aria-hidden="true" />
               </x-slot>
            </x-sidebar.link>
         </div>
      @endif
   </div>

</x-perfect-scrollbar>
