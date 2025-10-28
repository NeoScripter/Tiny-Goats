@php
    $faqs = [
        [
            'heading' =>
                'Как я могу зарегистрировать/перерегистрировать, обновить карточку животного, или сменить владельца?',
            'content' =>
                'Для регистрации/перерегистрации, смены владельца и обновления карточки животного вам нужно отправить запрос Администратору по указанным на сайте контактам.',
        ],
        [
            'heading' => 'Какая цена регистрации животных в Реестре?',
            'content' => 'Животные регистрируются бесплатно. Возможно добровольное пожертвование в виде доната.',
        ],
        [
            'heading' => 'На каком языке осуществляется регистрация животных?',
            'content' =>
                'Регистрация животных, рождённых в России, осуществляется на русском языке (кириллицей). Регистрация импортных животных осуществляется на английском языке (латинницей).',
        ],
        [
            'heading' => 'На какой срок можно зарегистрировать животное в каталоге?',
            'content' => 'Животное в Реестре регистрируется единожды и остаётся в нём на постоянной основе.',
        ],
        [
            'heading' => 'Как зарегистрировать хозяйство?',
            'content' =>
                'Для регистрации или обновления карточки хозяйства нужно отправить запрос Администратору по указанным на сайте контактам.',
        ],
        [
            'heading' => 'Какая цена регистрации хозяйства в Реестре?',
            'content' =>
                'Регистрация хозяйств осуществляется бесплатно. Возможно добровольное пожертвование в виде доната.',
        ],
        [
            'heading' => 'На каком языке регистрируются хозяйства в Реестре?',
            'content' => 'Регистрация хозяйств осуществляется на русском языке.',
        ],
        [
            'heading' => 'Какие дополнительные сведения о владельце можно внести в карточку хозяйства?',
            'content' =>
                'Любые, которые могут дать больше информации о владельце. Например, наличие профильного образования или с какого года ведётся работа с козами в хозяйстве и т.п.',
        ],
    ];
@endphp

