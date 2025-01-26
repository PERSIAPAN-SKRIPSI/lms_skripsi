@props(['id', 'name', 'checked' => false, 'label' => null])

 <div class="flex items-center">
     <input
         type="checkbox"
         id="{{ $id }}"
         name="{{ $name }}"
         {{ $checked ? 'checked' : '' }}
         {{ $attributes->merge(['class' => 'rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500']) }}
     />
     @if($label)
        <label for="{{ $id }}" class="ml-2 block font-medium text-sm text-gray-700">
          {{ $label }}
        </label>
     @endif
 </div>
