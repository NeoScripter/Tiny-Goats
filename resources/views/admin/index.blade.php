<x-layouts.app>

    <x-partials.header />

    <div class="admin">

        <section class="admin__nav">

            <h1 class="admin__heading">Страница администратора</h1>

            <div class="admin__panel">
                <div class="admin__group">
                    <h3>Новости</h3>
                    <div class="admin__links">
                        <a href="{{ route('news.create') }}">добавить</a>
                        <a href="{{ route('news.index') }}">управлять</a>
                    </div>
                </div>
                <div class="admin__group">
                    <h3>Животные</h3>
                    <div class="admin__links">
                        <a href="{{ route('animals.create') }}">добавить</a>
                        <a href="{{ route('animals.index') }}">управлять</a>
                    </div>
                </div>
                <div class="admin__group">
                    <h3>Хозяйства</h3>
                    <div class="admin__links">
                        <a href="">добавить</a>
                        <a href="">управлять</a>
                    </div>
                </div>
                <div class="admin__group">
                    <h3>Специалисты</h3>
                    <div class="admin__links">
                        <a href="">добавить</a>
                        <a href="">управлять</a>
                    </div>
                </div>
                <div class="admin__group">
                    <h3>На продажу</h3>
                    <div class="admin__links">
                        <a href="">добавить</a>
                        <a href="">управлять</a>
                    </div>
                </div>
                <div class="admin__group">
                    <h3>Партнеры</h3>
                    <div class="admin__links">
                        <a href="">добавить</a>
                        <a href="">управлять</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="admin__changes">

            <form method="GET" action="{{ route('admin.index') }}">
                <h2 class="admin__subtitle">Последние изменения</h2>

                <div class="admin__table-controls">
                    <div class="admin__table-label">Выберете период</div>
                    <select name="days" class="admin__btn">
                        <option value="1" {{ request('days') == 1 ? 'selected' : '' }}>1 день</option>
                        <option value="2" {{ request('days') == 2 ? 'selected' : '' }}>2 дня</option>
                        <option value="3" {{ request('days') == 3 ? 'selected' : '' }}>3 дня</option>
                        <option value="4" {{ request('days') == 4 ? 'selected' : '' }}>4 дня</option>
                        <option value="7" {{ request('days') == 7 || !request('days') ? 'selected' : '' }}>7 дней
                        </option>
                        <option value="15" {{ request('days') == 15 ? 'selected' : '' }}>15 дней</option>
                        <option value="30" {{ request('days') == 30 ? 'selected' : '' }}>30 дней</option>
                        <option value="60" {{ request('days') == 60 ? 'selected' : '' }}>60 дней</option>
                    </select>
                </div>

                <button type="submit" class="admin__search-btn">Показать</button>
            </form>

            @if(isset($animals))
            <table class="admin__table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Кличка</th>
                        <th scope="col">Дата изменения</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($animals as $index => $animal)
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
                                <td>{{ \Carbon\Carbon::parse($animal->updated_at)->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach

                </tbody>
            </table>

            {{ $animals->links('vendor.pagination.default') }}
            @else
                <p class="admin__nothing-found">Изменения за указанный период отсутствуют</p>
            @endif
        </section>

    </div>


    <x-partials.footer />

    @if (request()->query())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.location.search) {
                    window.scrollTo(0, document.body.scrollHeight);
                }
            });
        </script>
    @endif

</x-layouts.app>
