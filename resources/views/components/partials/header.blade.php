<header class="header">

    <div class="header__headline">

        <div class="header__signup">
            <a href="/register" class="header__signup-link">Регистрация</a>

            <a href="{{ route('admin.index')}}" class="header__user-icon">
                <img src="{{ asset('images/svgs/user.svg') }}" alt="Иконка пользователя">
            </a>
        </div>

        <a href="/" class="header__logo">
            <img src="{{ asset('images/partials/logo-header.webp') }}" alt="Реестр карликовых коз, логотип">
        </a>

        <form method="GET" action="{{ route('users.search') }}" class="header__search">
            <input type="search" name="query" placeholder="Поиск по сайту">
            <button type="submit" class="header__search-btn">Найти</button>
        </form>

    </div>

    <nav class="header__nav">
        <ul class="header__ul">
            <li><a href="/rules" class="header__nav-link {{ Request::is('rules') ? 'header__nav-link--active' : '' }}">Правила</a></li>
            <li><a href="{{ route('user.news.index') }}" class="header__nav-link {{ Route::is('user.news.index') ? 'header__nav-link--active' : '' }}">Новости</a></li>
            <li>
                <button class="header__nav-btn" x-data="{ showDropdown: false, timer: null }"
                    @mouseenter="clearTimeout(timer); showDropdown = true"
                    @mouseleave="timer = setTimeout(() => showDropdown = false, 200)">
                    Животные
                    <ul class="header__nav-dropdown" x-cloak x-show="showDropdown"
                        @mouseleave="showDropdown = false">
                        <li><a href="/animals" class="header__dropdown-link">Список</a></li>
                        <li><a href="/coupling" class="header__dropdown-link">Подбор пар</a></li>
                    </ul>
                </button>
            </li>
            <li><a href="/households" class="header__nav-link {{ Request::is('households') ? 'header__nav-link--active' : '' }}">Хозяйства</a></li>
            <li><a href="/specialists" class="header__nav-link {{ Request::is('specialists') ? 'header__nav-link--active' : '' }}">Специалисты</a></li>
            <li><a href="/sell" class="header__nav-link {{ Request::is('sell') ? 'header__nav-link--active' : '' }}">На продажу</a></li>
            <li><a href="/partners" class="header__nav-link {{ Request::is('partners') ? 'header__nav-link--active' : '' }}">Партнеры</a></li>
            <li><a href="/contacts" class="header__nav-link {{ Request::is('contacts') ? 'header__nav-link--active' : '' }}">Контакты</a></li>
        </ul>
    </nav>
</header>
