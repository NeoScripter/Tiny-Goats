<x-layouts.app>

    <x-admin.header />

    <div class="admin-animal-show">


        @isset($specialist)
            <form method="POST" action="{{ route('specialist.update', $specialist->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="info">

                    <div class="info__visual">

                        <div class="info__snapshot">
                            <label for="image">
                                <img id="imagePreview"
                                    src="{{ $specialist->image_path ? asset('storage/' . $specialist->image_path) : asset('images/partials/placeholder.webp') }}"
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
                        <x-form-input label="Фамилия, имя специалиста" name="name"
                            value="{{ old('name', $specialist->name) }}" />

                        <x-form-input label="Специальность, направления работы" name="speciality"
                            value="{{ old('speciality', $specialist->speciality) }}" />

                        <x-form-input label="Информация оо образовании" name="education"
                            value="{{ old('education', $specialist->education) }}" />

                        <x-form-input label="Информация о трудовом стаже" name="experience"
                            value="{{ old('experience', $specialist->experience) }}" />

                        <x-form-textarea label="Другая информация" name="extraInfo"
                            value="{{ old('extraInfo', $specialist->extraInfo) }}" rows="3" />

                        <x-form-input label="Контакты" name="contacts"
                            value="{{ old('contacts', $specialist->contacts) }}" />

                        <x-form-input label="сайт и/или соцсети" name="website"
                            value="{{ old('website', $specialist->website) }}" />


                    </div>
                </div>
                <div class="edit-animals__btns">
                    <button type="submit" class="edit-animals__publish-btn">Опубликовать</button>
                    <!-- Delete Button -->
                    <button type="submit" form="delete-specialist-form" class="edit-animals__delete-btn">Удалить</button>
                </div>
            </form>

        </div>
        <form id="delete-specialist-form" method="POST" action="{{ route('specialist.destroy', $specialist->id) }}">
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
