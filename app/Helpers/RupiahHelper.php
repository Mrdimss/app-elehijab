<?php

// app/Helpers/RupiahHelper.php

if (! function_exists('formatRupiah')) {
    /**
     * Mengubah angka menjadi format Rupiah.
     *
     * @param  int|float  $number
     * @return string
     */
    function formatRupiah($number)
    {
        $numericValue = (float) $number;

        return 'Rp '.number_format($numericValue, 00, ',', '.');
    }
}
