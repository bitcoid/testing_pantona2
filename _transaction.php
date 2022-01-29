<?php
// Connect to db
include_once('db.php');
include_once('_func.php');
 
$db = new db;
$conn =  $db->connect();


// Membuat fungsi recursive
function recursive($sekolah, $array ,  $conn){   
    if($sekolah <= $array[0] ){
      //insert table sekolah 
      $sekolahName = 'sekolah_'.($sekolah+1);
      $sqlSekolah = "INSERT INTO tbl_sekolah (sekolahNama) VALUES ('".$sekolahName."')"; 
      if ($conn->query($sqlSekolah) === TRUE) { 
          // insert kelas, sekolah Parents  
          $last_id = $conn->insert_id;
          for($i=1; $i<=$array[1]; $i++){ 
            $result_last_id = insertKelas( $last_id , 'kelas_'.$i , $conn);
            if($result_last_id != false){
              for($j=1;$j<=$array[2]; $j++){
                $siswaNama = 'Siswa'. $j;
                insertSiswa($result_last_id, $siswaNama ,  $sekolahName, $conn);
              }
            }
          } 
      }else{
        echo "Error: " . $sqlSekolah . "<br>" . $conn->error;
      }  
      recursive($sekolah+1, $array, $conn);
      
      $skl = handleResult('sekolahID','tbl_sekolah', $conn);
      $kls = handleResult('kelasID','tbl_kelas', $conn);
      $sis = handleResult('siswaID','tbl_siswa', $conn); 
      return $skl+$kls+$sis;
  }
}
 


//Handle insert kelas
function insertKelas($last_id, $name, $conn){
  $KelasName = $name;
  $sqlKelas = "INSERT INTO tbl_kelas (kelasNama, sekolahID) VALUES ('".$KelasName."', '".$last_id."')";
  if ($conn->query($sqlKelas) === TRUE) {
    $last_id = $conn->insert_id;
    return $last_id;
  }else{
    return false;
  }  
}

//Handle insert Siswa
function insertSiswa($last_id, $name, $sekolahName, $conn){   
  $n = setRandomNumber();
  $sqlSiswa = "INSERT INTO tbl_siswa (siswaNama, kelasID, nilai, grade) 
               VALUES (
                '".$name.$sekolahName."', 
                '".$last_id."', 
                '".$n."', 
                '".setGrade( $n )."'
               )
              ";
  if ($conn->query($sqlSiswa) === TRUE) { }else{ echo "Error: " . $sqlSiswa . "<br>" . $conn->error;  }  
} 

//handle result
function handleResult($ID, $tables , $conn){
  //Mendapatkan JumlahTotal progress data
  $t = 'select count('.$ID.') as jml from '.$tables.'';  
  if ( $result = $conn->query($t)) {
      
      if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) { 
              return $row["jml"];
          }
      } else {
          return 0;
      }
  }
}

$jml_sc = 3;
$jml_kls = 5;
$jml_siswa = 20;
$total_currently = recursive(1, array( $jml_sc, $jml_kls, $jml_siswa ), $conn);
echo json_encode(array( 
  'total_currently' =>  $total_currently
)); 
 
?>