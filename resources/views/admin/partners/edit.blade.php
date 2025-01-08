<x-layouts.app>

    <x-admin.header />

    <div class="admin-animal-show">


        @isset($partner)
            <form method="POST" action="{{ route('partner.update', $partner->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="info">

                    <div class="info__visual">

                        <div class="info__snapshot">
                            <label for="image">
                                <img id="imagePreview"
                                    src="{{ $partner->image ? asset('storage/' . $partner->image) : asset('images/partials/placeholder.webp') }}"
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
                        <x-form-input label="Название" name="name" value="{{ old('name', $partner->name) }}" />

                        <x-form-textarea label="Информация о партнере, услугах, акциях, скидке" name="info"
                            value="{{ old('info', $partner->info) }}" rows="3" />

                        <x-form-input label="Условия получения" name="conditions"
                            value="{{ old('conditions', $partner->conditions) }}" />

                        <x-form-input label="Сайт" name="website" value="{{ old('website', $partner->website) }}" />

                        <x-form-input label="Контакты" name="contacts"
                            value="{{ old('contacts', $partner->contacts) }}" />


                    </div>
                </div>
                <div class="edit-animals__btns">
                    <button type="submit" class="edit-animals__publish-btn">Опубликовать</button>
                    <!-- Delete Button -->
                    <button type="submit" form="delete-partner-form" class="edit-animals__delete-btn">Удалить</button>
                </div>
            </form>

        </div>
        <form id="delete-partner-form" method="POST" action="{{ route('partner.destroy', $partner->id) }}"
            onsubmit="return confirm('Вы уверены что хотите удалить данного партнера из базы данных?');">
            @csrf
            @method('DELETE')
        </form>
    @endisset


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
