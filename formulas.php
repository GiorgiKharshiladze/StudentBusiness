<?php


                $progress = 0;
                $progclass = "";
                $paid = $row['paid'];
                $discount = $row['discount']/100; // Convert discount percent into decimal fraction
                $index = 1 - $discount; // Index to reduce total $total
                $total = $row['total'];
                $finaltopay = $total * $index - $paid;
                
                if($total!=0)
                {
                    $progress = round($paid / ($total * $index) * 100, 2);
                }



                if($progress<=30){$progclass="progress progress-striped progress-danger active";}elseif($progress<=60){ $progclass="progress progress-striped progress-warning active";}                elseif($progress<=99){ $progclass="progress progress-striped active";}else {$progclass="progress progress-striped progress-success active";}


                if($row['risk']==0) {$risk = 1;}
                else {$risk = $row['risk'];}

                if($row['myscore']==0) {$myscore = 1;}
                else {$myscore = $row['myscore'];}

                $algorithm = (intval($risk)+intval($myscore))*floatval($finaltopay);

                // NEEDS TO BE UPDATED IN THE DB to ORDER BY algorithm

                // Final to pay is calculated automatically



?>