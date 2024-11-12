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
                        <a href="">добавить</a>
                        <a href="">управлять</a>
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

            <h2 class="admin__subtitle">Последние изменения</h2>

            <div class="admin__table-controls">
                <div class="admin__table-label">Выберете период</div>
                <select name="" id="" class="admin__btn">
                    <option value="">1 день</option>
                    <option value="">2 дня</option>
                </select>
            </div>
            <table class="admin__table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Кличка</th>
                        <th scope="col">Дата изменения</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 10; $i++)
                        <tr>
                            <th scope="row">
                                <img src="{{ asset('images/pages/user/search-animal/red.png') }}" alt="">
                            </th>
                            <td>Lorem ipsum dolor sit amet</td>
                            <td>DD.MM.YYYY</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
