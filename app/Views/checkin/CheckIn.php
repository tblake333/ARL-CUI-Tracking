<!DOCTYPE html>
<html lang="en">

    <?php echo view('templates/header') ?>

    <section class="container grey-text">
        <?php $errors = isset($validation) ? $validation->getErrors() : array();
                $entries = isset($entries) ? $entries : array() ?>
        <h4 class="center">Check-in item</h4>
        <form action="CheckIn" method="POST" class="white" id="form">
            <?php csrf_field() ?>
            <input type="hidden" name="barcode" id="barcode-input" value="<?php echo esc($entries['barcode'] ?? '') ?>">
            <div class="red-text" id="barcode_error"><?php echo esc($errors['barcode'] ?? '') ?></div>
            <div class="center">
                <input type="submit" value="submit" name="btnSubmit" class="btn brand z-depth-0">
            </div>
        </form>
        <script src="/js/barcode-detect.js"></script>
        <script src="/js/check-in-detect.js"></script>
    </section>
    
    <?php echo view('templates/footer') ?>

</html>