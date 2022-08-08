<ul class="{{ config('language.flags.ul_class') }}">
    @foreach (language()->allowed() as $code => $name)
        <li class="{{ config('language.flags.li_class') }}">
            <a href="{{ language()->back($code) }}">
                <img src="{{ asset('img/vendor/language/flags/'. language()->country($code) .'.png') }}" alt="{{ $name }}" width="{{ config('language.flags.width') }}" /> &nbsp; {{ $name }}
            </a>
        </li>
    @endforeach
</ul>