@props(['label', 'value', 'color'])

<div class="{{ $color }} text-white p-4 rounded shadow">
    <div class="text-sm font-semibold">{{ $label }}</div>
    <div class="text-2xl font-bold mt-1">{{ $value }}</div>
</div>