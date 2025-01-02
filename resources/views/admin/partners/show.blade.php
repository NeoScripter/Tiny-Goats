<x-layouts.app>

    <x-admin.header />

    <div class="admin-animal-card">
        @isset($partner)

            <section class="info">

                <div class="info__visual">

                    <div class="info__snapshot">
                        <img src="{{ $partner->image ? asset('storage/' . $partner->image) : asset('images/partials/placeholder.webp') }}"
                            alt="{{ $partner->name }}">
                    </div>
                </div>

                <div class="info__data">
                    <x-admin.info-item :property="$partner->name" label="Название" />

                    <x-admin.info-item :property="$partner->info" label="Информация о партнере, услугах, акциях, скидке" />

                    <x-admin.info-item :property="$partner->conditions" label="Условия получения" />

                    <x-admin.info-item :property="$partner->website" label="Сайт" />

                    <x-admin.info-item :property="$partner->contacts" label="Контакты" />

                    <x-admin.info-item :property="$partner->updateAt" label="Дата последнего изменения" />

                </div>

            </section>

            <a href="{{ route('partner.edit', $partner->id) }}" class="gens__button">Редактировать</a>


        @endisset

    </div>


    <x-partials.footer />

</x-layouts.app>
