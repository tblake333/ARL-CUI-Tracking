<?php

    include('config/db_connect.php');

    $fields = ['title', 'type', 'source', 'source-date', 'location', 'description', 'barcode'];
    $entries = array();
    $errors = array();

    foreach ($fields as $field) {
        $entries[$field] = '';
        $errors[$field] = '';
    }

    if (isset($_POST['submit'])) {
        // Form has been submitted
        foreach ($fields as $field) {
            $data = $_POST[$field];
            if (isRequired($field)) {
                if (empty($data)) {
                    $errors[$field] = $errors[$field] = "Please submit a " . ucwords(str_replace('-', ' ', $field));
                }
            }
            if (!empty($data)) {
                $entries[$field] = $data;
                if ($field == "title" || $field == 'type' || $field == 'source' || $field == 'location') {
                    if (!filter_var(strlen($data), FILTER_VALIDATE_INT, ["options" => ["min_range"=>0, "max_range"=>30]])) {
                        $errors[$field] = "Please enter a " . ucwords(str_replace('-', ' ', $field)) . " with maximum 30 characters.";
                    }
                } else if ($field == "description") {
                    if (!filter_var(strlen($data), FILTER_VALIDATE_INT, ["options" => ["min_range"=>0, "max_range"=>250]])) {
                        $errors[$field] = "Please enter a " . ucwords($field) . " with maximum 250 characters.";
                    }
                } else if ($field == 'source-date') {
                    $date = DateTime::createFromFormat('Y-m-d', $entries[$field]);
                    if (!$date || $date->format('Y-m-d') != $entries[$field]) {
                        $errors[$field] = "Please enter a valid date";
                    }
                }
            }
        }
        
        if (array_filter($errors)) {

        } else {
            foreach ($fields as $field) {
                $entries[$field] = mysqli_real_escape_string($conn, $_POST[$field]);
                if ($entries[$field] == '') {
                    $entries[$field] = NULL;
                }
            }

            $sql = "INSERT INTO cui_items(barcode, title, type, source, source_date, location, description) 
            VALUES('{$entries['barcode']}', '{$entries['title']}', '{$entries['type']}', '{$entries['source']}', 
            '{$entries['source-date']}', '{$entries['location']}', '{$entries['description']}')";

            if (mysqli_query($conn, $sql)) {
                header('Location: index.php');
            } else {
                echo 'query error: ' . mysqli_error($conn);
            }

        }
    }

    function isRequired($field) {
        $required_fields = ['title', 'type', 'location', 'barcode'];
        foreach($required_fields as $required_field) {
            if ($required_field == $field) {
                return true;
            }
        }
        return false;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <?php include('public/templates/header.php') ?>

    <section class="container grey-text">
        <h4 class="center">Add item</h4>
        <form action="add.php" method="POST" class="white">
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo $entries['title'] ?>">
            <div class="red-text"><?php echo $errors['title'] ?></div>
            <label>Type:</label>
            <input type="text" name="type" value="<?php echo $entries['type'] ?>">
            <div class="red-text"><?php echo $errors['type'] ?></div>
            <label>Source:</label>
            <input type="text" name="source" value="<?php echo $entries['source'] ?>"> 
            <div class="red-text"><?php echo $errors['source'] ?></div>
            <label>Source Date:</label>
            <input type="date" name="source-date" value="<?php echo $entries['source-date'] ?>">
            <div class="red-text"><?php echo $errors['source-date'] ?></div>
            <label>Location:</label>
            <input type="text" name="location" value="<?php echo $entries['location'] ?>">
            <div class="red-text"><?php echo $errors['location'] ?></div>
            <label>Description:</label>
            <textarea name="description" cols="30" rows="10"><?php echo $entries['description'] ?></textarea>
            <div class="red-text"><?php echo $errors['description'] ?></div>
            <input type="hidden" name="barcode" id="barcode-input">
            <div class="red-text"><?php echo $errors['barcode'] ?></div>
            <div class="center">
                <input type="submit" value="submit" name="submit" class="btn brand z-depth-0">
            </div>

        </form>
        <script src="public/js/barcode-detect.js"></script>
    </section>
    
    <?php include('public/templates/footer.php') ?>
</html>