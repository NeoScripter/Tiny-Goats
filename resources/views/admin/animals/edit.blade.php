<x-layouts.app>

    <x-admin.header />

    @isset($animal)

        <div class="admin-animal-show">

            <form method="POST" action="{{ route('animals.update', $animal->id) }}" enctype="multipart/form-data"
                x-data="animalSearch()">
                @csrf
                @method('PUT')

                <div class="info">

                    <!-- Main Visual Section -->
                    <div class="info__visual">
                        <!-- Main Image Preview -->
                        <div class="info__snapshot">
                            <label for="images">
                                <img id="mainImagePreview"
                                    src="{{ $animal->images[0] ? asset('storage/' . $animal->images[0]) : asset('images/partials/placeholder.webp') }}"
                                    alt="Main Image">
                            </label>
                            <input type="file" name="images[]" id="images" accept="image/*" multiple
                                onchange="previewImages(event)">
                        </div>

                        <div class="info__gallery" id="galleryPreview">
                            @foreach ($animal->images as $index => $image)
                                <div class="info__image" onclick="moveExistingImageToFront({{ $index }})">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image">
                                </div>
                            @endforeach
                        </div>

                        <!-- Hidden input to store the reordered image paths -->
                        <input type="hidden" name="sortedImages" id="sortedImages"
                            value="{{ json_encode($animal->images) }}">

                        <!-- Children Selection Section -->
                        <div class="info__children">
                            <h3 class="info__label">Потомство</h3>

                            <!-- Search Input -->
                            <div class="info__search">
                                <input type="search" x-model="searchQuery" placeholder="Поиск животного..."
                                    class="info__gens-search" @input="filterAnimals">
                                <button type="button" @click="addAnimal()" class="info__add-btn">Добавить</button>
                            </div>

                            <!-- Dropdown List for Matching Animals -->
                            <ul class="info__dropdown" x-show="filteredAnimals.length > 0 && searchQuery !== ''">
                                <template x-for="animal in filteredAnimals" :key="animal.id">
                                    <li class="info__li">
                                        <a href="#" @click.prevent="selectAnimal(animal)" x-text="animal.name"></a>
                                    </li>
                                </template>
                            </ul>

                            <!-- List of Selected Children -->
                            <ul class="info__ul">
                                <template x-for="(child, index) in selectedChildren" :key="child.id">
                                    <li class="info__li">
                                        <input type="hidden" name="children[]" :value="child.id">
                                        <span x-text="child.name"></span>
                                        <button type="button" @click="removeChild(index)"
                                            class="info__remove-btn">&times;</button>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <!-- Form Data Section -->
                    <div class="info__data">
                        <x-form-input label="Кличка" name="name" value="{{ old('name', $animal->name) }}" />

                        <!-- Gender -->
                        <div class="info__item">
                            <div class="info__property">Пол</div>
                            <div class="info__value">
                                <label class="info__radio-label">
                                    <input type="radio" name="isMale" value="1"
                                        {{ old('isMale', $animal->isMale) == '1' ? 'checked' : '' }}>
                                    М
                                </label>
                                <label class="info__radio-label">
                                    <input type="radio" name="isMale" value="0"
                                        {{ old('isMale', $animal->isMale) == '0' ? 'checked' : '' }}>
                                    Ж
                                </label>
                            </div>
                        </div>
                        @error('isMale')
                            <div class="info__error info__error--shifted">{{ $message }}</div>
                        @enderror

                        @php
                            $categories = ['Нигерийская', 'Нигерийско-камерунская', 'Камерунская', 'Метис', 'Другие'];
                        @endphp

                        <!-- Breed -->

                        <div class="info__item">
                            <div class="info__property">Порода, помесь пород</div>
                            <div class="info__value">
                                <select name="breed" class="info__select">
                                    @foreach ($categories as $category)
                                        <option value="{{ strtolower($category) }}"
                                            {{ old('breed', $animal->breed) == strtolower($category) ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Color -->
                        <x-form-input label="Окрас" name="color" value="{{ old('color', $animal->color) }}" />

                        <!-- eyeColor -->
                        <x-form-input label="Цвет глаз" name="eyeColor" value="{{ old('eyeColor', $animal->eyeColor) }}" />

                        <!-- Birth Date -->
                        <div class="info__item">
                            <div class="info__property">Дата рождения</div>
                            <div class="info__value">
                                <input type="date" name="birthDate"
                                    value="{{ old('birthDate', $animal->birthDate ? $animal->birthDate->format('Y-m-d') : '') }}"
                                    class="info__input">
                            </div>
                        </div>

                        <!-- Direction -->
                        <x-form-input label="Направление" name="direction"
                            value="{{ old('direction', $animal->direction) }}" />

                        <!-- Siblings -->
                        <x-form-input label="В числе скольких рождён(на)" name="siblings"
                            value="{{ old('siblings', $animal->siblings) }}" />

                        <!-- Hornedness -->
                        <x-form-input label="Рогатость" name="hornedness"
                            value="{{ old('hornedness', $animal->hornedness) }}" />

                        <!-- Mother -->
                        <div class="info__item">
                            <div class="info__property">Мама</div>
                            <div class="info__value">
                                <select name="mother_id" class="info__select">
                                    <option value="">-- Выбрать мать --</option>
                                    @foreach ($femaleAnimals as $female)
                                        <option value="{{ $female->id }}"
                                            {{ old('mother_id', $animal->mother_id) == $female->id ? 'selected' : '' }}>
                                            {{ $female->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @error('mother_id')
                            <div class="info__error info__error--shifted">{{ $message }}</div>
                        @enderror

                        <!-- Father -->
                        <div class="info__item">
                            <div class="info__property">Папа</div>
                            <div class="info__value">
                                <select name="father_id" class="info__select">
                                    <option value="">-- Выбрать отца --</option>
                                    @foreach ($maleAnimals as $male)
                                        <option value="{{ $male->id }}"
                                            {{ old('father_id', $animal->father_id) == $male->id ? 'selected' : '' }}>
                                            {{ $male->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @error('father_id')
                            <div class="info__error info__error--shifted">{{ $message }}</div>
                        @enderror

                        <!-- birthCountry -->
                        <x-form-input label="Страна рождения" name="birthCountry"
                            value="{{ old('birthCountry', $animal->birthCountry) }}" />

                        <!-- residenceCountry -->
                        <x-form-input label="Страна проживания" name="residenceCountry"
                            value="{{ old('residenceCountry', $animal->residenceCountry) }}" />


                        @isset($households)
                            <!-- Breeder -->
                            <div class="info__item">
                                <div class="info__property">Заводчик</div>
                                <div class="info__value">
                                    <select name="household_breeder_id" class="info__select">
                                        <option value="">-- Выбрать заводчика --</option>
                                        @foreach ($households as $household)
                                            <option value="{{ $household->id }}"
                                                {{ old('household_breeder_id', $animal->household_breeder_id) == $household->id ? 'selected' : '' }}>
                                                {{ $household->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @error('household_breeder_id')
                                <div class="info__error info__error--shifted">{{ $message }}</div>
                            @enderror

                            <!-- Owner -->
                            <div class="info__item">
                                <div class="info__property">Владелец</div>
                                <div class="info__value">
                                    <select name="household_owner_id" class="info__select">
                                        <option value="">-- Выбрать владельца --</option>
                                        @foreach ($households as $household)
                                            <option value="{{ $household->id }}"
                                                {{ old('household_owner_id', $animal->household_owner_id) == $household->id ? 'selected' : '' }}>
                                                {{ $household->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @error('household_owner_id')
                                <div class="info__error info__error--shifted">{{ $message }}</div>
                            @enderror
                        @endisset

                        <!-- Status -->
                        <x-form-input label="Статус" name="status" value="{{ old('status', $animal->status) }}" />

                        <!-- labelNumber -->
                        <x-form-input label="Номер чипа/бирки" name="labelNumber"
                            value="{{ old('labelNumber', $animal->labelNumber) }}" />

                        <!-- height -->
                        <x-form-input label="Рост в 1; 2; 3 года" name="height"
                            value="{{ old('height', $animal->height) }}" />

                        <!-- rudiment -->
                        <x-form-input label="Рудименты" name="rudiment"
                            value="{{ old('rudiment', $animal->rudiment) }}" />

                        <!-- extraInfo -->
                        <x-form-textarea label="Дополнительная информация" name="extraInfo"
                            value="{{ old('extraInfo', $animal->extraInfo) }}" rows="3" />

                        <!-- Certificates -->
                        <x-form-textarea label="Тесты и сертификаты" name="certificates"
                            value="{{ old('certificates', $animal->certificates) }}" rows="3" />

                        <!-- For Sale -->
                        <div class="info__item">
                            <div class="info__property">На продажу</div>
                            <div class="info__value info__value--checkbox">
                                <input type="checkbox" name="forSale" value="1"
                                    {{ old('forSale', $animal->forSale) ? 'checked' : '' }}>
                            </div>
                        </div>

                        @error('forSale')
                            <div class="info__error info__error--shifted">{{ $message }}</div>
                        @enderror

                        <!-- Show on Main -->
                        <div class="info__item">
                            <div class="info__property">Показывать на главной</div>
                            <div class="info__value info__value--checkbox">
                                <input type="checkbox" name="showOnMain" value="1"
                                    {{ old('showOnMain', $animal->showOnMain) ? 'checked' : '' }}>
                            </div>
                        </div>

                        @error('showOnMain')
                            <div class="info__error info__error--shifted">{{ $message }}</div>
                        @enderror

                    </div>
                </div>
                <div class="edit-animals__btns">
                    <button type="submit" class="edit-animals__publish-btn">Сохранить</button>
                    <!-- Delete Button -->
                    <button type="submit" form="delete-animal" class="edit-animals__delete-btn">Удалить</button>
                </div>
            </form>
        </div>

        <form method="POST" id="delete-animal" action="{{ route('animals.destroy', $animal->id) }}"
            onsubmit="return confirm('Вы уверены что хотите удалить данное животное из базы данных?');">
            @csrf
            @method('delete');
        </form>
    @endisset

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="notification-popup">
            {{ session('success') }}
        </div>
    @endif

    <x-partials.footer />

    <script>
        let existingImages = @json($animal->images ?? []);
        let uploadedFiles = [];
        const maxImages = 5;

        function renderGallery() {
            const galleryPreview = document.getElementById('galleryPreview');
            galleryPreview.innerHTML = '';

            existingImages.forEach((image, index) => {
                if (index >= maxImages) return;
                const galleryImage = document.createElement('div');
                galleryImage.classList.add('info__image');
                galleryImage.innerHTML = `<img src="/storage/${image}" alt="Gallery Image">`;
                galleryImage.addEventListener('click', () => moveExistingImageToFront(index));
                galleryPreview.appendChild(galleryImage);
            });

            uploadedFiles.forEach((file, index) => {
                if (index >= maxImages) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    const galleryImage = document.createElement('div');
                    galleryImage.classList.add('info__image');
                    galleryImage.innerHTML = `<img src="${e.target.result}" alt="Gallery Image">`;
                    galleryImage.addEventListener('click', () => moveUploadedFileToFront(index));
                    galleryPreview.appendChild(galleryImage);
                };
                reader.readAsDataURL(file);
            });

            updateMainImage();
            updateHiddenInput();
        }

        function previewImages(event) {
            uploadedFiles = Array.from(event.target.files).slice(0, maxImages);
            existingImages = [];
            renderGallery();
        }

        function moveExistingImageToFront(index) {
            const [selectedImage] = existingImages.splice(index, 1);
            existingImages.unshift(selectedImage);
            renderGallery();
        }

        function moveUploadedFileToFront(index) {
            const [selectedFile] = uploadedFiles.splice(index, 1);
            uploadedFiles.unshift(selectedFile);
            renderGallery();
        }

        function updateMainImage() {
            const mainImagePreview = document.getElementById('mainImagePreview');
            if (existingImages.length > 0) {
                mainImagePreview.src = `/storage/${existingImages[0]}`;
            } else if (uploadedFiles.length > 0) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    mainImagePreview.src = e.target.result;
                };
                reader.readAsDataURL(uploadedFiles[0]);
            } else {
                mainImagePreview.src = '{{ asset('images/partials/placeholder.webp') }}';
            }
        }

        function updateHiddenInput() {
            const sortedImagesInput = document.getElementById('sortedImages');
            const allImages = [...existingImages, ...uploadedFiles.map(file => URL.createObjectURL(file))];
            sortedImagesInput.value = JSON.stringify(allImages);
        }

        window.onload = renderGallery;

        function animalSearch() {
            return {
                searchQuery: '',
                allAnimals: @json($allAnimals),
                filteredAnimals: [],
                selectedChildren: @json($animal->children),

                filterAnimals() {
                    if (this.searchQuery.length > 0) {
                        this.filteredAnimals = this.allAnimals.filter(animal =>
                            animal.name.toLowerCase().includes(this.searchQuery.toLowerCase())
                        );
                    } else {
                        this.filteredAnimals = [];
                    }
                },

                selectAnimal(animal) {
                    if (!this.selectedChildren.some(child => child.id === animal.id)) {
                        this.selectedChildren.push(animal);
                    }
                    this.searchQuery = '';
                    this.filteredAnimals = [];
                },

                addAnimal() {
                    const matchedAnimal = this.allAnimals.find(animal =>
                        animal.name.toLowerCase() === this.searchQuery.toLowerCase()
                    );
                    if (matchedAnimal) {
                        this.selectAnimal(matchedAnimal);
                    }
                },

                removeChild(index) {
                    this.selectedChildren.splice(index, 1);
                }
            };
        }
    </script>

</x-layouts.app>
