<?php
function unread_messages(){
    include("db_con.php");
    $result1 = mysqli_query($db_con,'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.user_id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$log_user_id.'" and m1.user1read="no" and users.user_id=m1.user2) or (m1.user2="'.$log_user_id.'" and m1.user2read="no" and users.user_id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
    $rowcount1=mysqli_num_rows($result1);
    echo $rowcount1;
}

unread_messages();

?>