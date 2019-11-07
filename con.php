<?php
require_once "abdate.php";
$x=$_POST['sub'];
 echo '<div class="row"><div class="col"><h4 class="card-title" style="color:red;" >Absent days</h4><ul style="color:black;">';

            foreach(array_unique($abdates) as $a)
            {
                    echo "<li >".$a."</li>";
            }

        echo $x.'</ul></div> <div class="col"><div style="margin:auto;">
            <div class="row" style="height:50px; align-content: center; justify-content: center;font-size: 32px;">'.$present_count.'</div>
            <div class="row" style="height:50px; align-content: center; justify-content: center;">classes attended of</div>
            <div class="row" style="height:50px; align-content: center; justify-content: center;font-size: 32px;">'.($present_count+$absent_count).'</div>
          </div>
          </div>
          <div class="col"> 
            <div class="row" style="font-size:32px ">'.number_format((($present_count/($present_count+$absent_count))*100),1).'%
	    </div></div></div>';
?>

