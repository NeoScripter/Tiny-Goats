<footer class="footer">

    <div class="footer__logo">
        <img src="{{ asset('images/partials/logo-footer.webp') }}" alt="logo">
    </div>

    <div class="footer__content">

        <div class="footer__icons">
            <a href="https://wa.me/+79521872133" target="_blank" class="footer__icon">
                {!! file_get_contents(public_path('images/svgs/whatsapp.svg')) !!}
            </a>
            <a href="https://t.me/reestrkoz" target="_blank" class="footer__icon">
                {!! file_get_contents(public_path('images/svgs/telegram.svg')) !!}
            </a>
            <a href="https://vk.com/club22792383" target="_blank" class="footer__icon">
                {!! file_get_contents(public_path('images/svgs/vk.svg')) !!}
            </a>
            <a href="mailto:reestrkoz@yandex.ru" target="_blank" class="footer__icon">
                {!! file_get_contents(public_path('images/svgs/email.svg')) !!}
            </a>
        </div>

        <p class="footer__copyright">Все права защищены © 2024</p>
    </div>

    <nav class="footer__nav">
        <ul class="footer__ul">
            <li><a href="/agenda" class="{{ Request::is('agenda') ? 'footer__link--active' : '' }}">О реестре</a></li>
            <li><a href="{{ route('user.news.index') }}" class="{{ Route::is('news') ? 'footer__link--active' : '' }}">Новости</a></li>
            <li><a href="/sell" class="{{ Request::is('sell') ? 'footer__link--active' : '' }}">На продажу</a></li>
            <li><a href="faq" class="{{ Request::is('faq') ? 'footer__link--active' : '' }}">Вопросы</a></li>
            <li><a href="/animals" class="{{ Request::is('animals') ? 'footer__link--active' : '' }}">Животные</a></li>
            <li><a href="/specialists" class="{{ Request::is('specialists') ? 'footer__link--active' : '' }}">Специалисты</a></li>
            <li><a href="/rules" class="{{ Request::is('rules') ? 'footer__link--active' : '' }}">Правила</a></li>
            <li><a href="/households" class="{{ Request::is('households') ? 'footer__link--active' : '' }}">Хозяйства</a></li>
            <li><a href="/partners" class="{{ Request::is('partners') ? 'footer__link--active' : '' }}">Партнеры</a></li>
        </ul>
    </nav>
</footer>
