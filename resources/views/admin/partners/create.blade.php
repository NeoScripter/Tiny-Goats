<x-layouts.app>

    <x-admin.header />

    <div class="admin-animal-show">

        <form method="POST" action="{{ route('partner.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="info">

                <div class="info__visual">

                    <div class="info__snapshot">
                        <label for="image">
                            <img id="imagePreview" src="{{ asset('images/partials/placeholder.webp') }}" alt="Main Image"
                                class="main-image">
                        </label>
                        <input type="file" name="image" id="image" accept="image/*" class="news__file-input"
                            onchange="previewImage(event)">
                    </div>
                    @error('image')
                        <span class="edit-news__error info__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="info__data">

                    <x-form-input label="Название" name="name" value="{{ old('name') }}" />

                    <x-form-textarea label="Информация о партнере, услугах, акциях, скидке" name="info"
                        value="{{ old('info') }}" rows="3" />

                    <x-form-input label="Условия получения" name="conditions" value="{{ old('conditions') }}" />

                    <x-form-input label="Сайт" name="website" value="{{ old('website') }}" />

                    <x-form-input label="Дата последнего изменения" name="contacts" value="{{ old('contacts') }}" />


                </div>
            </div>
            <div class="edit-animals__btns">
                <button type="submit" class="edit-animals__publish-btn">Опубликовать</button>
                <!-- Delete Button -->
                <a href="{{ route('partners.index') }}" class="edit-animals__delete-btn">Отмена</a>
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
