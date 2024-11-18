<div class="info__item">
    <div class="info__property">{{ $label }}</div>
    <div>
        <textarea name="{{ $name }}" rows="{{ $rows }}" class="info__input">{{ old($name, $value) }}</textarea>
        @error($name)
            <div class="info__error">{{ $message }}</div>
        @enderror
    </div>
</div>
