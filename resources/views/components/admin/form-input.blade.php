<div class="info__item">
    <div class="info__property">{{ $label }}</div>
    <div>
        <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}" class="info__input">

        @error($name)
            <div class="info__error">{{ $message }}</div>
        @enderror
    </div>
</div>
