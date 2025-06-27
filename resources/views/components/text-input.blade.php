@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-red-900 focus:ring-red-900 rounded-md shadow-sm']) !!}>
