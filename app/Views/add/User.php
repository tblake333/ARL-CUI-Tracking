<!DOCTYPE html>
<html lang="en">

    <?php echo view('templates/header') ?>

    <section class="container grey-text">
        <?php $errors = isset($validation) ? $validation->getErrors() : array();
                $entries = isset($entries) ? $entries : array() ?>
        <h4 class="center">Add user</h4>
        <form action="add" method="POST" class="white">
            <?php csrf_field() ?>
            <label>Badge number:</label>
            <input type="text" name="badge_number" value="<?php echo esc($entries['badge_number'] ?? '') ?>">
            <div class="red-text"><?php echo $errors['badge_number'] ?? '' ?></div>
            <label>First Name:</label>
            <input type="text" name="first_name" value="<?php echo esc($entries['first_name'] ?? '') ?>">
            <div class="red-text"><?php echo $errors['first_name'] ?? '' ?></div>
            <label>Last Name:</label>
            <input type="text" name="last_name" value="<?php echo esc($entries['last_name'] ?? '') ?>">
            <div class="red-text"><?php echo $errors['last_name'] ?? '' ?></div>
            <div class="center">
                <input type="submit" value="submit" name="submit" class="btn brand z-depth-0">
            </div>
        </form>
    </section>
    
    <?php echo view('templates/footer') ?>

</html>