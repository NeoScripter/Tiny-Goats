<x-layouts.app>

    <x-partials.header />

    <div class="login-page">

        <section class="login">

            <h1 class="login__heading">Вход</h1>

            <h2 class="login__subtitle">только для администраторов сайта</h2>

            <form method="POST" action="{{ route('login') }}" class="login__form">
                @csrf

                <div class="login__field">
                    <input type="text" name="name" value="{{ old('name') }}" aria-label="name"
                        placeholder="Логин" required autofocus />
                </div>

                <div class="login__field">
                    <input type="password" name="password" aria-label="Password" placeholder="Пароль"
                        required />
                    @error('name')
                        <span class="login__error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="login__submit">Войти</button>
            </form>

        </section>

    </div>


    <x-partials.footer />

</x-layouts.app>
