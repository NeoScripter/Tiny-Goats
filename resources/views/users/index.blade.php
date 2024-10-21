<x-layouts.app>

    <x-partials.large-header />

    <div class="user-home">

        <section class="goals">

            <h1 class="goals__title">О Реестре. Цели и задачи</h1>

            <div class="goals__flex">
                <div class="goals__content">

                    <p class="goals__intro">
                        <strong>Цель сайта  «Реестр карликовых коз России»</strong> -  популяризация карликовых коз и статистические
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

                    <a href="" class="goals__link">Продолжить чтение</a>
                </div>

                <div class="goals__carousel" x-data="{ currentSlide: 0, totalSlides: 5 }">
                    <div class="goals__viewport" :style="{ transform: `translateX(${currentSlide * -100}%)` }">
                        @for ($i = 1; $i < 6; $i++)
                            <div class="goals__image">
                                <img src="{{ asset("images/pages/user/home/goals/index-slide-$i.webp") }}" alt="image">
                            </div>
                        @endfor
                    </div>

                    <div class="goals__controls">
                        <button class="goals__btn" @click="currentSlide = (currentSlide - 1 + totalSlides) % totalSlides">
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

                <button class="animals__btn">Смотреть все</button>
            </div>

            <div class="animals__wrapper" x-data="{ currentSlide: 0, totalSlides: 8 }">
                <button class="animals__controller animals__btn--prev" x-show="currentSlide !== 0" @click="currentSlide = currentSlide - 1">
                    {!! file_get_contents(public_path('images/svgs/prev-btn-dark.svg')) !!}
                </button>
                <div class="animals__carousel">
                    <div class="animals__viewport" :style="{ transform: `translateX(${currentSlide * -25}%)` }">
                        @for ($i = 1; $i < 9; $i++)
                            <div class="animals__item">
                                <div class="animals__image">
                                    <img src="{{ asset("images/pages/user/home/animals/animal-$i.webp") }}" alt="image">
                                </div>
                                <h4 class="animals__name">Кличка</h4>
                                <p class="animals__breed">Порода</p>
                            </div>
                        @endfor
                    </div>
                </div>
                <button class="animals__controller animals__btn--next"  x-show="currentSlide !== (totalSlides - 4)" @click="currentSlide = currentSlide + 1">
                    {!! file_get_contents(public_path('images/svgs/next-btn-dark.svg')) !!}
                </button>
            </div>

        </section>

        <section class="farm">

            <div class="farm__headline">
                <h2 class="farm__title">Хозяйства</h2>

                <button class="farm__btn">Смотреть все</button>
            </div>

            <div class="farm__wrapper" x-data="{ currentSlide: 0, totalSlides: 6 }">
                <button class="farm__controller farm__btn--prev" x-show="currentSlide !== 0" @click="currentSlide = currentSlide - 1">
                    {!! file_get_contents(public_path('images/svgs/prev-btn-dark.svg')) !!}
                </button>
                <div class="farm__carousel">
                    <div class="farm__viewport" :style="{ transform: `translateX(${currentSlide * -33}%)` }">
                        @for ($i = 1; $i < 7; $i++)
                            <div class="farm__item">
                                <div class="farm__image">
                                    <img src="{{ asset("images/pages/user/home/farm/farm-$i.webp") }}" alt="image">
                                </div>
                                <h4 class="farm__name">Хозяйство 3</h4>
                                <p class="farm__place">Регион</p>
                                <p class="farm__description">Описание</p>
                            </div>
                        @endfor
                    </div>
                </div>
                <button class="farm__controller farm__btn--next"  x-show="currentSlide !== (totalSlides - 3)" @click="currentSlide = currentSlide + 1">
                    {!! file_get_contents(public_path('images/svgs/next-btn-dark.svg')) !!}
                </button>
            </div>

        </section>

        <section class="news">

            <div class="news__headline">
                <h2 class="news__title">Новости и статьи</h2>

                <button class="news__btn">Смотреть все</button>
            </div>


                <div class="news__grid">
                    @for ($i = 1; $i < 5; $i++)
                        <div class="news__item">
                            <div class="news__image">
                                <img src="{{ asset("images/pages/user/home/news/news-$i.webp") }}" alt="image">
                                <span class="news__label">Раздел новости</span>
                            </div>
                            <div class="news__content">
                                <h4 class="news__heading">Заголовок последней новости в несколько строк</h4>
                                <p class="news__description">Описание в 1-2 строчки</p>
                            </div>
                        </div>
                    @endfor
                </div>

        </section>

        <section class="faq">

            <h2 class="faq__title">Ответы на популярные вопросы</h2>

            <p class="faq__subtitle">Предлагаем ознакомиться с ответами на самые популярные вопросы, а так же <a href="" class="faq__link">правилами</a> нашего сайта “Реестр карликовых коз России”</p>

            <ul class="faq__list">
                <li class="faq__li">
                    <h3 class="faq__heading">Как я могу зарегистрировать/перерегистрировать, обновить карточку животного, или сменить владельца?</h3>
                    <p class="faq__content">Для регистрации/перерегистрации, смены владельца и обновления карточки животного вам нужно отправить запрос Администратору по указанным на сайте контактам.</p>
                </li>
                <li class="faq__li">
                    <h3 class="faq__heading">Какая цена регистрации  животных в Реестре?</h3>
                    <p class="faq__content">Животные регистрируются бесплатно.  Возможно добровольное пожертвование в виде доната.</p>
                </li>
                <li class="faq__li">
                    <h3 class="faq__heading">На каком языке осуществляется регистрация животных?</h3>
                    <p class="faq__content">Регистрация животных, рождённых в России, осуществляется на русском языке (кириллицей). Регистрация импортных животных осуществляется на  английском языке (латинницей).</p>
                </li>
                <li class="faq__li">
                    <h3 class="faq__heading">На какой срок можно зарегистрировать животное в каталоге?</h3>
                    <p class="faq__content">Животное в Реестре регистрируется единожды и остаётся в нём на постоянной основе.</p>
                </li>
                <li class="faq__li">
                    <h3 class="faq__heading">Как зарегистрировать хозяйство?</h3>
                    <p class="faq__content">Для регистрации или обновления карточки хозяйства нужно отправить запрос Администратору по указанным на сайте контактам.</p>
                </li>
                <li class="faq__li">
                    <h3 class="faq__heading">Какая цена регистрации хозяйства в Реестре?</h3>
                    <p class="faq__content">Регистрация хозяйств осуществляется бесплатно. Возможно добровольное пожертвование в виде доната.</p>
                </li>
                <li class="faq__li">
                    <h3 class="faq__heading">На каком языке регистрируются хозяйства в Реестре?</h3>
                    <p class="faq__content">Регистрация хозяйств осуществляется на русском языке.</p>
                </li>
                <li class="faq__li">
                    <h3 class="faq__heading">Какие дополнительные сведения о владельце можно внести в карточку хозяйства?</h3>
                    <p class="faq__content">Любые, которые могут дать больше информации о владельце. Например, наличие профильного образования или с какого года ведётся работа с козами в хозяйстве и т.п.</p>
                </li>
            </ul>

            <a href="" class="faq__btn">Читать полностью</a>

        </section>

    </div>

    <x-partials.footer />

</x-layouts.app>
