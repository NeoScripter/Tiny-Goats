<x-layouts.app>

    <x-partials.header />

    <div class="admin-animal-card">
        @isset($animal)

            <section class="info">

                <div class="info__visual">

                    <div class="info__snapshot">
                        <img src="{{ $animal->images[0] ? asset('storage/' . $animal->images[0]) : asset('images/partials/placeholder.webp') }}"
                            alt="">
                    </div>

                    <div class="info__gallery">

                        @foreach ($animal->images as $image)
                            <div class="info__image">
                                <img src="{{ asset('storage/' . $image) }}" alt="Goat image">
                            </div>
                        @endforeach
                    </div>

                    <div class="info__children">

                        <h3 class="info__label">потомство</h3>

                        <ul class="info__ul">
                            @foreach ($animal->children as $child)
                                <li class="info__li">
                                    <a
                                        href="{{ route('animals.show', $child->id) }}">{{ $child->name }}{{ !$loop->last ? ',' : '' }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="info__data">
                    <x-admin.info-item :property="$animal->name" label="Кличка" />

                    <x-admin.info-item :property="$animal->isMale ? 'Самец' : 'Самка'" label="Пол" />

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

            <form class="gens">

                <h1 class="gens__title">Родословная</h1>

                <div class="gens__params">
                    <div class="gens__param">
                        <p class="gens__param-label">Количество поколений</p>
                        <select name="" id="" class="gens__select">
                            @for ($i = 1; $i < 9; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="gens__param">
                        <p class="gens__param-label">Версия для печати</p>
                        <select name="" id="" class="gens__select">
                            <option value="">С фото</option>
                            <option value="">без фото</option>
                        </select>
                    </div>
                </div>

                <button class="gens__button">Сгенерировать</button>

                <div class="gens__table">

                    @php
                        $cols = 4;
                    @endphp

                    @for ($i = 0; $i < $cols; $i++)
                        <div class="gens__column">

                            @php
                                $powerOfTwo = pow(2, $i);
                            @endphp

                            @for ($j = 0; $j < $powerOfTwo; $j++)
                                <div class="gens__item">
                                    <div class="gens__image">
                                        <img src="{{ asset('images/pages/user/animal/placeholder.png') }}" alt="">
                                    </div>

                                    <h3 class="gens__name">Кличка</h3>
                                    <p class="gens__breed">Порода</p>
                                </div>
                            @endfor

                        </div>
                    @endfor

                </div>

            </form>

        @endisset

    </div>


    <x-partials.footer />

</x-layouts.app>
