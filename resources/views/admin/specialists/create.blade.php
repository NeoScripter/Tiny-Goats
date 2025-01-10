<x-layouts.app>

    <x-admin.header />

    <div class="admin-animal-show">

        <form method="POST" action="{{ route('specialist.store') }}" enctype="multipart/form-data">
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
                    <x-form-input label="Фамилия, имя специалиста" name="name" value="{{ old('name') }}" />

                    <x-form-input label="Специальность, направления работы" name="speciality"
                        value="{{ old('speciality') }}" />

                    <x-form-input label="Информация оо образовании" name="education" value="{{ old('education') }}" />

                    <x-form-input label="Информация о трудовом стаже" name="experience" value="{{ old('experience') }}" />

                    <x-form-textarea label="Другая информация" name="extraInfo" value="{{ old('extraInfo') }}"
                        rows="3" />

                    <x-form-input label="Контакты" name="contacts" value="{{ old('contacts') }}" />

                    <x-form-input label="сайт и/или соцсети" name="website" value="{{ old('website') }}" />


                </div>
            </div>
            <div class="edit-animals__btns">
                <button type="submit" class="edit-animals__publish-btn" onclick="this.disabled = true; this.form.submit();">Опубликовать</button>
                <!-- Delete Button -->
                <a href="{{ route('specialists.index') }}" class="edit-animals__delete-btn">Отмена</a>
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
