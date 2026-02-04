<?php
echo "<a href='hello.php' style=color:cadetblue ; >Home</a> | ";

echo "<h1>Biodata Saya</h1>";
$namaLengkap = 'Andhini Putri Wijaya';
$jenisK = 'Perempuan';
$umur = '16';
$berat = '44';
$tinggi = '149';
$kelas = 'XI TJKT 3';
$TTL = 'Bandung, 16 Februari 2009';

 echo "<img src=andin-grey.jpg width=200 height=201 style=border-radius: 50%;/> <br>";
 echo "<br>Nama  : $namaLengkap<br>";
 echo "Kelas : $kelas<br>";
 echo "TTL   : $TTL<br>";
 echo "Jenis Kelamin  : $jenisK<br>";
 echo "Umur : $umur<br>";
 echo "Berat Badan : $berat kg <br>";
 echo "Tinggi : $tinggi cm<br>";

 echo "<h1>Belajar if</h1>";
 echo "Jika kamu belanja lebih dari 100rb maka anda akan dapat hadiah<br>";
 $total_belanja = 10000;
if($total_belanja > 100000){
    echo "Anda belanja 150rb<br>";
    echo "Anda dapat hadiah!<br>";
    } else {
    echo "Anda belanja kurang dari 100rb<br>";
    echo "Belanja Lebih banyak yups!<br>";
}

echo "<h1>Belajar elseif</h1>";

$nilai = 99;
if ($nilai > 100) {
    echo "<br>Anda salah masukkan nilai<br>";
} else { if ($nilai > 90) {
        $grade = "A+";
    } elseif($nilai > 80){
        $grade = "A";
    } elseif($nilai > 70){
        $grade = "B+";
    } elseif($nilai > 60){
        $grade = "B";
    } elseif($nilai > 50){
        $grade = "C+";
    } elseif($nilai > 40){
        $grade = "C";
    } elseif($nilai > 30){
        $grade = "D";
    } elseif($nilai > 20){
        $grade = "E";
    } else {
        $grade = "F";
    }
    echo "Grade: $grade <br>";
    } 
    echo "Nilai anda: $nilai<br>";

echo "<hr>";
$suka = true;

// menggunakan operator ternary
$jawab = $suka ? "yups": "no";

// menampilkan jawaban
echo "kamu suka kucing? $jawab<br>";
$a = 5;
$b = 2;
$c = $a + $b;
// penjumlahan
echo "$a + $b = $c<br>";

echo "Coba 83*10+1-800=";
$speed = 83;
$speed *= 10;
$speed += 1;
$speed -= 800;
echo "$speed<br> <hr><br>";

?>