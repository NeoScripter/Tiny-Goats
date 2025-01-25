<x-layouts.app>

    <x-partials.header />

    <div class="user-household-card">
        @isset($household)
            <section class="info">

                <div class="info__visual">

                    <div class="info__snapshot">
                        <img src="{{ $household->image ? asset('storage/' . $household->image) : asset('images/partials/placeholder.webp') }}"
                            alt="{{ $household->name }}">
                    </div>

                </div>

                <div class="info__data">
                    <x-admin.info-item :property="$household->name" label="название хозяйства" />

                    <x-admin.info-item :property="$household->address" label="Адрес" />

                    <x-admin.info-item :property="$household->owner" label="Владелец" />

                    <x-admin.info-item :property="$household->extraInfo" label="Доп. сведения о владельце" />

                    <x-admin.info-item :property="$household->breeds" label="Породы, породные направления" />

                    @isset($all_animals)
                        <x-admin.info-item :property="$all_animals" label="Животные" />
                    @endisset

                    @isset($animals_for_sale)
                        <x-admin.info-item :property="$animals_for_sale" label="Животные на продажу" />
                    @endisset

                    <x-admin.info-item :property="$household->country" label="Страна" />

                    <x-admin.info-item :property="$household->region" label="Область" />

                    <x-admin.info-item :property="$household->contacts" label="Контакты" />

                    <x-admin.info-item :property="$household->website" :isLink="true" label="сайт и/или соцсети" />

                </div>

            </section>

            <section class="list">

                <h1 class="list__title">Журнал покрытий, окотов, статуса будущих козлят на текущий год</h1>

                <table class="list__table">
                    <thead>
                        <tr>
                            <th scope="col">номер п/п</th>
                            <th scope="col">Козел</th>
                            <th scope="col">Коза</th>
                            <th scope="col">Покрытие</th>
                            <th scope="col">Окот</th>
                            <th scope="col">Статус козлят</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($household->logEntries as $logEntry)
                            <tr>
                                <td>{{ $logEntry->number }}</td>
                                <td>{{ $logEntry->male->name }}</td>
                                <td>{{ $logEntry->female->name }}</td>
                                <td>{{ $logEntry->coverage }} </td>
                                <td>{{ $logEntry->lambing }}</td>
                                <td>{{ $logEntry->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </section>

        </div>
    @endisset

    <x-partials.footer />

</x-layouts.app>
