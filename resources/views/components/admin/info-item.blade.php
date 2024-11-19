@props([
    'property',
    'label',
    'value' => null,
])

@php
    $displayValue = $value ?? $property;
@endphp

@isset($property)
    <div class="info__item">
        <div class="info__property">{{ $label }}</div>
        <div class="info__value">{{ $displayValue }}</div>
    </div>
@endisset
