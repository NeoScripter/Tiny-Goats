<x-layouts.app>

    <x-partials.header />

    <div class="animal-card">

        <section class="info">

            <div class="info__visual">

                <div class="info__snapshot">
                    <img src="{{ asset('images/pages/user/animal/placeholder.png') }}" alt="">
                </div>

                <div class="info__gallery">

                    @for ($i = 0; $i < 4; $i++)
                        <div class="info__image">
                            <img src="{{ asset('images/pages/user/animal/placeholder.png') }}" alt="">
                        </div>
                    @endfor
                </div>

                <div class="info__children">

                    <h3 class="info__label">потомство</h3>

                    <ul class="info__ul">
                        @for ($i = 0; $i < 7; $i++)
                            <li class="info__li">
                                <a href="">Lorem Ipsum, </a>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>

            <div class="info__data">
                @for ($i = 0; $i < 7; $i++)
                    <div class="info__item">
                        <div class="info__property">Кличка</div>
                        <div class="info__value">LOREM IPSUM</div>
                    </div>
                @endfor

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

    </div>


    <x-partials.footer />

</x-layouts.app>
