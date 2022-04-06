<?php
# Written by @therbta @ Wed Apr 6, 2022 - 2.50pm in United States

function tckn_name_replace($text)
{
	$text = trim($text);
	$search = array('ç', 'ğ', 'i', 'ı', 'ş', 'ö', 'ü');
	$replace = array('Ç', 'Ğ', 'İ', 'I', 'Ş', 'Ö', 'Ü');
	$new_text = str_replace($search, $replace, $text);
	$new_text = strtoupper($new_text);
	return $new_text;
}

function tckn_validation(int $tckn, string $name, string $lastname, int $birth_year){
  $connection = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");
  
  try {
    $response = $connection->TCKimlikNoDogrula([
        'TCKimlikNo'  => $tckn,
        'Ad'          => mb_strtoupper(tckn_name_replace($_name)),
        'Soyad'       => mb_strtoupper(tckn_name_replace($_lastname)),
        'DogumYili'   => $birth_year # must be an only birth year (such as 1990, 2000)
    ]);
    $result = ($response->TCKimlikNoDogrulaResult ? true : false);

} catch (Exception $e) {
    $result = $e->faultstring;
}
  
  return $result;
  
}




