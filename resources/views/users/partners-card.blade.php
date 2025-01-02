<x-layouts.app>

    <x-partials.header />

    <div class="user-partners-card">

        <section class="info">
            @isset($partner)

            <div class="info__visual">

                <div class="info__snapshot">
                    <img src="{{ $partner->image ? asset('storage/' . $partner->image) : asset('images/partials/placeholder.webp') }}" alt="Фото специалиста">
                </div>

            </div>

            <div class="info__data">
                <div class="info__item">
                    <div class="info__property">Название</div>
                    <div class="info__value">{{ $partner->name }}</div>
                </div>

                <div class="info__item">
                    <div class="info__property">Информация о партнере, услугах, акциях, скидке</div>
                    <div class="info__value">{{ $partner->info }}</div>
                </div>

                <div class="info__item">
                    <div class="info__property">Условия получения</div>
                    <div class="info__value">{{ $partner->conditions }}</div>
                </div>

                <div class="info__item">
                    <div class="info__property">Сайт</div>
                    <div class="info__value">{{ $partner->website }}</div>
                </div>

                <div class="info__item">
                    <div class="info__property">Контакты</div>
                    <div class="info__value">{{ $partner->contacts }}</div>
                </div>
            </div>
            @endisset

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
