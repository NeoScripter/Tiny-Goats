<header class="lg-header">

    <div class="lg-header__headline">

        <div class="lg-header__signup">
            <a href="" class="lg-header__signup-link">Регистрация</a>

            <div class="lg-header__user-icon">
                <img src="{{ asset('images/svgs/user.svg') }}" alt="Иконка пользователя">
            </div>
        </div>

        <div class="lg-header__search">
            <input type="search" placeholder="Поиск по сайту">
            <button class="lg-header__search-btn">Найти</button>
        </div>

    </div>

    <div class="lg-header__logo">
        <img src="{{ asset('images/partials/logo-header.webp') }}" alt="Реестр карликовых коз, логотип">
    </div>

    <nav class="lg-header__nav">
        <ul class="lg-header__ul">
            <li><a href="" class="lg-header__nav-link">Правила</a></li>
            <li><a href="" class="lg-header__nav-link">Новости</a></li>
            <li>
                <button class="lg-header__nav-btn" x-data="{ showDropdown: false, timer: null }"
                    @mouseenter="clearTimeout(timer); showDropdown = true"
                    @mouseleave="timer = setTimeout(() => showDropdown = false, 200)">
                    Животные
                    <ul class="lg-header__nav-dropdown" x-cloak x-show="showDropdown"
                        @mouseleave="showDropdown = false">
                        <li><a href="" class="lg-header__dropdown-link">Поиск</a></li>
                        <li><a href="" class="lg-header__dropdown-link">Добавить</a></li>
                        <li><a href="" class="lg-header__dropdown-link">Список</a></li>
                        <li><a href="" class="lg-header__dropdown-link">Подбор пар</a></li>
                    </ul>
                </button>
            </li>
            <li>
                <button class="lg-header__nav-btn" x-data="{ showDropdown: false, timer: null }"
                    @mouseenter="clearTimeout(timer); showDropdown = true"
                    @mouseleave="timer = setTimeout(() => showDropdown = false, 200)">
                    Хозяйства
                    <ul class="lg-header__nav-dropdown" x-cloak x-show="showDropdown"
                        @mouseleave="showDropdown = false">
                        <li><a href="" class="lg-header__dropdown-link">Поиск</a></li>
                        <li><a href="" class="lg-header__dropdown-link">Добавить</a></li>
                        <li><a href="" class="lg-header__dropdown-link">Список</a></li>
                    </ul>
                </button>
            </li>
            <li>
                <button class="lg-header__nav-btn" x-data="{ showDropdown: false, timer: null }"
                    @mouseenter="clearTimeout(timer); showDropdown = true"
                    @mouseleave="timer = setTimeout(() => showDropdown = false, 200)">
                    Специалисты
                    <ul class="lg-header__nav-dropdown" x-cloak x-show="showDropdown"
                        @mouseleave="showDropdown = false">
                        <li><a href="" class="lg-header__dropdown-link">Поиск</a></li>
                        <li><a href="" class="lg-header__dropdown-link">Добавить</a></li>
                        <li><a href="" class="lg-header__dropdown-link">Список</a></li>
                    </ul>
                </button>
            </li>
            <li><a href="" class="lg-header__nav-link">На продажу</a></li>
            <li><a href="" class="lg-header__nav-link">Партнеры</a></li>
            <li><a href="" class="lg-header__nav-link">Контакты</a></li>
        </ul>
    </nav>
</header>
