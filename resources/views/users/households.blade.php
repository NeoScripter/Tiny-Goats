<x-layouts.app>

    <x-partials.header />

    <div class="user-households">

        <section class="list">

            <h1 class="list__title">Хозяйства</h1>

            <div class="list__seach-bar">
                <input type="search" placeholder="Поиск по хозяйствам">
                <button class="list__search-btn">Найти</button>
                <button class="list__add-btn">Добавить животное</button>
            </div>

            <div class="list__keys">

                @php
                    $letters = [
                        'А',
                        'Б',
                        'В',
                        'Г',
                        'Д',
                        'Е',
                        'Ё',
                        'Ж',
                        'З',
                        'И',
                        'Й',
                        'К',
                        'Л',
                        'М',
                        'Н',
                        'О',
                        'П',
                        'Р',
                        'С',
                        'Т',
                        'У',
                        'Ф',
                        'Х',
                        'Ц',
                        'Ч',
                        'Ш',
                        'Щ',
                        'Ъ',
                        'Ы',
                        'Ь',
                        'Э',
                        'Ю',
                        'Я',
                    ];
                @endphp

                @foreach ($letters as $letter)
                    <a href="" class="list__key">{{ $letter }}</a>
                @endforeach
            </div>

            <table class="list__table">
                <thead>
                    <tr>
                        <th scope="col">Название</th>
                        <th scope="col">Владелец</th>
                        <th scope="col">Область</th>
                        <th scope="col">Страна</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 10; $i++)
                        <tr>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, sequi?</td>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, sequi?</td>
                            <td>Lorem ipsum dolor sit amet</td>
                            <td>Lorem ipsum </td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <div class="list__pagination">
                <a href="" class="list__page"><</a>
                <a href="" class="list__page list__page--active">20</a>
                <a href="" class="list__page">40</a>
                <a href="" class="list__page">60</a>
                <a href="" class="list__page">80</a>
                <a href="" class="list__page">100</a>
                <a href="" class="list__page">></a>
            </div>

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>