<?php

// app/Helpers/Rupiah.php

if (! function_exists('rupiah')) {
    /**
     * Mengubah angka menjadi format Rupiah.
     *
     * @param  int|float  $number
     * @return string
     */
    function rupiah($number)
    {
        $numericValue = (float) $number;

        return ''.number_format($numericValue, 00, '.', ',');
    }
}
