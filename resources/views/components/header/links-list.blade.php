<ul class="dark:border-gray-700 dark:bg-gray-800 flex flex-col rounded-lg border border-gray-300 bg-gray-50 p-4 text-center font-medium lg:flex lg:flex-row lg:space-x-8 lg:border-0 lg:!bg-transparent lg:p-1 lg:text-left">
    <li>
        <a class="{{ active_link('home.index', 'lg:dark:text-blue-500 bg-blue-700 text-white lg:bg-transparent lg:text-blue-700', 'dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent lg:dark:hover:text-blue-500 text-gray-900 hover:bg-gray-100 lg:hover:bg-transparent lg:hover:text-blue-700') }} block rounded py-2 pl-3 pr-4 transition-colors lg:p-0"
            href="{{ route('home.index') }}">{{ __('Home') }}</a>
    </li>
    <li>
        <a class="{{ active_link('calendar.index', 'lg:dark:text-blue-500 bg-blue-700 text-white lg:bg-transparent lg:text-blue-700', 'dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent lg:dark:hover:text-blue-500 text-gray-900 hover:bg-gray-100 lg:hover:bg-transparent lg:hover:text-blue-700') }} block rounded py-2 pl-3 pr-4 transition-colors lg:p-0"
            href="{{ route('calendar.index') }}">Календарь</a>
    </li>
    <li>
        <div class="mt-5 flex justify-center lg:mt-0">
            <x-header.theme-toggle />
        </div>
    </li>
</ul>
