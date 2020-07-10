<!DOCTYPE html>
<html lang="en">

    <?php echo view('templates/header') ?>

    <section class="container grey-text">
        <?php $errors = isset($validation) ? $validation->getErrors() : array();
                $entries = isset($entries) ? $entries : array() ?>
        <h4 class="center">Add item</h4>
        <form action="add" method="POST" class="white">
            <?php csrf_field() ?>

            <label>Title:</label>
            <input type="text" name="title" value="<?php echo esc($entries['title'] ?? '') ?>">
            <div class="red-text"><?php echo $errors['title'] ?? '' ?></div>

            <label>Type:</label>
            <input type="text" name="type" value="<?php echo esc($entries['type'] ?? '') ?>">
            <div class="red-text"><?php echo $errors['type'] ?? '' ?></div>

            <label>Owner Badge Number:</label>
            <input type="text" name="owner" id="badge_number" value="<?php echo esc($entries['owner'] ?? '') ?>">
            <div class="red-text"><?php echo $errors['owner'] ?? '' ?></div>
            <div class="green-text" id="badge_number_info"></div>

            <div id="user_details">
                <?php if (isset($entries['first_name']) || isset($entries['last_name']) || isset($errors['first_name']) || isset($errors['last_name'])): ?>
                    <h6>User Details</h6>
                    <div class="container">
                        <label>First Name:</label>
                        <input type="text" name="first_name" autocomplete="off" value="<?php echo esc($entries['first_name'] ?? '') ?>">
                        <div class="red-text"><?php echo esc($errors['first_name'] ?? '') ?></div>
                        <label>Last Name:</label>
                        <input type="text" name="last_name" autocomplete="off" value="<?php echo esc($entries['last_name'] ?? '') ?>">
                        <div class="red-text"><?php echo esc($errors['last_name'] ?? '') ?></div>
                    </div>
                <?php endif ?>
            </div>

            <label>Source:</label>
            <input type="text" name="source" value="<?php echo esc($entries['source'] ?? '') ?>">
            <div class="red-text"><?php echo $errors['source'] ?? '' ?></div>

            <label>Source Date:</label>
            <input type="date" name="source_date" value="<?php echo esc($entries['source_date'] ?? '') ?>">
            <div class="red-text"><?php echo $errors['source_date'] ?? '' ?></div>

            <label>Location:</label>
            <input type="text" name="location" value="<?php echo esc($entries['location'] ?? '') ?>">
            <div class="red-text"><?php echo $errors['location'] ?? '' ?></div>

            <label>Description:</label>
            <textarea name="description" cols="30" rows="10"><?php echo esc($entries['description'] ?? '') ?></textarea>
            <div class="red-text"><?php echo $errors['description'] ?? '' ?></div>

            <label>Keywords:</label>
            <input name="keywords" value="<?php echo esc($entries['keywords'] ?? '') ?>">
            <div class="red-text"><?php echo $errors['keywords'] ?? '' ?></div>

            <input type="hidden" name="barcode" id="barcode-input">
            <div class="red-text"><?php echo $errors['barcode'] ?? '' ?></div>

            <div class="center">
                <input type="submit" value="submit" name="submit" class="btn brand z-depth-0">
            </div>
        </form>
        <script src="/js/barcode-detect.js"></script>
        <script src="/js/user-detect.js"></script>
    </section>
    
    <?php echo view('templates/footer') ?>

</html>