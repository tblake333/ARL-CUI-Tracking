<!DOCTYPE html>
<html lang="en">

    <?php echo view('templates/header') ?>

    <section class="container grey-text">
        <?php $errors = isset($validation) ? $validation->getErrors() : array();
                $entries = isset($entries) ? $entries : array() ?>
        <h4 class="center">Check-out item</h4>
        <form action="CheckOut" method="POST" class="white">
            <?php csrf_field() ?>
            <label>Badge Number:</label>
            <input type="text" name="badge_number" id="badge_number" autocomplete="off" value="<?php echo esc($entries['badge_number'] ?? '') ?>">
            <div class="red-text" id="badge_number_error"><?php echo esc($errors['badge_number'] ?? '') ?></div>
            <div class="green-text" id="badge_number_info"></div>
            <input type="hidden" name="barcode" id="barcode-input" value="<?php echo esc($entries['barcode'] ?? '') ?>">
            <div class="red-text" id="barcode_error"><?php echo esc($errors['barcode'] ?? '') ?></div>
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
            <div id="barcode_details"></div>
            <div class="center">
                <input type="submit" value="submit" name="submit" class="btn brand z-depth-0">
            </div>
        </form>
        <script src="/js/barcode-detect.js"></script>
        <script src="/js/user-detect.js"></script>
        <script src="/js/barcode-validate.js"></script>
    </section>
    
    <?php echo view('templates/footer') ?>

</html>