<x-layouts.app>

    <x-partials.header />

    <div class="coupling">

        <form class="gens">

            <h1 class="gens__title">Родословная планируемого окоза</h1>

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
                    $cols = 3;
                @endphp

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
                </div>


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
                @endfor

            </div>

        </form>

    </div>


    <x-partials.footer />

</x-layouts.app>
