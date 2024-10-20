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
                                <img src="{{ asset("images/pages/home/index-slide-$i.webp") }}" alt="image">
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

    </div>

    <x-partials.footer />

</x-layouts.app>
