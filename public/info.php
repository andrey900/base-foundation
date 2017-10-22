<?php

include '../vendor/autoload.php';

use Illuminate\Support\Str;

// echo hash('md4', rand(10000, 99999));
// print_r(openssl_get_cipher_methods());

// echo password_hash("admin", PASSWORD_BCRYPT).'<br>';
echo "<pre><br>";

$appKey = 'Bo-s5I,d4';
$login = 'admin';
$password = '$2y$10$PIO0cZO6CMFFOwKGnbxH7euhn48RY/gU4vdCYZsNWl4kiUmI50AQ2';

$d = [
	'u' => $login,
	'p' => $password,
	'e' => time()+3600*24*7
];

// $strongHash = openssl_encrypt(json_encode($d), 'AES-128-ECB', $appKey);
// $solt = md5($strongHash);

/*$strongHash = '3imDXosFl+cp7oeC+wQphOvpoZ/M2Fwb3JzbqVcBsNCol99D+J1rrdsf3N9ONrTpTps9uUSjADQ9jAk2tqvwxXjf0JyBsO3OnelbQNNDjIlthRKmV5vRyR/HERM9ZOzdM0VPN/QKtqZHx9X1FpXonQ==';
$solt = '516a740c598ba04c76ee5e5928327496';

print_r([
'hash' => $strongHash,
'solt' => $solt,
	]);

$solt1 = base64_encode($solt);
echo "$solt1";
echo "\n\n\n";

$len = strlen($solt1);
$nStrongHash = '';
$arHash = str_split($strongHash, 2);
foreach ($arHash as $key => $val) {
	$nStrongHash .= $solt1[$key].$val;
}

print_r(substr($solt, 0, 16).$nStrongHash.substr($solt, 16));*/

$codeline = '99b66783024508d9Ok8TQ/lyri9rNb6j6nY0r3dEOfbDj5MA6wXuM2MjGyQMQ1o+M0oDU0h8gk1hOBnWnVQjN0AHMcxmGZEbO5yUMBZjziRGjjoNM2KWUKRJ2kFcMYEjg3IDuy6tYqmzQqMbT=hicmIUeR++13haNU9P+ZfnJQuSV1HgCRqFJ6QXvrpVReUJn8LlLtx2SJPMCL5f4Q==d42a924c1dd222c3';

echo PHP_EOL;

$solt2 = substr($codeline, 0, 16).substr($codeline, -16);
print_r($solt2);
echo PHP_EOL;
$codePhrase = substr($codeline, 16, -16);
print_r($codePhrase);
echo PHP_EOL;

$solt3 = base64_encode($solt2);
$len = strlen($solt3);

$arHash = str_split($codePhrase, 3);
$nStrongHash = '';
foreach ($arHash as $key => $val) {
	if( isset($solt3[$key]) )
		$nStrongHash .= substr($val, 1, 3);
	else
		$nStrongHash .= $val;
}
print_r($solt3);
echo PHP_EOL;
print_r($nStrongHash);
echo PHP_EOL;
$jsonString = openssl_decrypt($nStrongHash, 'AES-128-ECB', $appKey);
print_r($jsonString);

/*

Array
(
    [hash] => 3imDXosFl+cp7oeC+wQphOvpoZ/M2Fwb3JzbqVcBsNCol99D+J1rrdsf3N9ONrTpTps9uUSjADQ9jAk2tqvwxXjf0JyBsO3OnelbQNNDjIlthRKmV5vRyR/HERM9ZOzdM0VPN/QKtqZHx9X1FpXonQ==
    [solt] => 516a740c598ba04c76ee5e5928327496
)

*/
