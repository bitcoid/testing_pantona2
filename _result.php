<?php
// Connect to db
include_once('db.php');
include_once('_func.php');
 
$db = new db;
$conn =  $db->connect();
$kelas ='select kelasID from tbl_kelas';

if ( $result = $conn->query($kelas)) {
    echo '<table width="50%" border="1">
        <tr>
            <td> Nama </td>
            <td> Nilai </td>
            <td> RankKelas  </td>
            <td> RankSekolah  </td>
            <td>Rank</td>
        </tr>
    ';  
    
    $nilai = array(); 
    $nilai_sekolah = array(); 
    $sekolah = array();
    foreach($result->fetch_all(MYSQLI_ASSOC) as $key => $val ){ 
        $t = "
            select A.siswaNama, A.nilai, B.sekolahNama, C.kelasNama, A.grade
            from tbl_siswa A , tbl_sekolah B, tbl_kelas C
            WHERE 
            A.kelasID = C.kelasID 
            AND B.sekolahID = C.sekolahID 
            AND A.kelasID = '".$val['kelasID']."'
            ORDER BY A.nilai DESC 
            limit 10";
        
        echo '<pre>';
        $result2 = $conn->query($t); 
        $highest = 0; 
        foreach($result2->fetch_all(MYSQLI_ASSOC) as $keys => $vals ){   
            if ($vals > $highest){
                $highest = $keys;  
                $vals['rankkelas'] = $highest + 1; 
            }  
            array_push($nilai, $vals['nilai']);
            
            $nilai_sekolah[$vals['sekolahNama']][] = $vals['nilai'];
            $sekolah[$vals['sekolahNama']][] = $vals; 
        }  
    } 
    rsort($nilai, SORT_NUMERIC);    
    foreach($sekolah as $key => $value){ 
        rsort($nilai_sekolah[$key], SORT_NUMERIC);  
        for($k=0; $k < count($value); $k++){ 
            $value[$k]['ranking'] = array_search($value[$k]['nilai'], $nilai) + 1;
            $value[$k]['ranking_sekolah'] = array_search($value[$k]['nilai'],   $nilai_sekolah[$key] ) + 1;
            echo '<tr>'; 
            echo '<td>'.$value[$k]['siswaNama'].'</td>';
            echo '<td>'.$value[$k]['nilai'].'</td>';
            echo '<td>'.$value[$k]['rankkelas'].'</td>';
            echo '<td>'.$value[$k]['ranking_sekolah'].'</td>';
            echo '<td>'.$value[$k]['ranking'].'</td>';
            echo '<tr>'; 
        }
    }
    
    echo '</table>';
 
} 
?>