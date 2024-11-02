<x-layouts.app>

    <x-partials.header />

    <div class="user-household-card">

        <section class="info">

            <div class="info__visual">

                <div class="info__snapshot">
                    <img src="{{ asset('images/pages/user/animal/placeholder.png') }}" alt="">
                </div>

            </div>

            <div class="info__data">
                @for ($i = 0; $i < 5; $i++)
                    <div class="info__item">
                        <div class="info__property">название хозяйства</div>
                        <div class="info__value">LOREM IPSUM, LOREM IPSUM, LOREM IPSUM, LOREM IPSUM, LOREM IPSUM, LOREM
                            IPSUM, LOREM IPSUM, LOREM IPSUM, LOREM IPSUM, LOREM IPSUM, LOREM IPSUM</div>
                    </div>
                @endfor

            </div>

        </section>

        <section class="list">

            <h1 class="list__title">Журнал покрытий, окозов, статуса будущих козлят на текущий год</h1>

            <table class="list__table">
                <thead>
                    <tr>
                        <th scope="col">номер п/п</th>
                        <th scope="col">Козел</th>
                        <th scope="col">Коза</th>
                        <th scope="col">Покрытие</th>
                        <th scope="col">Окоз</th>
                        <th scope="col">Статус козлят</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 6; $i++)
                        <tr>
                            <td>12</td>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, sequi?</td>
                            <td>Lorem ipsum dolor sit amet</td>
                            <td>Lorem ipsum </td>
                            <td>Lorem ipsum dolor sit amet</td>
                            <td>Lorem ipsum </td>
                        </tr>
                    @endfor
                </tbody>
            </table>

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
