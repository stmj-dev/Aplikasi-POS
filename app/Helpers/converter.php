<?php

function format_uang($angka){
    return 'Rp. ' . number_format($angka);
}