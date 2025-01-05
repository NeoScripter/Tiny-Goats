<x-layouts.app>

    <x-partials.header />

    <div class="user-contacts">

        <section class="preview">
            <h1 class="preview__title">Наши контакты</h1>

            <p class="preview__uppercase">Реестр карликовых коз  России нуждается в постоянном усовершенствовании и доработке. Мы будем благодарны, если вы окажете проекту помощь донатом. По вопросам поддержки сайта обращаться к Администратору</p>

            <a href="tel:+79521872133" class="preview__link">+7 952 187 21 33</a>
            <a href="mailto:reestrkoz@yandex.ru" class="preview__link">reestrkoz@yandex.ru</a>

            <div class="preview__socials">
                @php
                    $paths = [
                        'https://wa.me/+79521872133',
                        'https://t.me/reestrkoz',
                        'https://vk.com/club22792383'
                    ]
                @endphp

                @for ($i = 1; $i < 4; $i++)
                    <a href={{ $paths[$i - 1] }} class="preview__social">
                        <img src="{{ asset('/images/pages/user/register/register-' . $i . '.webp') }}" alt="Ромашка" aria-label="hidden">
                    </a>
                @endfor
            </div>
        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
