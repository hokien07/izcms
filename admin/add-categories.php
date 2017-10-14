<?php include('../includes/header.php');?>
<?php include('../includes/mysqli_connect.php'); ?>
<?php include('../includes/sidebar_admin.php'); ?>



	<?php
		// php check submit form
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $errors = array();
		    if(empty($_POST['category'])){
                    $errors[] =  "category";
            }else{
                $cat_name = mysqli_real_escape_string($dbc, strip_tags($_POST['category']));
            }
            //kient ra ton tai select va kiem tra int cho select
		    if(isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range'=> 1))){
                $position = mysqli_real_escape_string($dbc, strip_tags($_POST['position']));
            }else {
                $errors[] ="position";
            }

            if(empty($errors)) {//neu khong co loi xay ra thi chay
                $q = "INSERT INTO categ (user_id, cat_name, vitri) VALUES (1, '{$cat_name}', $position)";
                $r = mysqli_query($dbc, $q) or die("Query {$q} <br/><br/> MYSQL ERROR: ". mysqli_error($dbc));

                if(mysqli_affected_rows($dbc) == 1){
                    $mes =  "<p class='success'>The category was added successfuly.</p>";
                }
                else{
                    $mes =  "<p class='warning'>Coudt not added to the database due to a system error</p>";
                }
            }else {
		        $mes =  "<p class='warning'>please fill all requed fileds</p>";
            }

		}//end main if condituon submit.

	?>
<div id="content">
    <h2>Create a category</h2>
     <?php
        if(isset($mes)) {
            echo $mes;
        }
     ?>
	<form id="add_cat" action="" method="post" accept-charset="utf-8">
		<fieldset>
			<legend>Add category</legend>
			<div>
				<label  for="category">Category Name: <span>*</span>
                 <?php
                    if(isset($errors) && in_array("category", $errors, true)) {
                        echo "<p class='warning'> please fill category name </p>";
                    }

                 ?>
                </label>

				<input type="text" name="category" id="category" value="<?php if(isset($_POST['category']))echo strip_tags($_POST['category']) ?>" size="20" maxlength="150" tabindex="1">
			</div>

			<div>
                <label for="position">Position: <span>*</span>
                    <?php
                        if(isset($errors) && in_array("position", $errors,true)) {
                            echo "<p class='warning'> please select position</p>";
                        }

                    ?>
                </label>
				<select name="position" tabindex="2">
					<option>Select option</option>
					<?php
                        $q = "SELECT count(cat_id) AS count FROM categ";
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
		</fieldset>
		<p><input type="submit" name="submit" value="Add Category" tabindex="3"></p>

	</form>
    
</div><!--end content-->
<?php include ('../includes/sidebar_b.php') ?>
<?php include('../includes/footer.php'); ?>