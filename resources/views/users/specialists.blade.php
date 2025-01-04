<x-layouts.app>

    <x-partials.header />

    <div class="user-specialists">

        <section class="list">

            <h1 class="list__title">Специалисты</h1>

            <form method="GET" action="{{ route('user.specialists.index') }}" class="list__seach-bar">
                <input type="search" name="name" placeholder="Поиск по специалистам">
                <button type="submit" class="list__search-btn">Найти</button>
                <a href="/register" class="list__add-btn">Добавить специалиста</a>
            </form>

            <div class="list__categories">
                <a href="{{ route('user.specialists.index') }}"
                    class="list__category {{ empty(request()->query()) ? 'list__key--active' : '' }}">
                    Все
                </a>
            </div>

            <div class="list__keys">


                @php
                    $letters = array_map(fn($code) => mb_chr($code, 'UTF-8'), range(0x0410, 0x042f));
                @endphp

                @foreach ($letters as $letter)
                    <a href="{{ route('user.specialists.index', array_merge(request()->query(), ['char' => $letter])) }}"
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

                @isset($specialists)
                    <tbody>
                        @forelse ($specialists as $index => $specialist)
                            <tr>
                                <td>
                                    <a href="{{ route('user.specialist.show', $specialist->id) }}"
                                        class="list__link">{{ $specialist->name }}</a>
                                </td>
                                <td>{{ $specialist->speciality ? $specialist->speciality : '?' }}
                                </td>
                            </tr>
                        @empty
                            <p style="text-align: center;">По вашему запросу не найдено ни одного результата</p>
                        @endforelse
                    </tbody>
                @endisset
            </table>

            {{ $specialists->links('vendor.pagination.default') }}

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
