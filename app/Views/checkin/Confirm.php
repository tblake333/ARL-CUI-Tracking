<!DOCTYPE html>
<html lang="en">

    <?php echo view('templates/header') ?>

    <section class="container grey-text">
        <h4 class="center">Confirm Check-in</h4>
        <form action="confirm" method="POST" class="white">
            <?php csrf_field() ?>

            <h6>User Details</h6>

            <div class="container">
                <label>Badge number:</label>
                <p><?php echo esc($user['badge_number']) ?></p>
                <label>First name:</label>
                <p><?php echo esc($user['first_name']) ?></p>
                <label>Last name:</label>
                <p><?php echo esc($user['last_name']) ?></p>
            </div>
            
            <h6>Check-out Item Details</h6>
            <div class="container">
                <label>Title:</label>
                <p><?php echo esc($item['title']) ?></p>
                <label>Type:</label>
                <p><?php echo esc($item['type']) ?></p>
                <label>Description:</label>
                <p><?php echo esc($item['description']) ?></p>
                <label>Barcode:</label>
                <p><?php echo esc($item['barcode']) ?></p>
            </div>

            <div class="center">
                <input type="submit" value="cancel" name="cancel" class="btn cancel z-depth-0">
                <input type="submit" value="submit" name="submit" class="btn brand z-depth-0">
            </div>
        </form>
    </section>
    
    <?php echo view('templates/footer') ?>

</html>