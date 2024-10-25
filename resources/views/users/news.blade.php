<x-layouts.app>

    <x-partials.header />

    <div class="user-news">

        <section class="news">

            <h2 class="news__title">Новости и статьи</h2>

            <div class="news__categories">
                <a href="" class="news__category news__category--active">Все</a>
                <a href="" class="news__category">Новости</a>
                <a href="" class="news__category">Статьи</a>
                <a href="" class="news__category">События</a>
            </div>

            <div class="news__grid">
                @for ($i = 0; $i < 16; $i++)
                    <div class="news__item">
                        <div class="news__image">
                            <img src="{{ asset('images/pages/user/home/news/news-'.($i % 4 + 1).'.webp') }}" alt="image">
                            <span class="news__label">Раздел новости</span>
                        </div>
                        <div class="news__content">
                            <h4 class="news__heading">Заголовок последней новости в несколько строк</h4>
                            <p class="news__description">Описание в 1-2 строчки</p>
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
