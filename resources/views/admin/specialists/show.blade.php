<x-layouts.app>

    <x-admin.header />

    <div class="admin-animal-card">
        @isset($specialist)

            <section class="info">

                <div class="info__visual">

                    <div class="info__snapshot">
                        <img src="{{ $specialist->image ? asset('storage/' . $specialist->image) : asset('images/partials/placeholder.webp') }}"
                            alt="{{ $specialist->name }}">
                    </div>
                </div>

                <div class="info__data">
                    <x-admin.info-item :property="$specialist->name" label="Фамилия, имя специалиста" />

                    <x-admin.info-item :property="$specialist->speciality" label="Специальность, направления работы" />

                    <x-admin.info-item :property="$specialist->education" label="Информация об образовании" />

                    <x-admin.info-item :property="$specialist->experience" label="Информация о трудовом стаже" />

                    <x-admin.info-item :property="$specialist->extraInfo" label="Другая информация" />

                    <x-admin.info-item :property="$specialist->contacts" label="Контакты" />

                    <x-admin.info-item :property="$specialist->website" label="сайт и/или соцсети" />

                </div>

            </section>

            <a href="{{ route('specialist.edit', $specialist->id) }}" class="gens__button">Редактировать</a>


        @endisset

    </div>


    <x-partials.footer />

</x-layouts.app>
