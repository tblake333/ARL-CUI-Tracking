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
            <input type="hidden" name="barcode" id="barcode-input">
            <div class="red-text" id="barcode_error"><?php echo esc($errors['barcode'] ?? '') ?></div>
            <div id="user_details"></div>
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