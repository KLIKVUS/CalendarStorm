<ul class="dark:border-gray-700 dark:bg-gray-800 lg:dark:bg-gray-900 flex flex-col rounded-lg border border-gray-100 bg-gray-50 p-4 text-center font-medium lg:flex lg:flex-row lg:space-x-8 lg:border-0 lg:bg-white lg:p-0 lg:text-left">
    <li>
        <a class="lg:dark:text-blue-500 block rounded bg-blue-700 py-2 pl-3 pr-4 text-white transition-colors lg:bg-transparent lg:p-0 lg:text-blue-700"
            href="{{ route('home.index') }}"
            aria-current="page">{{ __('Home') }}</a>
    </li>
    <li>
        <a class="dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent lg:dark:hover:text-blue-500 block rounded py-2 pl-3 pr-4 text-gray-900 transition-colors hover:bg-gray-100 lg:p-0 lg:hover:bg-transparent lg:hover:text-blue-700"
            href="{{ route('calendar.index') }}">Календарь</a>
    </li>
    <li>
        <div class="mt-5 flex justify-center lg:mt-0">
            <x-header.theme-toggle />
        </div>
    </li>
</ul>
