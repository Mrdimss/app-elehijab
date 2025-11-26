<?php

// app/Helpers/CleanNumber.php

if (! function_exists('cleanNumber')) {
    /**
     * Membersihkan format angka.
     *
     * @param  int|float  $number
     * @return string
     */
    function cleanNumber($value)
    {
        return floatval(str_replace(',', '', $value));
    }
}
