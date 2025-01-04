<x-layouts.app>

    <x-partials.header />

    <div class="user-households">

        <section class="list">

            <h1 class="list__title">Хозяйства</h1>

            <form method="GET" action="{{ route('user.households.index') }}" class="list__seach-bar">
                <input type="search" name="name" placeholder="Поиск по хозяйствам">
                <button type="submit" class="list__search-btn">Найти</button>
                <a href="/register" class="list__add-btn">Добавить хозяйство</a>
            </form>

            <div class="list__keys">

                @php
                    $letters = array_map(fn($code) => mb_chr($code, 'UTF-8'), range(0x0410, 0x042f));
                @endphp

                @foreach ($letters as $letter)
                    <a href="{{ route('user.households.index', array_merge(request()->query(), ['char' => $letter])) }}"
                        class="list__key {{ request('char') == $letter ? 'list__key--active' : '' }}">
                        {{ $letter }}
                    </a>
                @endforeach
            </div>

            <table class="list__table">
                <thead>
                    <tr>
                        <th scope="col">Название</th>
                        <th scope="col">Владелец</th>
                        <th scope="col">Область</th>
                        <th scope="col">Страна</th>
                    </tr>
                </thead>
                @isset($households)
                    <tbody>
                        @forelse ($households as $index => $household)
                            <tr>
                                <td>
                                    <a href="{{ route('user.household.show', $household->id) }}"
                                        class="list__link">{{ $household->name }}</a>
                                </td>
                                <td>{{ $household->owner ? $household->owner : '?' }}
                                </td>
                                <td>{{ $household->region ? $household->region : '?' }}
                                </td>
                                <td>{{ $household->country ? $household->country : '?' }}
                                </td>
                            </tr>
                        @empty
                            <p style="text-align: center;">По вашему запросу не найдено ни одного результата</p>
                        @endforelse
                    </tbody>
                @endisset
            </table>

            {{ $households->links('vendor.pagination.default') }}

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
