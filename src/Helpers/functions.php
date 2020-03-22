<?php


function split_name($name) {
    $name = trim($name);
    $lastName = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $firstName = trim( preg_replace('#'.$lastName.'#', '', $name ) );
    return array($firstName, $lastName);
}

function full_name($nomeCompleto) {
    $nomes = explode(' ', trim($nomeCompleto));
    if(count($nomes) === 1) {
        return $nomes[0];
    }
    return trim($nomes[0]). ' ' .trim($nomes[count($nomes) - 1]);
}

function first_name($nomeCompleto) {
    $nomes = explode(' ', trim($nomeCompleto));
    if(count($nomes)) {
        return $nomes[0];
    }
}

function dtocents(float $decimal) {
    $decimal = round($decimal, 2);
    if($decimal * 100 % 1 === 0) {
        return (int) ($decimal * 100);
    }
    return $decimal;
}

function ctodecimal(int $cents) {
    if($cents / 100 % 1 === 0) {
        return (float) ($cents / 100);
    }
    return $cents;
}

function dtopennies($value) {
    $value = intval(round($value, 2));
    $value = preg_replace("/[^0-9]/", "", (string) $value);
    return intval(strval($value));
}

function getMoneyAsCents($value)
{
    // strip out commas
    $value = preg_replace("/\,/i","",$value);
    // strip out all but numbers, dash, and dot
    $value = preg_replace("/([^0-9\.\-])/i","",$value);
    // make sure we are dealing with a proper number now, no +.4393 or 3...304 or 76.5895,94
    if (!is_numeric($value))
    {
        return 0.00;
    }
    // convert to a float explicitly
    $value = (float)$value;
    return round($value,2)*100;
}

/**
 * @return string
 */
function local_phonenumber($phone) {
    if($phone === false && is_null($phone) && trim($phone) === '') {
        return null;
    }
    //parse as string
    $phone = trim($phone);
    
    //only numbers
    $phone = preg_replace('/[^0-9.]/', '', $phone);

    //digits count
    $count = strlen($phone);

    //nove digitos
    $ninedig = in_array($count, [9, 11, 13]);

    if($ninedig) {
        return substr($phone, -11);
    }

    return substr($phone, -10);
}

/**
 * @return string
 */
function global_phonenumber($phone, $conver9Dig = true, $defaultCountryCode = "55", $defaultRegionCode = "21") {
    if($phone === false && is_null($phone) && trim($phone) === '') {
        return null;
    }
    //parse as string
    $phone = trim($phone);
    
    //only numbers
    $phone = preg_replace('/[^0-9.]/', '', $phone);
    
    //digits count
    $count = strlen($phone);

    //nove digitos
    $ninedig = in_array($count, [9, 11, 13]);

    //serviço de utilidade publica
    $isSUP = in_array($count, range(3, 5)) && in_array(substr(substr($phone, -5), -5, 1), ['1', '2']);

    //extensao de serviço de utilidade publica
    $isSUPExt = $count <= 5 && in_array(substr(substr($phone, -5), -3, 1), ['3', '5', '6']);

    //serviço de telefonia fixa comutada
    $isSTFC = !$isSUP && in_array(substr(substr($phone, -8), -8, 1), ['2', '3', '4', '5']);
    
    //serviço de telefonia movel especial via radio (nextel)
    $isSME = !$ninedig && !$isSUP && in_array(substr(substr($phone, -8), -8, 2), ['70', '77', '78', '79']);    

    //serviço de telefonia movel (operadoras comuns)
    $isSMC = !$isSTFC && !$isSME;

    $phonePad = str_pad($phone, 12, '0', STR_PAD_LEFT);

    //se for numero SMC sem numero 9, converte
    if($isSMC && substr($phone, -9, 1) !== '9') {
        $phonePad = substr($phonePad, -12, 4)."9".substr($phone, -8);
    }else if($isSMC) {
        $phonePad = str_pad($phonePad, 13, '0', STR_PAD_LEFT);
    }

    //obtem a parte inicial do numero do destinatario por radio ou celular
    if($isSMC) {
        $middlePart = substr($phonePad, -9, 5);
    }else {
        $middlePart = substr($phonePad, -8, 4);
    }

    //obtem a ultima parte do telefone
    $lastPart = substr($phone, -4);

    //obtem o codigo do pais, ou atribui o valor padrão se for 00
    $countryCode = substr($phonePad, 0, 2) !== '00' ? substr($phonePad, 0, 2) : $defaultCountryCode;
    
    //obtem o codigo da região, ou atribui o valor padrão se for 00
    $regionCode = substr($phonePad, 2, 2) !== '00' ? substr($phonePad, 2, 2) : $defaultRegionCode;

    //retorna o telefone no padrão internacional
    return "{$countryCode}{$regionCode}{$middlePart}{$lastPart}";

}

/**
 * @return string
 */
function color_luminance($hexcolor, $percent)
{
  if ( strlen( $hexcolor ) < 6 ) {
    $hexcolor = $hexcolor[0] . $hexcolor[0] . $hexcolor[1] . $hexcolor[1] . $hexcolor[2] . $hexcolor[2];
  }
  $hexcolor = array_map('hexdec', str_split( str_pad( str_replace('#', '', $hexcolor), 6, '0' ), 2 ) );

  foreach ($hexcolor as $i => $color) {
    $from = $percent < 0 ? 0 : $color;
    $to = $percent < 0 ? $color : 255;
    $pvalue = ceil( ($to - $from) * $percent );
    $hexcolor[$i] = str_pad( dechex($color + $pvalue), 2, '0', STR_PAD_LEFT);
  }

  return '#' . implode($hexcolor);
}