<x-layouts.app>

    <x-partials.large-header />

    <div class="user-home">

        <section class="goals">

            <h1 class="goals__title">О Реестре. Цели и задачи</h1>

            <div class="goals__flex">
                <div class="goals__content">

                    <p class="goals__intro">
                        <strong>Цель сайта  «Реестр карликовых коз России»</strong> -  популяризация карликовых коз и
                        статистические
                        наблюдения за популяцией карликовых коз в России и странах ближнего зарубежья.
                    </p>

                    <h4 class="goals__heading">Задачи, решаемые Реестром:</h4>

                    <ol class="goals__ol">
                        <li>1. Создание максимально обширной информационно-статистической базы имеющегося в России и
                            странах ближнего зарубежья поголовья карликовых коз и их помесей, хозяйств и специалистов в
                            области животноводства.</li>
                        <li>2.  Обеспечение  доступа для козоводов  к информации о происхождении животных, хозяйствах,
                            занимающихся их разведением.</li>
                        <li>3.Информационная помощь в поиске контактов специалистов сельскохозяйственной отрасли.</li>
                        <li>4. Возможность для хозяйств найти необходимый для племенной работы  ремонтный молодняк,
                            производителей или производительниц.</li>
                    </ol>

                    <a href="/agenda" class="goals__link">Продолжить чтение</a>
                </div>

                <div class="goals__carousel" x-data="{ currentSlide: 0, totalSlides: 5 }">
                    <div class="goals__viewport" :style="{ transform: `translateX(${currentSlide * -100}%)` }">
                        @for ($i = 1; $i < 6; $i++)
                            <div class="goals__image">
                                <img src="{{ asset("images/pages/user/home/goals/index-slide-$i.webp") }}"
                                    alt="Фото козла">
                            </div>
                        @endfor
                    </div>

                    <div class="goals__controls">
                        <button class="goals__btn"
                            @click="currentSlide = (currentSlide - 1 + totalSlides) % totalSlides">
                            {!! file_get_contents(public_path('images/svgs/prev-btn-light.svg')) !!}
                        </button>
                        <button class="goals__btn" @click="currentSlide = (currentSlide + 1) % totalSlides">
                            {!! file_get_contents(public_path('images/svgs/next-btn-light.svg')) !!}
                        </button>
                    </div>
                </div>

            </div>

        </section>

        <section class="animals">

            <div class="animals__headline">
                <h2 class="animals__title">Животные</h2>

                <a href="/animals" class="animals__btn">Смотреть все</a>
            </div>

            @isset($animals)
                <div class="animals__wrapper" x-data="{ currentSlide: 0, totalSlides: {{ count($animals) }} }">
                    <button class="animals__controller animals__btn--prev" x-show="currentSlide !== 0"
                        @click="currentSlide = currentSlide - 1">
                        {!! file_get_contents(public_path('images/svgs/prev-btn-dark.svg')) !!}
                    </button>
                    <div class="animals__carousel">
                        <div class="animals__viewport" :style="{ transform: `translateX(${currentSlide * -25}%)` }">
                            @foreach ($animals as $animal)
                                <div class="animals__item">
                                    <div class="animals__image">
                                        <img src="{{ isset($animal->images) && isset($animal->images[0])
                                            ? asset('storage/' . $animal->images[0])
                                            : asset('images/partials/placeholder.webp') }}"
                                            alt="Фото козла">
                                    </div>
                                    <a href="{{ route('user.animals.show', $animal->id) }}"
                                        class="animals__name">{{ $animal->name }}</a>
                                    <p class="animals__breed">{{ $animal->breed }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button class="animals__controller animals__btn--next" x-show="currentSlide < (totalSlides - 4)"
                        @click="currentSlide = currentSlide + 1">
                        {!! file_get_contents(public_path('images/svgs/next-btn-dark.svg')) !!}
                    </button>
                </div>
            @endisset

        </section>

        <section class="farm">

            <div class="farm__headline">
                <h2 class="farm__title">Хозяйства</h2>

                <a href="/households" class="farm__btn">Смотреть все</a>
            </div>

            @isset($households)
                <div class="farm__wrapper" x-data="{ currentSlide: 0, totalSlides: 6 }">
                    <button class="farm__controller farm__btn--prev" x-show="currentSlide !== 0"
                        @click="currentSlide = currentSlide - 1">
                        {!! file_get_contents(public_path('images/svgs/prev-btn-dark.svg')) !!}
                    </button>
                    <div class="farm__carousel">
                        <div class="farm__viewport" :style="{ transform: `translateX(${currentSlide * -33}%)` }">
                            @foreach ($households as $household)
                                <div class="farm__item">
                                    <div class="farm__image">
                                        <img src="{{ isset($household->image) && $household->image
                                            ? asset('storage/' . $household->image)
                                            : asset('images/partials/placeholder.webp') }}"
                                            alt="Фото хозяйства">
                                    </div>
                                    <a href="{{ route('user.household.show', $household->id) }}"
                                        class="farm__name">{{ $household->name }}</a>
                                    <p class="farm__place">{{ $household->region }}</p>
                                    <p class="farm__description">{{ $household->breeds }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button class="farm__controller farm__btn--next" x-show="currentSlide < (totalSlides - 3)"
                        @click="currentSlide = currentSlide + 1">
                        {!! file_get_contents(public_path('images/svgs/next-btn-dark.svg')) !!}
                    </button>
                </div>
            @endisset

        </section>

        <section class="news">

            <div class="news__headline">
                <h2 class="news__title">Новости и статьи</h2>

                <a href="{{ route('user.news.index') }}" class="news__btn">Смотреть все</a>
            </div>


            <div class="news__grid">
                @isset($latest_news)
                    @foreach ($latest_news as $news)
                        <div class="news__item">
                            <a href="{{ route('user.news.show', $news->id) }}" class="news__image">
                                <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('images/partials/placeholder.webp') }}"
                                    alt="Фото новости">
                                <span class="news__label">
                                    {{ \Illuminate\Support\Str::title($news->categories[0]) }}</span>
                            </a>
                            <div class="news__content">
                                <h4 class="news__heading">{{ $news->title }}</h4>

                                <x-partials.news-description>
                                    {{ $news->content }}
                                </x-partials.news-description>

                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>

        </section>

        <section class="faq">

            <h2 class="faq__title">Ответы на популярные вопросы</h2>

            <p class="faq__subtitle">Предлагаем ознакомиться с ответами на самые популярные вопросы, а так же <a
                    href="/rules" class="faq__link">правилами</a> нашего сайта “Реестр карликовых коз России”</p>

            <ul class="faq__list">
                @foreach ($faqs as $faq)
                    <li class="faq__li">
                        <h3 class="faq__heading">{{ $faq['heading'] }}</h3>
                        <p class="faq__content">{{ $faq['content'] }}</p>
                    </li>
                @endforeach
            </ul>


            <a href="/faq" class="faq__btn">Читать полностью</a>

        </section>

    </div>

    <x-partials.footer />

</x-layouts.app>
