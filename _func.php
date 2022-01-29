<?php
function setRandomNumber(){
  $min = 1;
  $max = 100;
  $num = $min + lcg_value() * ($max - $min);
  $randomFloat = sprintf("%.2f", $num);
  return $randomFloat;
}

function setGrade($vals){
    /*
      A: 80.00 - 100.00
      AB : 75.00 - 79.99
      B : 65.00 - 74.99
      BC : 60.00 - 64.99
      C : 50.00 - 59.99
      D : 35.00 - 49.99
      E : 0 - 34.99
    */
    $val = (float) $vals;
    if ($val >= 80.00 && $val <= 100.00) {
      return 'A';
    } else if ($val >= 75.00 && $val <= 79.99 ) {
      return 'AB';
    } else if ($val >= 65.00 && $val <= 74.99 ) {
      return 'B';
    } else if ($val >= 60.00 && $val <= 64.99 ) {
      return 'BC';
    } else if ($val >= 50.00 && $val <= 59.99 ) {
      return 'C';
    } else if ($val >= 35.00 && $val <= 49.99 ) {
      return 'D';
    } else if ($val >= 0 && $val <= 34.99 ) {
      return 'E';
    }  
  } 
?>