<x-layouts.app>

    <x-partials.header />

    <div class="user-agenda">

        <section class="preview">

            <div class="preview__wrapper">

                <div class="preview__content">

                    <h1 class="preview__title">О Реестре. Цели и задачи</h1>

                    <p class="preview__prg"><strong>Цель сайта  «Реестр карликовых коз России»</strong> -  популяризация
                        карликовых коз и статистические наблюдения за популяцией карликовых коз в России и странах
                        ближнего зарубежья.
                    </p>

                    <p class="preview__prg"><strong>Задачи, решаемые Реестром:</strong>
                    </p>

                    <ul class="preview__ol">
                        <li>Создание максимально обширной информационно-статистической базы имеющегося в России и
                            странах ближнего зарубежья поголовья карликовых коз и их помесей, хозяйств и специалистов в
                            области животноводства.</li>
                        <li>Обеспечение  доступа для козоводов  к информации о происхождении животных, хозяйствах,
                            занимающихся их разведением.</li>
                        <li>Информационная помощь в поиске контактов специалистов сельскохозяйственной отрасли.</li>
                        <li>Возможность для хозяйств найти необходимый для племенной работы  ремонтный молодняк,
                            производителей или производительниц.</li>
                        <li>Возможность составить родословную планируемого потомства, а также оценить степень
                            инбредности при  подборе пар.</li>
                        <li>Образовательная работа с козоводами посредством размещения новостной информации и  статей
                            по темам козоводства.</li>
                        <li>Рассказы о  хозяйствах, занимающихся разведением коз карликовых пород в разных регионах
                            страны и странах ближнего зарубежья.</li>
                        <li>Возможность для хозяйств разместить в общем доступе план селекционной работы, тем самым
                            помогая заранее спланировать и забронировать приобретение ремонтного молодняка будущим
                            владельцам.</li>
                        <li>Привлечение специалистов в области козоводства к работе с козоводами и созданию
                            образовательно-информационной базы посредством публикации их статей на сайте.</li>
                    </ul>

                    <a href="/" class="preview__btn">Вернуться на главную</a>
                </div>

                <div class="preview__images">

                    <div class="preview__image">
                        <img src="{{ asset('images/pages/user/agenda/agenda-1.webp') }}"
                            alt="Девочка, гладящая козленка">
                    </div>

                    <div class="preview__image">
                        <img src="{{ asset('images/pages/user/agenda/agenda-2.webp') }}" alt="Фото козла">
                    </div>
                </div>
            </div>

        </section>

        <section class="news">

            <div class="news__headline">
                <h2 class="news__title">Новости и статьи</h2>

                <a href="{{ route('user.news.index') }}" class="news__btn">Смотреть все</a>
            </div>


            <div class="news__grid">
                @foreach ($latest_news as $news)
                    <div class="news__item">
                        <a href="{{ route('user.news.show', $news->id) }}" class="news__image">
                            <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('images/partials/placeholder.webp') }}"
                                alt="Фото новости">
                            <span class="news__label">Раздел
                                {{ \Illuminate\Support\Str::lower($news->categories[0]) }}</span>
                        </a>
                        <div class="news__content">
                            <h4 class="news__heading">{{ $news->title }}</h4>

                            <x-partials.news-description>
                                {{ $news->content }}
                            </x-partials.news-description>

                        </div>
                    </div>
                @endforeach
            </div>

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
