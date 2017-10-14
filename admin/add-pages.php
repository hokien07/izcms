<?php include('../includes/header.php');?>
<?php include('../includes/mysqli_connect.php'); ?>
<?php include('../includes/sidebar_admin.php'); ?>



<?php
// php check submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    if(empty($_POST['page_name'])){
        $errors[] = "page_name";
    }else {
        $page_name = mysqli_real_escape_string($dbc, strip_tags($_POST['page_name']));
    }
    //kient ra ton tai select va kiem tra int cho select
    if(isset($_POST['category']) && filter_var($_POST['category'], FILTER_VALIDATE_INT, array('min_range'=> 1))){
        $cat_id = mysqli_real_escape_string($dbc, strip_tags($_POST['category']));
    }else {
        $errors[] ="category";
    }

    //kient ra ton tai select va kiem tra int cho select
    if(isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range'=> 1))){
        $position = mysqli_real_escape_string($dbc, strip_tags($_POST['position']));
    }else {
        $errors[] ="position";
    }

    if(empty($_POST['content'])){
        $errors[] = 'content';
    }else {
        $page_content = mysqli_real_escape_string($dbc, $_POST['content']);
    }

    if(empty($errors)) {
        $q = "INSERT INTO pages (user_id, cat_id, page_name, content, position, post_on) 
                            VALUES (1, {$cat_id}, '{$page_name}', '{$page_content}',{$position}, NOW())";
        $r= mysqli_query($dbc, $q) or die("Query {$q} <br/><br/> MYSQL ERROR: ". mysqli_error($dbc));

        if(mysqli_affected_rows($dbc) == 1) {
            $mes = "<p class='success'>The pages was add successfuly</p>";
        }else {
            $mes = "<p class='warning'>The page not be add due to a system error!";
        }
    }else {
        $mes = "<p class='warning'> Pleas fill all the reauired fiedles";
    }


}//end main if condituon submit.

?>
    <div id="content">
        <h2>Create a page</h2>
        <?php if(isset($mes)) echo $mes;?>

        <form action="" id="login" method="post">
            <fieldset>
                <legend>Add a page</legend>
                <div>
                    <label for="page">Page Name: <span class="required">*</span>
                        <?php
                        if(isset($errors) && in_array("page_name", $errors, true)) {
                            echo "<p class='warning'> please fill page name </p>";
                        }

                        ?>
                    </label>
                    <input type="text" name="page_name" value="<?php if(isset($_POST['page_name']))
                        echo strip_tags($_POST['page_name']);?>" size="20" maxleng="150" tabindex="1">
                </div>

                <div>
                    <label for="category">All Category: <span class="required">*</span>
                        <?php
                        if(isset($errors) && in_array("category", $errors, true)) {
                            echo "<p class='warning'> please select category name </p>";
                        }

                        ?>
                    </label>

                    <select name="category">
                        <option>select category</option>
                        <?php
                        $q = "SELECT cat_id, cat_name  FROM categ";
                        $r = mysqli_query($dbc, $q) or die("Query {$q} <br/><br/> MYSQL ERROR: ". mysqli_error($dbc));

                        if(mysqli_num_rows($r) > 0){
                            while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
                                echo "<option value='$row[0]'";
                                    if(isset($_POST['category']) && $_POST['category'] == $row[0])
                                        echo "selected = 'selected'";
                                echo ">". $row[1]."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="position">Position: <span class="required">*</span>
                        <?php
                        if(isset($errors) && in_array("category", $errors, true)) {
                            echo "<p class='warning'> please select position </p>";
                        }

                        ?>
                    </label>

                    <select name="position">
                        <option>select postion</option>

                        <?php
                        $q = "SELECT count(page_id) AS count FROM pages";
                        $r = mysqli_query($dbc, $q) or die("Query {$q} <br/><br/> MYSQL ERROR: ". mysqli_error($dbc));
                        if(mysqli_num_rows($r) == 1){
                            list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
                            for($i = 1; $i <= $num + 1; $i++){ //tao vong for de ra option. cong them 1 cho gia tri option.
                                echo "<option value='{$i}'";
                                if(isset($_POST['position']) && $_POST['position'] == $i){
                                    echo "selected='select'";
                                }
                                echo ">" . $i. "</option>";
                            }
                        }
                        ?>

                    </select>
                </div>

                <div>
                    <label for="page_content">Page Content: <span class="required">*</span>
                        <?php
                        if(isset($errors) && in_array("content", $errors, true)) {
                            echo "<p class='warning'> please fill page content </p>";
                        }

                        ?>
                    </label>
                    <textarea name="content" cols="50" rows="20"></textarea>
                </div>
            </fieldset>
            <p><input type="submit" name="submit" value="Add Page" /></p>
        </form>

    </div><!--end content-->
<?php include ('../includes/sidebar_b.php') ?>
<?php include('../includes/footer.php'); ?>