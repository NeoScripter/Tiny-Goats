<x-layouts.app>

    <x-partials.header />

    <div class="user-sell">

        <section class="news">

            <h2 class="news__title">Животные на продажу</h2>


            <div class="news__grid">
                @for ($i = 0; $i < 16; $i++)
                    <div class="news__item">
                        <div class="news__image">
                            <img src="{{ asset('images/pages/user/home/news/news-'.($i % 4 + 1).'.webp') }}" alt="image">
                        </div>
                        <div class="news__content">
                            <h4 class="news__heading">Кличка животного</h4>
                            <p class="news__description">DD.MM.YYYY</p>
                            <p class="news__description">порода</p>
                        </div>
                    </div>
                @endfor
            </div>


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
