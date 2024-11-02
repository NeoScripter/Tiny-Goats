<x-layouts.app>

    <x-partials.header />

    <div class="register">

        <section class="preview">
            <img src="{{ asset('/images/pages/user/rules/rules-2.webp') }}" alt="" class="preview__image">

            <h1 class="preview__title">Регистрация в Реестре</h1>

            <p class="preview__prg">Для регистрации животного / хозяйства / специалиста / партнёра</p>

            <p class="preview__uppercase">необходимо ознакомиться с правилами регистрации.</p>

            <a href="/rules" class="preview__btn">Правила сайта</a>
        </section>

        <section class="instructions">

            <img src="{{ asset('/images/pages/user/rules/rules-3.webp') }}" alt="Ромашка" aria-label="hidden" class="instructions__image">

            <h2 class="instructions__title">Как зарегистрироваться</h2>

            <p class="instructions__paragraph">Для регистрации в “Реестре карликовых коз России” необходимо Выслать Администратору сайта имеющуюся информацию, согласно правилам сайта,  удобным для вас способом</p>

            <p class="instructions__bold">с пометкой / темой  "Регистрация в Реестре"</p>

            <div class="instructions__socials">
                @php
                    $paths = [
                        'https://wa.me/+79521872133',
                        'https://t.me/reestrkoz',
                        'https://vk.com/club22792383',
                        'mailto:reestrkoz@yandex.ru'
                    ]
                @endphp

                @for ($i = 1; $i < 5; $i++)
                    <a href={{ $paths[$i - 1] }} class="instructions__social">
                        <img src="{{ asset('/images/pages/user/register/register-' . $i . '.webp') }}" alt="Ромашка" aria-label="hidden">
                    </a>
                @endfor
            </div>

        </section>

        <section class="notice">

            <img src="{{ asset('/images/pages/user/rules/rules-3.webp') }}" alt="Ромашка" aria-label="hidden" class="notice__image">

            <h3 class="notice__title">Передавая данные о себе и своих животных для регистрации в Реестре, пользователи автоматически дают разрешение администрации сайта о внесении их в базу Реестра в общий доступ.</h3>

            <div class="notice__description">
                Все заявки рассматриваются вручную, поэтому на внесение в реестр потребуется время. Если вам не пришел ответ, значит заявка одобрена и в течение 14 дней животное отобразится на сайте. Если в заявке не будет хватать данных или потребуется уточнить какую-либо информацию, мы напрвим ответное письмо на тот же контакт, с которого была отправлена заявка.
            </div>

            <h4 class="notice__prompt">Если у вас остались вопросы, предлагаемся ознакомиться с разделом</h4>

            <a href="/faq" class="notice__link">Популярные вопросы</a>

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
