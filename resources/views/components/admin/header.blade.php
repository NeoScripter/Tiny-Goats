<header class="header">

    <div class="header__headline">

        <div class="header__signup">
            <a href="{{ route('logout') }}" class="header__signup-link">Выход</a>

            <a href="{{ route('admin.index') }}" class="header__user-icon">
                <img src="{{ asset('images/svgs/user.svg') }}" alt="Иконка пользователя">
            </a>
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
            <li>
                <button class="header__nav-btn" x-data="{ showDropdown: false, timer: null }"
                    @mouseenter="clearTimeout(timer); showDropdown = true"
                    @mouseleave="timer = setTimeout(() => showDropdown = false, 200)">
                    Новости
                    <ul class="header__nav-dropdown" x-cloak x-show="showDropdown"
                        @mouseleave="showDropdown = false">
                        <li><a href="{{ route('news.index') }}" class="header__dropdown-link">Управлять</a></li>
                        <li><a href="{{ route('news.create') }}" class="header__dropdown-link">Добавить</a></li>
                    </ul>
                </button>
            </li>
            <li>
                <button class="header__nav-btn" x-data="{ showDropdown: false, timer: null }"
                    @mouseenter="clearTimeout(timer); showDropdown = true"
                    @mouseleave="timer = setTimeout(() => showDropdown = false, 200)">
                    Животные
                    <ul class="header__nav-dropdown" x-cloak x-show="showDropdown"
                        @mouseleave="showDropdown = false">
                        <li><a href="{{ route('animals.index') }}" class="header__dropdown-link">Управлять</a></li>
                        <li><a href="{{ route('animals.create') }}" class="header__dropdown-link">Добавить</a></li>
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
                        <li><a href="{{ route('households.index') }}" class="header__dropdown-link">Управлять</a></li>
                        <li><a href="{{ route('household.create') }}" class="header__dropdown-link">Добавить</a></li>
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
                        <li><a href="{{ route('specialists.index') }}" class="header__dropdown-link">Управлять</a></li>
                        <li><a href="{{ route('specialist.create') }}" class="header__dropdown-link">Добавить</a></li>
                    </ul>
                </button>
            </li>
            <li><a href="{{ route('animals.index.sale') }}" class="header__nav-link {{ Route::is('animals.index.sale') ? 'header__nav-link--active' : '' }}">На продажу</a></li>
            <li>
                <button class="header__nav-btn" x-data="{ showDropdown: false, timer: null }"
                    @mouseenter="clearTimeout(timer); showDropdown = true"
                    @mouseleave="timer = setTimeout(() => showDropdown = false, 200)">
                    Партнеры
                    <ul class="header__nav-dropdown" x-cloak x-show="showDropdown"
                        @mouseleave="showDropdown = false">
                        <li><a href="{{ route('partners.index') }}" class="header__dropdown-link">Управлять</a></li>
                        <li><a href="{{ route('partner.create') }}" class="header__dropdown-link">Добавить</a></li>
                    </ul>
                </button>
            </li>
        </ul>
    </nav>
</header>
