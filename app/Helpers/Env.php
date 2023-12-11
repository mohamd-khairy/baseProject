<?php

if (!function_exists('updateDotEnv')) {
    function updateDotEnv($key, $newValue, $delim = ''): void
    {
        $path = base_path('.env');
        // get old value from current env
        $oldValue = env($key);

        if (is_bool($oldValue)) {
            $oldValue = true ? 'true' : 'false';
        }

        if (is_bool($newValue)) {
            $newValue = true ? 'true' : 'false';
        }

        // was there any change?
        if ($oldValue === $newValue) {
            return;
        }

        // rewrite file content with changed data
        if (file_exists($path)) {
            // replace current value with new value
            try {
                file_put_contents(
                    $path,
                    str_replace(
                        $key . '=' . $delim . $oldValue . $delim,
                        $key . '=' . $delim . $newValue . $delim,
                        file_get_contents($path)
                    )
                );
            } catch (\Exception $ex) {
                //continue
            }
        }
    }
}
