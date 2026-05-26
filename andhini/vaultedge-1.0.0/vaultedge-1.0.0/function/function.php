<?php 
    $conn = mysqli_connect("localhost","root","","beta_smartlab");

    function query($queri){
        global $conn;
        $result = mysqli_query($conn, $queri);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function select1($query){
        global $conn;
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)){
            return mysqli_fetch_assoc($result);
        }
    }

    function tambah($data,$files){
        global $conn;
        $namaLengkap = htmlspecialchars($data['fullname']);
        $username = explode(" ",$namaLengkap);
        $username = $username[0];
        $email = htmlspecialchars($data['email']);
        $noWa = htmlspecialchars($data['nowa']);
        $kelas = htmlspecialchars($data['kelas']);
        $jurusan = htmlspecialchars($data['jurusan']);
        $idCard = htmlspecialchars($data['card']);
        $role = htmlspecialchars($data['role']);
        $tingkatan = htmlspecialchars($data['tingkatan']);
        $password = htmlspecialchars($data['password']);
        $password = password_hash($password,PASSWORD_DEFAULT);
        $file = $files;
        $gambar = upload($file);
        if(!$gambar){
            return false;
        }
        $queri = "INSERT INTO user VALUES ('','$namaLengkap','$username','$email','$noWa','$kelas','$jurusan','$idCard','$role','$tingkatan','$password','$gambar')";
        mysqli_query($conn,$queri);
        return true;

    }
    function delete($id){
        global $conn;
        $queri = "DELETE FROM mahasiswa  WHERE id=$id";
        mysqli_query($conn,$queri);
    }
    function update($data,$file){
        global $conn;
        $id = $data['id'];
        $name = htmlspecialchars($data['name']);
        $nis = htmlspecialchars($data['nis']);
        $jurusan = htmlspecialchars($data['jurusan']);
        $gmail = htmlspecialchars($data['gmail']);
        if($file['error'] !== 4){
            $newName = upload($file);
            $gambar = $newName;
        }else{
            $gambar = $data['gambar'];
        }
        
        $queri = "UPDATE mahasiswa SET 
        nama='$name',
        nis='$nis',
        jurusan='$jurusan',
        gmail='$gmail',
        gambar='$gambar'
        WHERE id=$id ";
        mysqli_query($conn,$queri);
    }
    function teang($key){
        $queri = "SELECT * FROM mahasiswa WHERE nama LIKE '%$key%'
        OR nis LIKE '%$key%'
        OR jurusan LIKE '%$key%'
        OR gmail LIKE '%$key%'
        OR gambar LIKE '%$key%'
        ";
        return query($queri);
    }
    function upload($file){
        $namaGambar = $file['name'];
        $from = $file['tmp_name'];
        $error = $file['error'];
        $size = $file['size'];

        if($error == 4){
            return "nouser.jpg";
        }
        $fileValid = ["jpg","png","jpeg"];
        $ekstensi = explode(".",$namaGambar);
        $ekstensi = strtolower(end($ekstensi));
        if(!in_array($ekstensi,$fileValid)){
            echo"
                <script>
                    alert('yang anda input bukan gambar!!!');
                </script>
            ";
            return false;
        }
        if($size > 1000000){
            echo"
                <script>
                    alert('ukuran data terlalu besar');
                </script>
            ";
            return false;
        }
        $namaBaru = uniqid();
        $namaBaru .= ".";
        $namaBaru .= $ekstensi;
        move_uploaded_file($from,'../assets/img/user/' . $namaBaru);
        return $namaBaru;
    }
?>