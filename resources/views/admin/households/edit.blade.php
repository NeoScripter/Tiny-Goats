<x-layouts.app>

    <x-admin.header />

    <div class="admin-animal-show admin-household-show">


        @isset($household)
            <form method="POST" action="{{ route('household.update', $household->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="info">

                    <div class="info__visual">

                        <div class="info__snapshot">
                            <label for="image">
                                <img id="imagePreview"
                                    src="{{ $household->image ? asset('storage/' . $household->image) : asset('images/partials/placeholder.webp') }}"
                                    alt="Main Image" class="main-image">
                            </label>
                            <input type="file" name="image" id="image" accept="image/*" class="news__file-input"
                                onchange="previewImage(event)">
                        </div>
                        @error('image')
                            <span class="edit-news__error info__error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="info__data">

                        <x-form-input label="название хозяйства" name="name"
                            value="{{ old('name', $household->name) }}" />

                        <x-form-input label="Адрес" name="address" value="{{ old('address', $household->address) }}" />

                        <x-form-input label="Владелец" name="owner" value="{{ old('owner', $household->owner) }}" />

                        <x-form-textarea label="Доп. сведения о владельце" name="extraInfo"
                            value="{{ old('extraInfo', $household->extraInfo) }}" rows="3" />

                        <x-form-textarea label="Породы, породовые направления" name="breeds"
                            value="{{ old('breeds', $household->breeds) }}" rows="3" />

                        <x-form-input label="Страна" name="country" value="{{ old('country', $household->country) }}" />

                        <x-form-input label="Область" name="region" value="{{ old('region', $household->region) }}" />

                        <x-form-input label="Контакты" name="contacts"
                            value="{{ old('contacts', $household->contacts) }}" />

                        <x-form-input label="сайт и/или соцсети" name="website"
                            value="{{ old('website', $household->website) }}" />


                        <!-- Show on Main -->
                        <div class="info__item">
                            <div class="info__property">Показывать на главной</div>
                            <div class="info__value info__value--checkbox">
                                <input type="checkbox" name="showOnMain" value="1"
                                    {{ old('showOnMain', $household->showOnMain) ? 'checked' : '' }}>
                            </div>
                        </div>

                        @error('showOnMain')
                            <div class="info__error info__error--shifted">{{ $message }}</div>
                        @enderror


                    </div>
                </div>
                <div class="edit-animals__btns">
                    <button type="submit" class="edit-animals__publish-btn">Опубликовать</button>
                    <!-- Delete Button -->
                    <button type="submit" form="delete-household-form" class="edit-animals__delete-btn">Удалить</button>
                </div>
            </form>

        </div>
        <form id="delete-household-form" method="POST" action="{{ route('household.destroy', $household->id) }}">
            @csrf
            @method('DELETE')
        </form>

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
                            <!-- Delete Form -->
                            <form class="block ml-auto" action="{{ route('log_entry.destroy', $logEntry->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    &times;
                                </button>
                            </form>
                        </tr>
                    @endforeach
                    <form id="add-entry-form" action="{{ route('log_entry.store', $logEntry->id) }}" method="POST">
                        @csrf
                        <tr>
                            <td>{{ $logEntry->number }}</td>
                            <td>
                                <div class="info__item">
                                    <div class="info__property">Козел</div>
                                    <div class="info__value">
                                        <select name="father_id" class="info__select">
                                            <option value="">-- Выбрать козла --</option>
                                            @foreach ($maleAnimals as $male)
                                                <option value="{{ $male->id }}"
                                                    {{ old('male_id') == $male->id ? 'selected' : '' }}>
                                                    {{ $male->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @error('male_id')
                                    <div class="info__error info__error--shifted">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <div class="info__item">
                                    <div class="info__property">Коза</div>
                                    <div class="info__value">
                                        <select name="father_id" class="info__select">
                                            <option value="">-- Выбрать козу --</option>
                                            @foreach ($femaleAnimals as $female)
                                                <option value="{{ $female->id }}"
                                                    {{ old('female_id') == $female->id ? 'selected' : '' }}>
                                                    {{ $female->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @error('female_id')
                                    <div class="info__error info__error--shifted">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <x-form-input label="" name="coverage" value="{{ old('coverage') }}" />
                            </td>
                            <td><x-form-input label="" name="lambing" value="{{ old('lambing') }}" /></td>
                            <td><x-form-input label="" name="status" value="{{ old('status') }}" /></td>
                            <button type="submit">
                                Добавить запись
                            </button>
                        </tr>
                    </form>
                </tbody>
            </table>
        </section>
    @endisset


    <x-partials.footer />

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('imagePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>


</x-layouts.app>
