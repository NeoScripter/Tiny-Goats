<x-layouts.app>

    <x-partials.header />

    <div class="user-search">

        <section class="results">

            <form method="GET" action="{{ route('users.search') }}" class="results__search">
                <input type="search" name="query" placeholder="Поиск по животным">
                <button type="submit" class="results__search-btn">Найти</button>
            </form>


            @isset($paginatedResults)
                <ul class="results__ul">
                    @forelse ($paginatedResults as $result)
                        <li>
                            @if ($result['type'] === 'animal')
                                <h3>Животные</h3>
                                <a
                                    href="{{ route('user.animals.show', $result['data']->id) }}">{{ $result['data']->name }}</a>
                                @isset($result['data']->father->name)
                                    <p>Имя отца: {{ $result['data']->father->name }}</p>
                                @endisset
                                @isset($result['data']->mother->name)
                                    <p>Имя матери: {{ $result['data']->mother->name }}</p>
                                @endisset
                                <p>Дата рождения: {{ \Carbon\Carbon::parse($result['data']->birthDate)->format('d.m.Y') }}
                                </p>
                            @elseif ($result['type'] === 'household')
                                <h3>Хозяйства</h3>
                                <a
                                    href="{{ route('user.household.show', $result['data']->id) }}">{{ $result['data']->name }}</a>
                                @isset($result['data']->owner)
                                    <p>Владелец: {{ $result['data']->owner }}</p>
                                @endisset
                                @isset($result['data']->region)
                                    <p>Область: {{ $result['data']->region }}</p>
                                @endisset
                                @isset($result['data']->country)
                                    <p>Страна: {{ $result['data']->country }}</p>
                                @endisset
                            @elseif ($result['type'] === 'specialist')
                                <h3>Специалисты</h3>
                                <a
                                    href="{{ route('user.specialist.show', $result['data']->id) }}">{{ $result['data']->name }}</a>
                                @isset($result['data']->speciality)
                                    <p>Специальность: {{ $result['data']->speciality }}</p>
                                @endisset
                            @elseif ($result['type'] === 'news')
                                <h3>Новости</h3>
                                <a
                                    href="{{ route('user.news.show', $result['data']->id) }}">{{ $result['data']->title }}</a>
                                @isset($result['data']->content)
                                    <p>{{ $result['data']->content }}</p>
                                @endisset
                            @elseif ($result['type'] === 'partner')
                                <h3>Партнеры</h3>
                                <a
                                    href="{{ route('user.partner.show', $result['data']->id) }}">{{ $result['data']->name }}</a>
                                @isset($result['data']->info)
                                    <p>{{ $result['data']->info }}</p>
                                @endisset
                            @endif
                        </li>
                    @empty
                        <li>
                            По вашему запросу не найдено ни одного результата
                        </li>
                    @endforelse
                </ul>
            @endisset

            {{ $paginatedResults->appends(request()->except('page'))->links('vendor.pagination.default') }}

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
