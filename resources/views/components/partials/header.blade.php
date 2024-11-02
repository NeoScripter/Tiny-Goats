<header class="header">

    <div class="header__headline">

        <div class="header__signup">
            <a href="/register" class="header__signup-link">Регистрация</a>

            <div class="header__user-icon">
                <img src="{{ asset('images/svgs/user.svg') }}" alt="Иконка пользователя">
            </div>
        </div>

        <a href="/" class="header__logo">
            <img src="{{ asset('images/partials/logo-header.webp') }}" alt="Реестр карликовых коз, логотип">
        </a>

        <div class="header__search">
            <input type="search" placeholder="Поиск по сайту">
            <button class="header__search-btn">Найти</button>
        </div>

    </div>

    <nav class="header__nav">
        <ul class="header__ul">
            <li><a href="/rules" class="header__nav-link {{ Request::is('rules') ? 'header__nav-link--active' : '' }}">Правила</a></li>
            <li><a href="/news" class="header__nav-link {{ Request::is('news') ? 'header__nav-link--active' : '' }}">Новости</a></li>
            <li>
                <button class="header__nav-btn" x-data="{ showDropdown: false, timer: null }"
                    @mouseenter="clearTimeout(timer); showDropdown = true"
                    @mouseleave="timer = setTimeout(() => showDropdown = false, 200)">
                    Животные
                    <ul class="header__nav-dropdown" x-cloak x-show="showDropdown"
                        @mouseleave="showDropdown = false">
                        <li><a href="/search-animals" class="header__dropdown-link">Поиск</a></li>
                        <li><a href="" class="header__dropdown-link">Добавить</a></li>
                        <li><a href="" class="header__dropdown-link">Список</a></li>
                        <li><a href="" class="header__dropdown-link">Подбор пар</a></li>
                    </ul>
                </button>
            </li>
            <li>
                <button class="header__nav-btn" x-data="{ showDropdown: false, timer: null }"
                    @mouseenter="clearTimeout(timer); showDropdown = true"
                    @mouseleave="timer = setTimeout(() => showDropdown = false, 200)">
                    Хозяйства
                    <ul class="header__nav-dropdown" x-cloak x-show="showDropdown"
                        @mouseleave="showDropdown = false">
                        <li><a href="" class="header__dropdown-link">Поиск</a></li>
                        <li><a href="" class="header__dropdown-link">Добавить</a></li>
                        <li><a href="" class="header__dropdown-link">Список</a></li>
                    </ul>
                </button>
            </li>
            <li>
                <button class="header__nav-btn" x-data="{ showDropdown: false, timer: null }"
                    @mouseenter="clearTimeout(timer); showDropdown = true"
                    @mouseleave="timer = setTimeout(() => showDropdown = false, 200)">
                    Специалисты
                    <ul class="header__nav-dropdown" x-cloak x-show="showDropdown"
                        @mouseleave="showDropdown = false">
                        <li><a href="" class="header__dropdown-link">Поиск</a></li>
                        <li><a href="" class="header__dropdown-link">Добавить</a></li>
                        <li><a href="" class="header__dropdown-link">Список</a></li>
                    </ul>
                </button>
            </li>
            <li><a href="" class="header__nav-link">На продажу</a></li>
            <li><a href="" class="header__nav-link">Партнеры</a></li>
            <li><a href="" class="header__nav-link">Контакты</a></li>
        </ul>
    </nav>
</header>
