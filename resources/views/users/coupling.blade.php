<x-layouts.app>

    <x-partials.header />

    <div class="coupling">

        <form method="GET" action="{{ route('user.coupling') }}" class="gens">


            <h1 class="gens__title">Родословная планируемого окота</h1>

            <div class="gens__params">
                <div class="gens__param">
                    <p class="gens__param-label">Количество поколений</p>
                    <select name="gens" class="gens__select">
                        @for ($i = 1; $i < 8; $i++)
                            <option value="{{ $i }}" {{ request('gens', $gens) == $i ? 'selected' : '' }}>
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

            <button type="submit" class="gens__button">Сгенерировать</button>

            <div class="gens__table">

                <div class="gens__column">
                    <div class="gens__item">

                        <div class="gens__image">
                            <img src="{{ asset('images/pages/user/coupling/coupling-goat.webp') }}" alt="Фото козла">
                        </div>
                    </div>
                </div>

                <div class="gens__column">
                    <div class="gens__item">

                        <div class="gens__select-wrapper">
                            <img src="{{ asset('images/pages/user/coupling/coupling-male.webp') }}" alt="Фото козла">
                            <select name="father_id">
                                <option value="">Другой отец</option>
                                @foreach ($maleAnimals as $male)
                                    <option value="{{ $male->id }}"
                                        {{ (old('father_id') ?? $father?->id) == $male->id ? 'selected' : '' }}>
                                        {{ $male->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if (isset($father))
                            <div class="gens__image">
                                <img src="{{ $father->images[0] ? asset('storage/' . $father->images[0]) : asset('images/partials/placeholder.webp') }}"
                                    alt="Фото козла">
                            </div>

                            <h3 class="gens__name">{{ $father->name }}</h3>
                            <p class="gens__breed">{{ $father->breed }}</p>
                        @else
                            <div class="gens__image">
                                <img src="{{ asset('images/pages/user/animal/placeholder.png') }}" alt="Фото козла">
                            </div>
                        @endif
                    </div>
                    <div class="gens__item">

                        <div class="gens__select-wrapper">
                            <img src="{{ asset('images/pages/user/coupling/coupling-female.webp') }}" alt="Фото козла">
                            <select name="mother_id">
                                <option value="">Другая мать</option>
                                @foreach ($femaleAnimals as $female)
                                    <option value="{{ $female->id }}"
                                        {{ (old('mother_id') ?? $mother?->id) == $female->id ? 'selected' : '' }}>
                                        {{ $female->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if (isset($mother))
                            <div class="gens__image">
                                <img src="{{ $mother->images[0] ? asset('storage/' . $mother->images[0]) : asset('images/partials/placeholder.webp') }}"
                                    alt="Фото козла">
                            </div>

                            <h3 class="gens__name">{{ $mother->name }}</h3>
                            <p class="gens__breed">{{ $mother->breed }}</p>
                        @else
                            <div class="gens__image">
                                <img src="{{ asset('images/pages/user/animal/placeholder.png') }}" alt="Фото козла">
                            </div>
                        @endif
                    </div>
                </div>

                @isset($fatherGenealogy)
                    @foreach ($fatherGenealogy as $generationIndex => $generation)
                        @php
                            if ($generationIndex === 1) continue;
                        @endphp
                        <div class="gens__column">
                            @foreach ($fatherGenealogy[$generationIndex]->reverse() as $parent)
                                <div class="gens__item">
                                    @if ($parent)
                                        <a href="{{ route('animals.show', $parent->id) }}" class="gens__image">
                                            @if ($photo)
                                                <img src="{{ $photo && !empty($parent->images[0]) ? asset('storage/' . $parent->images[0]) : asset('images/partials/placeholder.webp') }}"
                                                    alt="Ancestor Photo">
                                            @else
                                                <img src="{{ asset('images/partials/nophoto.png') }}"
                                                    alt="No Photo Available">
                                            @endif
                                        </a>
                                        <h3 class="gens__name">{{ $parent->name }}</h3>
                                        <p class="gens__breed">{{ $parent->breed ?? 'Unknown' }}</p>
                                    @else
                                        <div class="gens__image">
                                            <img src="{{ asset('images/partials/placeholder.webp') }}"
                                                alt="No Photo Available">
                                        </div>
                                        <h3 class="gens__name">?</h3>
                                    @endif
                                </div>
                            @endforeach
                            @foreach ($motherGenealogy[$generationIndex]->reverse() as $parent)
                                <div class="gens__item">
                                    @if ($parent)
                                        <a href="{{ route('animals.show', $parent->id) }}" class="gens__image">
                                            @if ($photo)
                                                <img src="{{ $photo && !empty($parent->images[0]) ? asset('storage/' . $parent->images[0]) : asset('images/partials/placeholder.webp') }}"
                                                    alt="Ancestor Photo">
                                            @else
                                                <img src="{{ asset('images/partials/nophoto.png') }}"
                                                    alt="No Photo Available">
                                            @endif
                                        </a>
                                        <h3 class="gens__name">{{ $parent->name }}</h3>
                                        <p class="gens__breed">{{ $parent->breed ?? 'Unknown' }}</p>
                                    @else
                                        <div class="gens__image">
                                            <img src="{{ asset('images/partials/placeholder.webp') }}"
                                                alt="No Photo Available">
                                        </div>
                                        <h3 class="gens__name">?</h3>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endisset

            </div>

        </form>

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
    </script>

</x-layouts.app>
