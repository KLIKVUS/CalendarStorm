@auth('sanctum')
<x-header.account-dropdown />
@else
<x-header.link routeForLink="auth.*" route="auth.index">
    <x-tabler-user-f class="size-5"/>
    {{ __('Войти') }}
</x-header.link>
@endauth
