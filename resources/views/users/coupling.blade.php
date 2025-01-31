<x-layouts.app>

    <x-partials.header />

    <div class="coupling">

        <div class="gens">
            <form method="GET" action="{{ route('user.coupling') }}">


                <h1 class="gens__title">Родословная планируемого окота</h1>

                <div class="gens__params">
                    <div class="gens__param">
                        <p class="gens__param-label">Количество поколений</p>
                        <select name="gens" class="gens__select">
                            @for ($i = 2; $i < 9; $i++)
                                <option value="{{ $i }}"
                                    {{ request('gens', $gens) == $i ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="gens__param">
                        <p class="gens__param-label">Версия для печати</p>
                        <select name="photo" class="gens__select">
                            <option value="1" {{ $photo ? 'selected' : '' }}>С фото</option>
                            <option value="0" {{ !$photo ? 'selected' : '' }}>Без фото</option>
                        </select>
                    </div>

                    <div class="gens__param gens__param--popup">
                        <p class="gens__param-label">HTML код родословной</p>
                        <button type="button" id="copyUrlButton" class="gens__select">Копировать</button>
                        <span class="gens__copy-message">Скопировано!</span>
                    </div>
                </div>

                <div class="gens__warning">
                    После изменения количества поколений и/или версии для печати, <br> <span
                        class="gens__underline">повторно нажмите кнопку "Сгенерировать"</span>
                </div>

                <button type="submit" class="gens__button">Сгенерировать</button>

                <div class="gens__table">

                    <div class="gens__column">
                        <div class="gens__item">

                            <div class="gens__image">
                                <img src="{{ asset('images/pages/user/coupling/coupling-goat.webp') }}"
                                    alt="Фото козла">
                            </div>
                        </div>
                    </div>

                    <div class="gens__column">

                        <div x-data="searchableList({{ $maleAnimals->toJson() }})" class="gens__item">

                            <div x-show="showPopup" x-transition x-cloak class="select-parent-overlay">
                                <div class="select-parent-popup" @click.away="showPopup = false">
                                    <div>
                                        <button type="button" @click="showPopup = false" class="close-btn-overlay">
                                            <img src="{{ asset('images/svgs/cross-small.svg') }}" alt="close popup">
                                        </button>
                                    </div>

                                    <div class="coupling__popup--body">
                                        <p class="coupling__popup--title">Пожалуйста, введите имя или часть имени отца
                                        </p>

                                        <input type="text" x-model="searchQuery" placeholder="Поиск отца..."
                                            class="coupling__popup--input">

                                        <ul class="gens__list--coupling">
                                            <template x-for="animal in filteredAnimals" :key="animal.id">
                                                <li @click="selectAnimal(animal)" class="gens__list-item">
                                                    <span x-text="animal.name"></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="gens__select-wrapper">
                                <input type="hidden" name="father_id"
                                    :value="selectedId !== '' ? selectedId :
                                        '{{ request('father_id') ? request('father_id') : '' }}'">
                                <button @click="showPopup = true" type="button" class="gens__coupling-btn">Выбрать
                                    отца</button>
                            </div>

                            @if (isset($father))
                                <div class="gens__image">
                                    <img :src="image !== '' ? image :
                                        '{{ isset($father->images[0]) ? asset('storage/' . $father->images[0]) : asset('images/partials/placeholder.webp') }}'"
                                        alt="Фото козла">
                                </div>

                                <h3 class="gens__name" x-show="name.length === 0">{{ $father->name }}</h3>
                                <p class="gens__breed" x-show="name.length === 0">{{ $father->breed }}</p>

                                <h3 class="gens__name" x-show="name.length > 0" x-text="name"></h3>
                                <p class="gens__breed" x-show="breed.length > 0" x-text="breed"></p>
                            @else
                                <div class="gens__image" :class="image === '' ? 'gens__image--coupling' : ''">
                                    <img :src="image !== '' ? image :
                                        '{{ asset('images/pages/user/coupling/father-placeholder.webp') }}'"
                                        alt="Фото козла">
                                </div>

                                <h3 class="gens__name" x-show="name.length > 0" x-text="name"></h3>
                                <p class="gens__breed" x-show="breed.length > 0" x-text="breed"></p>
                            @endif
                        </div>

                        <div x-data="searchableList({{ $femaleAnimals->toJson() }})" class="gens__item">

                            <div x-show="showPopup" x-transition x-cloak class="select-parent-overlay">
                                <div class="select-parent-popup" @click.away="showPopup = false">
                                    <div>
                                        <button type="button" @click="showPopup = false" class="close-btn-overlay">
                                            <img src="{{ asset('images/svgs/cross-small.svg') }}" alt="close popup">
                                        </button>
                                    </div>

                                    <div class="coupling__popup--body">
                                        <p class="coupling__popup--title">Пожалуйста, введите имя или часть имени матери
                                        </p>

                                        <input type="text" x-model="searchQuery" placeholder="Поиск матери..."
                                            class="coupling__popup--input">

                                        <ul class="gens__list--coupling">
                                            <template x-for="animal in filteredAnimals" :key="animal.id">
                                                <li @click="selectAnimal(animal)" class="gens__list-item">
                                                    <span x-text="animal.name"></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="gens__select-wrapper">
                                <input type="hidden" name="mother_id"
                                    :value="selectedId !== '' ? selectedId :
                                        '{{ request('mother_id') ? request('mother_id') : '' }}'">
                                <button @click="showPopup = true" type="button" class="gens__coupling-btn">Выбрать
                                    мать</button>
                            </div>

                            @if (isset($mother))
                                <div class="gens__image">
                                    <img :src="image !== '' ? image :
                                        '{{ isset($mother->images[0]) ? asset('storage/' . $mother->images[0]) : asset('images/partials/placeholder.webp') }}'"
                                        alt="Фото козла">
                                </div>

                                <h3 class="gens__name" x-show="name.length === 0">{{ $mother->name }}</h3>
                                <p class="gens__breed" x-show="name.length === 0">{{ $mother->breed }}</p>

                                <h3 class="gens__name" x-show="name.length > 0" x-text="name"></h3>
                                <p class="gens__breed" x-show="breed.length > 0" x-text="breed"></p>
                            @else
                                <div class="gens__image" :class="image === '' ? 'gens__image--coupling' : ''">
                                    <img :src="image !== '' ? image :
                                        '{{ asset('images/pages/user/coupling/mother-placeholder.webp') }}'"
                                        alt="Фото козла">
                                </div>

                                <h3 class="gens__name" x-show="name.length > 0" x-text="name"></h3>
                                <p class="gens__breed" x-show="breed.length > 0" x-text="breed"></p>
                            @endif
                        </div>
                    </div>

                    @foreach ($genealogy as $generationIndex => $generation)
                        <div class="gens__column">
                            @foreach ($generation as $parent)
                                @php
                                    $style =
                                        $parent && isset($repeatedColors[$parent->id])
                                            ? "background-color: {$repeatedColors[$parent->id]};"
                                            : '';
                                @endphp
                                <div class="gens__item" style="{{ $style }}">
                                    @if ($parent)
                                        <a href="{{ route('user.animals.show', $parent->id) }}" class="gens__image">
                                            @if ($photo)
                                                <img src="{{ $photo && isset($parent->images[0]) ? asset('storage/' . $parent->images[0]) : asset('images/partials/placeholder.webp') }}"
                                                    alt="">
                                            @endif
                                        </a>
                                        <a href="{{ route('user.animals.show', $parent->id) }}"
                                            class="gens__name gens__name--link">{{ $parent->name }}</a>
                                        <p class="gens__breed">{{ $parent->breed ?? 'Unknown' }}</p>
                                    @else
                                        <div class="gens__image">
                                            @if ($photo)
                                                <div class="gens__image">
                                                    <img src="{{ asset('images/partials/placeholder.webp') }}"
                                                        alt="">
                                                </div>
                                            @endif
                                        </div>
                                        <h3 class="gens__name">?</h3>
                                        <p class="gens__breed gens__breed--hidden">Неизвестно</p>
                                    @endif
                                </div>
                            @endforeach

                        </div>
                    @endforeach

                </div>

            </form>
        </div>

    </div>


    <x-partials.footer />

    <script>
        document.getElementById('copyUrlButton').addEventListener('click', function() {
            const url = window.location.href;

            navigator.clipboard.writeText(url)
                .then(() => {
                    const message = document.querySelector('.gens__copy-message');
                    message.classList.add('visible');
                    setTimeout(() => {
                        message.classList.remove('visible');
                    }, 2000);

                })
                .catch(err => {
                    console.error('Failed to copy URL: ', err);
                });
        });

        function searchableList(animals) {
            return {
                showPopup: false,
                searchQuery: '',
                selectedId: '',
                image: '',
                breed: '',
                name: '',

                get filteredAnimals() {
                    if (this.searchQuery === '') {
                        return animals;
                    }

                    return animals.filter(animal =>
                        animal.name.toLowerCase().includes(this.searchQuery.toLowerCase())
                    );
                },

                selectAnimal(animal) {
                    this.selectedId = animal.id;
                    this.name = animal.name;
                    this.breed = animal.breed;

                    this.image = animal.images && animal.images[0] ?
                        '{{ Storage::url('') }}' + animal.images[0] :
                        '{{ asset('images/partials/placeholder.webp') }}';
                    this.showPopup = false;
                },
            };
        }
    </script>

</x-layouts.app>
