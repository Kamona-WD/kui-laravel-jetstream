@props(['title' => '', 'active' => false])

@php
    
$classes = 'transition-colors hover:text-gray-900 dark:hover:text-gray-100';

$active 
    ? $classes .= ' text-gray-900 dark:text-gray-200' 
    : $classes .= ' text-gray-500 dark:text-gray-400';

@endphp

<li class="relative leading-8 m-0 pl-6 last:before:bg-white last:before:h-auto last:before:top-4 last:before:bottom-0 dark:last:before:bg-dark-eval-1 before:block before:w-4 before:h-0 before:absolute before:left-0 before:top-4 before:border-t-2 before:border-t-gray-200 before:-mt-0.5 dark:before:border-t-gray-600">
    <a {{ $attributes->merge(['class' => $classes]) }}>{{ $title }}</a>
</li>
