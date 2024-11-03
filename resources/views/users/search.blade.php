<x-layouts.app>

    <x-partials.header />

    <div class="user-search">

        <section class="results">

            <div class="results__search">
                <input type="search" placeholder="Поиск по сайту">
                <button class="results__search-btn">Найти</button>
            </div>

            <ul class="results__ul">
                @for ($i = 0; $i < 7; $i++)
                    <li>
                        <h3>Животные</h3>
                        <a href="">Кличка животного</a>
                        <p>Отец</p>
                        <p>Мать</p>
                        <p>Год рождения</p>
                    </li>
                @endfor
            </ul>

            <div class="news__pagination">
                <a href="" class="news__page"><<</a>
                <a href="" class="news__page news__page--active">1</a>
                <a href="" class="news__page">2</a>
                <a href="" class="news__page">3</a>
                <a href="" class="news__page">4</a>
                <a href="" class="news__page">5</a>
                <a href="" class="news__page">>></a>
            </div>
        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
