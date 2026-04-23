<?php

if (! function_exists('active_link')) {
    function active_link(string|array $names, ?string $classWhenActive = null, ?string $classWhenNotActive = null): ?string
    {
        if (is_string($names)) {
            $names = [$names];
        }

        return Route::is($names) ? $classWhenActive : $classWhenNotActive;
    }
}
