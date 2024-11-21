<x-layouts.app>

    <x-partials.header />

    <div class="user-partners">

        <section class="news">

            <h2 class="news__title">Наши партнеры</h2>


            <div class="news__grid">
                @for ($i = 0; $i < 6; $i++)
                    <div class="news__item">
                        <div class="news__image">
                            <img src="{{ asset('images/pages/user/partners/partner-'.($i % 3 + 1).'.webp') }}" alt="Фото компании">
                        </div>
                        <div class="news__content">
                            <h4 class="news__heading">Название компании</h4>
                            <p class="news__description">Информация о партнере, услугах, акциях, скидке</p>
                            <p class="news__description">Условия получения</p>
                            <a href="" class="news__description">Ссылка на сайт и контакты</a>
                        </div>
                    </div>
                @endfor
            </div>

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
