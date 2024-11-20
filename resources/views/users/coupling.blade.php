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
                            <img src="{{ asset('images/pages/user/coupling/coupling-goat.webp') }}" alt="">
                        </div>
                    </div>
                </div>

                <div class="gens__column">
                    <div class="gens__item">

                        <div class="gens__select-wrapper">
                            <img src="{{ asset('images/pages/user/coupling/coupling-female.webp') }}" alt="">
                            <select name="mother">
                                <option value="" selected>Другая мать </option>
                                @for ($i = 1; $i < 9; $i++)
                                    <option value="">Lorem ipsum </option>
                                @endfor
                            </select>
                        </div>

                        <div class="gens__image">
                            <img src="{{ asset('images/pages/user/animal/placeholder.png') }}" alt="">
                        </div>

                        <h3 class="gens__name">Кличка</h3>
                        <p class="gens__breed">Порода</p>
                    </div>
                    <div class="gens__item">

                        <div class="gens__select-wrapper">
                            <img src="{{ asset('images/pages/user/coupling/coupling-male.webp') }}" alt="">
                            <select name="father">
                                <option value="" selected>Другой отец </option>
                                @for ($i = 1; $i < 9; $i++)
                                    <option value="">Lorem ipsum </option>
                                @endfor
                            </select>
                        </div>

                        <div class="gens__image">
                            <img src="{{ asset('images/pages/user/animal/placeholder.png') }}" alt="">
                        </div>

                        <h3 class="gens__name">Кличка</h3>
                        <p class="gens__breed">Порода</p>
                    </div>
                </div>

                @isset($genealogy)
                    @foreach ($genealogy as $generationIndex => $generation)
                        <div class="gens__column">
                            @foreach ($generation as $parent)
                                <div class="gens__item">
                                    @if ($parent)
                                        <a href="{{ route('animals.show', $parent->id) }}" class="gens__image">
                                            @if ($photo)
                                                <img src="{{ $photo && $parent->images[0] ? asset('storage/' . $parent->images[0]) : asset('images/partials/placeholder.webp') }}"
                                                    alt="">
                                            @else
                                                <img src="{{ asset('images/partials/nophoto.png') }}" alt="Нет фотографии">
                                            @endif
                                        </a>
                                        <h3 class="gens__name">{{ $parent->name }}</h3>
                                        <p class="gens__breed">{{ $parent->breed ?? 'Unknown' }}</p>
                                    @else
                                        <div class="gens__image">
                                            <img src="{{ asset('images/partials/placeholder.webp') }}" alt="">
                                        </div>
                                        <h3 class="gens__name">?</h3>
                                        <p class="gens__breed">?</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endisset

            </div>

        </form>


        {{--  <form class="gens">

            <h1 class="gens__title">Родословная планируемого окота</h1>

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

            <button class="gens__button">Сгенерировать</button> --}}

        {{--  <div class="gens__table">

                @php
                    $cols = 8;
                @endphp --}}

        {{-- <div class="gens__column">
                    <div class="gens__item">

                        <div class="gens__image">
                            <img src="{{ asset('images/pages/user/coupling/coupling-goat.webp') }}" alt="">
                        </div>
                    </div>
                </div> --}}

        {{--    <div class="gens__column">
                    <div class="gens__item">

                        <div class="gens__select-wrapper">
                            <img src="{{ asset('images/pages/user/coupling/coupling-female.webp') }}" alt="">
                            <select name="" id="">
                                <option value="" selected>Другая мать </option>
                                @for ($i = 1; $i < 9; $i++)
                                    <option value="">Lorem ipsum </option>
                                @endfor
                            </select>
                        </div>

                        <div class="gens__image">
                            <img src="{{ asset('images/pages/user/animal/placeholder.png') }}" alt="">
                        </div>

                        <h3 class="gens__name">Кличка</h3>
                        <p class="gens__breed">Порода</p>
                    </div>
                    <div class="gens__item">

                        <div class="gens__select-wrapper">
                            <img src="{{ asset('images/pages/user/coupling/coupling-male.webp') }}" alt="">
                            <select name="" id="">
                                <option value="" selected>Другой отец </option>
                                @for ($i = 1; $i < 9; $i++)
                                    <option value="">Lorem ipsum </option>
                                @endfor
                            </select>
                        </div>

                        <div class="gens__image">
                            <img src="{{ asset('images/pages/user/animal/placeholder.png') }}" alt="">
                        </div>

                        <h3 class="gens__name">Кличка</h3>
                        <p class="gens__breed">Порода</p>
                    </div>
                </div> --}}

        {{--
                @for ($i = 2; $i < $cols; $i++)

                    <div class="gens__column">

                        @php
                            $powerOfTwo = pow(2, $i);
                        @endphp

                        @for ($j = 0; $j <= $powerOfTwo; $j++)
                            <div class="gens__item">
                                <div class="gens__image">
                                    <img src="{{ asset('images/pages/user/animal/placeholder.png') }}"alt="">
                                </div>

                                <h3 class="gens__name">Кличка</h3>
                                <p class="gens__breed">Порода</p>
                            </div>
                        @endfor

                    </div>
                @endfor --}}
        {{--
            </div>

        </form> --}}

    </div>


    <x-partials.footer />

</x-layouts.app>
