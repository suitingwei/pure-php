<?php
for($i=0;$i<2;$i++){
  $pid= pcntl_fork();

  if($pid ==0 ){
    echo "{$i}\tchild \n";
  }
  else{
     echo "{$i}\tparent\n";
	 #continue;
  }
}

