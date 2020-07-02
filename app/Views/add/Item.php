<!DOCTYPE html>
<html lang="en">

    <?php echo view('templates/header') ?>

    <section class="container grey-text">
        <?php $errors = $validation->getErrors() ?>
        <h4 class="center">Add item</h4>
        <form action="add" method="POST" class="white">
            <?php csrf_field() ?>
            <label>Title:</label>
            <input type="text" name="title">
            <div class="red-text"><?php echo $errors['title'] ?? '' ?></div>
            <label>Type:</label>
            <input type="text" name="type">
            <div class="red-text"><?php echo $errors['type'] ?? '' ?></div>
            <label>Source:</label>
            <input type="text" name="source">
            <div class="red-text"><?php echo $errors['source'] ?? '' ?></div>
            <label>Source Date:</label>
            <input type="date" name="source_date">
            <div class="red-text"><?php echo $errors['source_date'] ?? '' ?></div>
            <label>Location:</label>
            <input type="text" name="location">
            <div class="red-text"><?php echo $errors['location'] ?? '' ?></div>
            <label>Description:</label>
            <textarea name="description" cols="30" rows="10"></textarea>
            <div class="red-text"><?php echo $errors['description'] ?? '' ?></div>
            <input type="hidden" name="barcode" id="barcode-input">
            <div class="red-text"><?php echo $errors['barcode'] ?? '' ?></div>
            <div class="center">
                <input type="submit" value="submit" name="submit" class="btn brand z-depth-0">
            </div>
        </form>
        <script src="/js/barcode-detect.js"></script>
    </section>
    
    <?php echo view('templates/footer') ?>

</html>