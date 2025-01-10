<x-layouts.app>

    <x-admin.header />

    <div class="admin-animal-card">
        @isset($animal)

            <section class="info">

                <div class="info__visual">

                    <div class="info__snapshot">
                        <img src="{{ isset($animal->images[0]) ? Storage::url($animal->images[0]) : asset('images/partials/placeholder.webp') }}"
                            alt="{{ $animal->name }}">
                    </div>

                    <div class="info__gallery">

                        @isset($animal->images[0])
                            @foreach ($animal->images as $image)
                                <div class="info__image">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Goat image">
                                </div>
                            @endforeach
                        @endisset
                    </div>

                    <div class="info__children">
                        @if (count($animal->children) > 0)
                            <h3 class="info__label">потомство</h3>

                            <ul class="info__ul">
                                @foreach ($animal->children as $child)
                                    <li class="info__li">
                                        <a
                                            href="{{ route('animals.show', $child->id) }}">{{ $child->name }}{{ !$loop->last ? ',' : '' }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="info__data">
                    <x-admin.info-item :property="$animal->name" label="Кличка" />

                    <x-admin.info-item :property="$animal->isMale ? 'Козел' : 'Коза'" label="Пол" />

                    <x-admin.info-item :property="$animal->breed" label="Порода, помесь пород" />

                    <x-admin.info-item :property="$animal->color" label="Окрас" />

                    <x-admin.info-item :property="$animal->eyeColor" label="Цвет глаз" />

                    <x-admin.info-item :property="$animal->birthDate" label="Дата рождения" :value="\Carbon\Carbon::parse($animal->birthDate)->format('d.m.Y')" />

                    <x-admin.info-item :property="$animal->direction" label="Направление" />

                    <x-admin.info-item :property="$animal->siblings" label="В числе скольки рожден(на)" />

                    <x-admin.info-item :property="$animal->hornedness" label="Рогатость" />


                    @isset($father)
                        <div class="info__item">
                            <div class="info__property">Папа</div>
                            <a href="{{ route('animals.show', $father->id) }}" class="info__value info__value--link">
                                {{ $father->name }}</a>
                        </div>
                    @endisset

                    @isset($mother)
                        <div class="info__item">
                            <div class="info__property">Мама</div>
                            <a href="{{ route('animals.show', $mother->id) }}" class="info__value info__value--link">
                                {{ $mother->name }}</a>
                        </div>
                    @endisset

                    @isset($owner)
                        <div class="info__item">
                            <div class="info__property">Владелец</div>
                            <a href="{{ route('household.show', $owner->id) }}" class="info__value info__value--link">
                                {{ $owner->name }}</a>
                        </div>
                    @endisset

                    @isset($breeder)
                        <div class="info__item">
                            <div class="info__property">Заводчик</div>
                            <a href="{{ route('household.show', $breeder->id) }}" class="info__value info__value--link">
                                {{ $breeder->name }}</a>
                        </div>
                    @endisset

                    <x-admin.info-item :property="$animal->birthCountry" label="Страна рождения" />

                    <x-admin.info-item :property="$animal->residenceCountry" label="Страна проживания" />

                    <x-admin.info-item :property="$animal->status" label="Статус" />

                    <x-admin.info-item :property="$animal->labelNumber" label="Номер чипа/бирки" />

                    <x-admin.info-item :property="$animal->height" label="Рост в 1; 2; 3 года" />

                    <x-admin.info-item :property="$animal->rudiment" label="Рудименты" />

                    <x-admin.info-item :property="$animal->extraInfo" label="Доп. информация" />

                    <x-admin.info-item :property="$animal->certificates" label="Тесты и сертификаты" />

                </div>

            </section>

            <a href="{{ route('animals.edit', $animal->id) }}" class="gens__button">Редактировать</a>

            <form method="GET" action="{{ route('animals.show', $animal->id) }}" class="gens">


                <h1 class="gens__title">Родословная</h1>

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
                                <img src="{{ isset($animal->images[0]) ? asset('storage/' . $animal->images[0]) : asset('images/partials/placeholder.webp') }}"
                                    alt="{{ $animal->name }}">
                            </div>
                            <h3 class="gens__name">{{ $animal->name }}</h3>
                            <p class="gens__breed">{{ $animal->breed }}</p>
                        </div>
                    </div>


                    @foreach ($genealogy as $generationIndex => $generation)
                        <div class="gens__column">
                            @foreach ($generation as $parent)
                                @php
                                    $style = $parent && isset($repeatedColors[$parent->id])
                                            ? "background-color: {$repeatedColors[$parent->id]};"
                                            : '';
                                @endphp
                                <div class="gens__item" style="{{ $style }}">
                                    @if ($parent)
                                        <a href="{{ route('animals.show', $parent->id) }}" class="gens__image">
                                            @if ($photo)
                                                <img src="{{ $photo && isset($parent->images[0]) ? asset('storage/' . $parent->images[0]) : asset('images/partials/placeholder.webp') }}"
                                                    alt="">
                                            @else
                                                <img src="{{ asset('images/partials/nophoto.png') }}" alt="Нет фотографии">
                                            @endif
                                        </a>
                                        <a href="{{ route('animals.show', $parent->id) }}" class="gens__name gens__name--link">{{ $parent->name }}</a>
                                        <p class="gens__breed">{{ $parent->breed ?? 'Unknown' }}</p>
                                    @else
                                        <div class="gens__image">
                                            <img src="{{ asset('images/partials/placeholder.webp') }}" alt="">
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

        @endisset

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
