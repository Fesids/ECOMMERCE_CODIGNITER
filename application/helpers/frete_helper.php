<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('calcular_frete')) {
    function calcular_frete($subtotal) {
        if ($subtotal >= 52 && $subtotal <= 166.59) {
            return 15.00;
        } elseif ($subtotal > 200) {
            return 0;
        } else {
            return 20.00;
        }
    }
}