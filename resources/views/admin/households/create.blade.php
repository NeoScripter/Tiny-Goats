<x-layouts.app>

    <x-admin.header />

    <div class="admin-animal-show">

        <form method="POST" action="{{ route('household.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="info">

                <div class="info__visual">

                    <div class="info__snapshot">
                        <label for="image">
                            <img id="imagePreview" src="{{ asset('images/partials/placeholder.webp') }}"
                                alt="Main Image" class="main-image">
                        </label>
                        <input type="file" name="image" id="image" accept="image/*" class="news__file-input"
                             onchange="previewImage(event)">
                    </div>
                    @error('image')
                        <span class="edit-news__error info__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="info__data">

                    <!-- Name -->
                    <x-form-input label="название хозяйства" name="name" value="{{ old('name') }}" />

                    <x-form-input label="Адрес" name="address"
                        value="{{ old('address') }}" />

                    <x-form-input label="Владелец" name="owner" value="{{ old('owner') }}" />

                    <x-form-textarea label="Доп. сведения о владельце" name="extraInfo" value="{{ old('extraInfo') }}"
                    rows="3" />

                    <x-form-textarea label="Породы, породные направления" name="breeds" value="{{ old('breeds') }}"
                    rows="3" />

                    <x-form-input label="Страна" name="country" value="{{ old('country') }}" />

                    <x-form-input label="Область" name="region" value="{{ old('region') }}" />

                    <x-form-input label="Контакты" name="contacts" value="{{ old('contacts') }}" />

                    <x-form-input label="сайт и/или соцсети" name="website" value="{{ old('website') }}" />

                    <!-- Show on Main -->
                    <div class="info__item">
                        <div class="info__property">Показывать на главной</div>
                        <div class="info__value info__value--checkbox">
                            <input type="checkbox" name="showOnMain" value="1"
                                {{ old('showOnMain') ? 'checked' : '' }}>
                        </div>
                    </div>

                    @error('showOnMain')
                        <div class="info__error info__error--shifted">{{ $message }}</div>
                    @enderror

                </div>
            </div>
            <div class="edit-animals__btns">
                <button type="submit" class="edit-animals__publish-btn">Опубликовать</button>
                <!-- Delete Button -->
                <a href="{{ route('households.index') }}" class="edit-animals__delete-btn">Отмена</a>
            </div>
        </form>

    </div>


    <x-partials.footer />

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('imagePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>


</x-layouts.app>
