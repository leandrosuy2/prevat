<?php

use Carbon\Carbon;


function formatDateAndTime($value, $format = 'd/m/Y - H:i')
{

    return Carbon::parse($value)->translatedFormat($format);
}

function formatDate($value, $format = 'd/m/Y')
{
    if($value) {
        $value=date_create($value);
        $date = date_format($value,"d/m/Y");
    } else {
        $date = '';
    }
    return $date;
}

function dateDiffInDays($date1, $date2)
{
    $diff = strtotime($date2) - strtotime($date1);
    return abs(round($diff / 86400));
}

function formatCertificate($value, $format = 'd F Y')
{
    Carbon::setLocale(app()->getLocale());

    $date = Carbon::parse($value);

//    dd($date->month()->format('F'));
    $day = Carbon::parse($value)->translatedFormat('d');
    $month = Carbon::parse($value)->translatedFormat('F');
    $year = Carbon::parse($value)->translatedFormat('Y');

    $dateFormated = $day. ' de '.$month. ' de '. $year;

    return $dateFormated;
}

function formatdiffForHumans($value, $format = 'd/m/Y')
{
    return Carbon::parse($value)->diffForHumans();
}

function formatDateDB ($value, $format = 'Y-m-d')
{
    return Carbon::parse($value)->format($format);
}


function formatMoney($value)
{
    return 'R$ '.number_format($value, 2, ',', '.');
}
function firstName($value)
{
    $name = explode(" ", $value);

    if(count($name) > 1){
        return $name[0] . " ". $name[1];
    } else {
        return $name[0];
    }
}

function formatMoneyInput($value)
{
    return number_format($value, 2, ',', '.');
}

function formatDecimal($value)
{
    return strtr($value, ['.' => '',  ',' => '.', ]);
}

function formatNumber($value)
{
    return round($value, 0);
}

function formatPercentage($value)
{
    return strtr($value, ['.' => ',']). ' %';
}

function formatCoin($value)
{
    $coin = explode('.', $value);
    return $coin[0];
}

function formatCPFCNPJ($value) {

    $value = preg_replace("/[^0-9]/", "", $value);
    $qtd = strlen($value);

    if($qtd >= 11) {

        if($qtd === 11 ) {
            $docFormatado = substr($value, 0, 3) . '.' .
                substr($value, 3, 3) . '.' .
                substr($value, 6, 3) . '-' .
                substr($value, 9, 2);
        } else {
            $docFormatado = substr($value, 0, 2) . '.' .
                substr($value, 2, 3) . '.' .
                substr($value, 5, 3) . '/' .
                substr($value, 8, 4) . '-' .
                substr($value, -2);
        }

        return $docFormatado;

    } else {
        return 'Documento invalido';
    }
}

function formatPhone($value) {

    $value = preg_replace('/[^0-9]/','',$value);

    if(strlen($value) > 10) {
        $countryCode = substr($value, 0, strlen($value)-10);
        $areaCode = substr($value, -10, 3);
        $nextThree = substr($value, -7, 3);
        $lastFour = substr($value, -4, 4);

        $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($value) == 10) {
        $areaCode = substr($value, 0, 2);
        $nextThree = substr($value, 2, 4);
        $lastFour = substr($value, 6, 4);

        $value = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($value) == 7) {
        $nextThree = substr($value, 0, 2);
        $lastFour = substr($value, 2, 4);

        $value = $nextThree.'-'.$lastFour;
    }

    return $value;

}

function formatZipCode($value) {

    $value = preg_replace('/[^0-9]/','',$value);

    $first = substr($value, 0, 5);
    $digits = substr($value, 5, 3);

    $value = $first.'-'.$digits;


    return $value;

}
