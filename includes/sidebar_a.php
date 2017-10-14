<div id="content-container">
  <div id="section-navigation">
   <ul class="navi">
     <?php

        //cau lenh truy xuat category
        $q= "SELECT cat_name, cat_id FROM categ ORDER BY vitri ASC";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);

        //lay category tu co so du lieu
        while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
            echo"<li><a href=''>".$row['cat_name'] ."</a>";
                //cau lenh truy xuat pages.
                $q1 = "SELECT page_id, page_name FROM pages WHERE cat_id = {$row['cat_id']}" ;
                $r1 = mysqli_query($dbc, $q1);
                    confirm_query($r1, $q1);
                    //lay page tu co so du lieu
                echo "<ul class='pages'>";
                    while ($pages = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {

                        echo "<li><a href=''>".$pages['page_name']. "</a></li>";
                    }
                echo "</ul>";
            echo "</li>";
        }//end while cat
     ?>
   </ul>
</div><!--end section-navigation-->