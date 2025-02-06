@props(['property', 'label', 'value' => null, 'isLink' => false])

@php
    $displayValue = $value ?? $property;
@endphp

@isset($property)
    <div class="info__item">
        <div class="info__property">{{ $label }}</div>
        @if ($isLink)
            <a href="{{ $displayValue }}" target="_blank" class="info__value info__value--link">{!! $displayValue !!}</a>
        @else
            <div class="info__value">{!! $displayValue !!}</div>
        @endif
    </div>
@endisset
