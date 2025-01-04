<x-layouts.app>

    <x-admin.header />

    <div class="user-seach-animal">

        @isset($households)

            <section class="list">

                <h1 class="list__title">Специалисты</h1>

                <form method="GET" action="{{ route('households.index') }}" class="list__seach-bar">
                    <input type="search" name="name" placeholder="Поиск по специалистам">
                    <button type="submit" class="list__search-btn">Найти</button>
                    <a href="{{ route('household.create') }}" class="list__add-btn">Добавить специалиста</a>
                </form>

                <div class="list__categories">
                    <a href="{{ route('households.index') }}"
                        class="list__category {{ empty(request()->query()) ? 'list__key--active' : '' }}">
                        Все
                    </a>
                </div>

                <div class="list__keys">


                    @php
                        $letters = array_map(fn($code) => mb_chr($code, 'UTF-8'), range(0x0410, 0x042f));
                    @endphp

                    @foreach ($letters as $letter)
                        <a href="{{ route('households.index', array_merge(request()->query(), ['char' => $letter])) }}"
                            class="list__key {{ request('char') == $letter ? 'list__key--active' : '' }}">
                            {{ $letter }}
                        </a>
                    @endforeach
                </div>

                <table class="list__table">
                    <thead>
                        <tr>
                            <th scope="col">Имя</th>
                            <th scope="col">Специальность</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($households as $index => $household)
                            <tr>
                                <td>
                                    <a href="{{ route('household.show', $household->id) }}"
                                        class="list__link">{{ $household->name }}</a>
                                </td>
                                <td>{{ $household->speciality ? $household->speciality : '?' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $households->links('vendor.pagination.default') }}

                <div class="list__caption">
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
