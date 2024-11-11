<x-layouts.app>

    <x-partials.header />

    <div class="user-seach-animal">

        <section class="list">

            <h1 class="list__title">Животные</h1>

            <div class="list__seach-bar">
                <input type="search" placeholder="Поиск по животным">
                <button class="list__search-btn">Найти</button>
                <a href="/register" class="list__add-btn">Добавить животное</a>
            </div>

            <div class="list__categories">
                @php
                    $categories = [
                        'Все',
                        'Нигерийская',
                        'Нигерийско-камерунская',
                        'Камерунская',
                        'метис',
                        'другие',
                        'M',
                        'Ж',
                    ];
                @endphp

                @foreach ($categories as $category)
                    <a href="" class="list__category">{{ $category }}</a>
                @endforeach
            </div>

            <div class="list__keys">


                @php
                    $englishLetters = range('A', 'Z');

                    $russianLetters = array_map(fn($code) => mb_chr($code, 'UTF-8'), range(0x0410, 0x042f));

                    $letters = array_merge($englishLetters, $russianLetters);

                @endphp

                @foreach ($letters as $letter)
                    <a href="" class="list__key">{{ $letter }}</a>
                @endforeach
            </div>

            <table class="list__table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Кличка</th>
                        <th scope="col">Отец</th>
                        <th scope="col">Мать</th>
                        <th scope="col">Пол</th>
                        <th scope="col">Год рож.</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 10; $i++)
                        <tr>
                            <th scope="row">
                                <img src="{{ asset('images/pages/user/search-animal/red.png') }}" alt="">
                            </th>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, sequi?</td>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, sequi?</td>
                            <td>Lorem ipsum dolor sit amet</td>
                            <td>M</td>
                            <td>XXXX</td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <div class="list__pagination">
                <a href="" class="list__page">
                    << /a>
                        <a href="" class="list__page list__page--active">20</a>
                        <a href="" class="list__page">40</a>
                        <a href="" class="list__page">60</a>
                        <a href="" class="list__page">80</a>
                        <a href="" class="list__page">100</a>
                        <a href="" class="list__page">></a>
            </div>

            <div class="list__caption">

                <div class="list__note">
                    <div class="list__icon">
                        <img src="{{ asset('images/pages/user/search-animal/green.png') }}" alt="">
                    </div>
                    Основные данные присутствуют.
                </div>

                <div class="list__note">
                    <div class="list__icon">
                        <img src="{{ asset('images/pages/user/search-animal/red.png') }}" alt="">
                    </div>
                    Отсутствуют основные данные (или некоторые из них: отец, мать, пол, окрас)
                </div>
            </div>

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
