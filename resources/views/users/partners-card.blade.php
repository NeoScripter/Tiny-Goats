<x-layouts.app>

    <x-partials.header />

    <div class="user-partners-card">

        <section class="info">

            <div class="info__visual">

                <div class="info__snapshot">
                    <img src="{{ asset('images/pages/user/animal/placeholder.png') }}" alt="">
                </div>

            </div>

            <div class="info__data">
                @for ($i = 0; $i < 5; $i++)
                    <div class="info__item">
                        <div class="info__property">Название</div>
                        <div class="info__value">LOREM IPSUM, LOREM IPSUM, LOREM IPSUM, LOREM IPSUM, LOREM IPSUM</div>
                    </div>
                @endfor

            </div>

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
