<?php
echo "<a href=hello.php style=color:cadetblue ; >Home</a>";
echo "<h1>Biodata Saya</h1>";
$namaLengkap = 'Andhini Putri Wijaya';
$jenisK = 'Perempuan';
$umur = '16';
$berat = '44';
$tinggi = '149';
$kelas = 'XI TJKT 3';
$TTL = 'Bandung, 16 Februari 2009';

 echo "<img src=andhini-cantik.jpg width=200 height=150 style=border-radius: 50%;/> <br>";
 echo "<br>Nama  : $namaLengkap<br>";
 echo "Kelas : $kelas<br>";
 echo "TTL   : $TTL<br>";
 echo "Jenis Kelamin  : $jenisK<br>";
 echo "Umur : $umur<br>";
 echo "Berat Badan : $berat kg <br>";
 echo "Tinggi : $tinggi cm<br>";
 

$a = '5';
$b = '2';
$c = $a + $b;
// penjumlahan

echo "$a + $b = $c";
echo "<hr>";
?>
