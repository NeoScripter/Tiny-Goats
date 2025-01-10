<x-layouts.app>

    <x-admin.header />

    <div class="user-seach-animal">

        @isset($animals)

            <section class="list">

                <h1 class="list__title">Животные</h1>

                <form method="GET" action="{{ route('animals.index') }}" class="list__seach-bar">
                    <input type="search" name="name" placeholder="Поиск по животным">
                    <button type="submit" class="list__search-btn">Найти</button>
                    <a href="{{ route('animals.create') }}" class="list__add-btn">Добавить животное</a>
                </form>

                <div class="list__categories">
                    @php
                        $categories = ['Нигерийская', 'Нигерийско-камерунская', 'Камерунская', 'метис', 'другие'];
                    @endphp

                    <a href="{{ route('animals.index') }}"
                        class="list__category {{ empty(request()->query()) ? 'list__key--active' : '' }}">
                        Все
                    </a>

                    @foreach ($categories as $category)
                        <a href="{{ route('animals.index', array_merge(request()->query(), ['breed' => $category])) }}"
                            class="list__category {{ strtolower(request('breed')) == strtolower($category) ? 'list__key--active' : '' }}">
                            {{ $category }}
                        </a>
                    @endforeach
                    <a href="{{ route('animals.index', array_merge(request()->query(), ['gender' => 'male'])) }}"
                        class="list__key {{ request('gender') == 'male' ? 'list__key--active' : '' }}">
                        М
                    </a>
                    <a href="{{ route('animals.index', array_merge(request()->query(), ['gender' => 'female'])) }}"
                        class="list__key {{ request('gender') == 'female' ? 'list__key--active' : '' }}">
                        Ж
                    </a>
                </div>

                <div class="list__keys">


                    @php
                        $englishLetters = range('A', 'Z');

                        $russianLetters = array_map(fn($code) => mb_chr($code, 'UTF-8'), range(0x0410, 0x042f));

                        $letters = array_merge($englishLetters, $russianLetters);

                    @endphp

                    @foreach ($letters as $letter)
                        <a href="{{ route('animals.index', array_merge(request()->query(), ['char' => $letter])) }}"
                            class="list__key {{ request('char') == $letter ? 'list__key--active' : '' }}">
                            {{ $letter }}
                        </a>
                    @endforeach
                </div>

                <table class="list__table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Кличка</th>
                            <th scope="col">Отец</th>
                            <th scope="col">Мать</th>
                            <th scope="col">Пол</th>
                            <th scope="col">Год рож.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($animals as $index => $animal)
                            <tr>
                                <th scope="row">
                                    @if (in_array(null, [
                                            $animal->mother_id,
                                            $animal->father_id,
                                            $animal->isMale,
                                            $animal->breed,
                                            $animal->color,
                                            $animal->eyeColor,
                                            $animal->birthDate,
                                            $animal->hornedness,
                                            $animal->birthCountry,
                                            $animal->residenceCountry,
                                        ]))
                                        <img src="{{ asset('images/pages/user/search-animal/red.png') }}"
                                            alt="Красный олень">
                                    @else
                                        <img src="{{ asset('images/pages/user/search-animal/green.png') }}"
                                            alt="Зеленый олень">
                                    @endif
                                </th>
                                <td>
                                    <a href="{{ route('animals.show', $animal->id) }}"
                                        class="list__link">{{ $animal->name }}</a>
                                </td>
                                <td>
                                    @if ($animal->father)
                                        <a href="{{ route('animals.show', $animal->father->id) }}"
                                            class="list__link">{{ $animal->father->name }}</a>
                                    @else
                                        ?
                                    @endif
                                </td>
                                <td>
                                    @if ($animal->mother)
                                        <a href="{{ route('animals.show', $animal->mother->id) }}"
                                            class="list__link">{{ $animal->mother->name }}</a>
                                    @else
                                        ?
                                    @endif
                                </td>
                                <td>{{ $animal->isMale ? 'Козел' : 'Коза' }}</td>
                                <td>{{ $animal->birthDate ? \Carbon\Carbon::parse($animal->birthDate)->format('d.m.Y') : '?' }}
                                </td>
                            </tr>
                        @empty
                            <p style="text-align: center;">По вашему запросу не найдено ни одного результата</p>
                        @endforelse
                    </tbody>
                </table>

                {{ $animals->links('vendor.pagination.default') }}

                <div class="list__caption">

                    <div class="list__note">
                        <div class="list__icon">
                            <img src="{{ asset('images/pages/user/search-animal/green.png') }}"
                                alt="Зеленая фигурка оленя">
                        </div>
                        Основные данные присутствуют.
                    </div>

                    <div class="list__note">
                        <div class="list__icon">
                            <img src="{{ asset('images/pages/user/search-animal/red.png') }}" alt="Красная фигурка оленя">
                        </div>
                        Отсутствуют основные данные (или некоторые из них: отец, мать, пол, окрас)
                    </div>
                </div>

            </section>

        @endisset

    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="notification-popup">
            {{ session('success') }}
        </div>
    @endif


    <x-partials.footer />

</x-layouts.app>
