# php-tckn-validation
<div align="center"> <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" height="100"> </div>
<br>
<p> <img src="https://upload.wikimedia.org/wikipedia/en/a/a4/Flag_of_the_United_States.svg" width="22"> This function validates Turkish Identity Numbers through 'tckimlik.nvi.gov.tr' address. </p>
<p> <img src="https://upload.wikimedia.org/wikipedia/commons/b/b4/Flag_of_Turkey.svg" width="22"> Bu fonksiyon 'tckimlik.nvi.gov.tr' üzerinden anlık olarak TCKN sorgulaması ve doğrulaması yapılmasını sağlar.</p>

------------

```php
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
        'Ad'          => mb_strtoupper(tckn_name_replace($name)),
        'Soyad'       => mb_strtoupper(tckn_name_replace($lastname)),
        'DogumYili'   => $birth_year # must be an only birth year (such as 1990, 2000)
    ]);
    $result = ($response->TCKimlikNoDogrulaResult ? true : false);

} catch (Exception $e) {
    $result = $e->faultstring;
}
  
  return $result;
  
}

# SAMPLE USAGE
print_r(tckn_validation(12345678900, 'BARIŞ', 'TAŞKIRAN', 1990));

```
