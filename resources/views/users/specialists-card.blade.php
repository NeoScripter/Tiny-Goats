<x-layouts.app>

    <x-partials.header />

    <div class="user-specialist-card">

        <section class="info">
            @isset($specialist)
                <div class="info__visual">

                    <div class="info__snapshot">
                        <img src="{{ $specialist->image_path ? asset('storage/' . $specialist->image_path) : asset('images/partials/placeholder.webp') }}" alt="Фото специалиста">
                    </div>

                </div>

                <div class="info__data">
                    <div class="info__item">
                        <div class="info__property">Фамилия, имя специалиста</div>
                        <div class="info__value">{{ $specialist->name }}</div>
                    </div>

                    <div class="info__item">
                        <div class="info__property">Специальность, направления работы</div>
                        <div class="info__value">{{ $specialist->speciality }}</div>
                    </div>

                    <div class="info__item">
                        <div class="info__property">Информация об образовании</div>
                        <div class="info__value">{{ $specialist->education }}</div>
                    </div>

                    <div class="info__item">
                        <div class="info__property">Информация о трудовом стаже</div>
                        <div class="info__value">{{ $specialist->experience }}</div>
                    </div>

                    <div class="info__item">
                        <div class="info__property">Другая информация</div>
                        <div class="info__value">{{ $specialist->extraInfo }}</div>
                    </div>

                    <div class="info__item">
                        <div class="info__property">Контакты</div>
                        <div class="info__value">{{ $specialist->contacts }}</div>
                    </div>

                    <div class="info__item">
                        <div class="info__property">Cайт и/или соцсети</div>
                        <div class="info__value">{{ $specialist->website }}</div>
                    </div>
                </div>
            @endisset
        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
