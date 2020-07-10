<!DOCTYPE html>
<html lang="en">

    <?php echo view('templates/header') ?>

    <section class="container grey-text">
        <h4 class="center">Confirm Check-out</h4>
        <form action="confirm" method="POST" class="white">
            <?php csrf_field() ?>
            <?php 
            
            $firstName = $session->get('first_name');
            $lastName = $session->get('last_name');

            if ($user) {
                $firstName = $user['first_name'];
                $lastName = $user['last_name'];
            } 
            
            ?>

            <?php if($user): ?>
                <h6>User Details</h6>
            <?php else: ?>
                <h6>New User Details</h6>
            <?php endif ?>

            <div class="container">
                <label>Badge number:</label>
                <p><?php echo esc($session->get('badge_number')) ?></p>
                <label>First name:</label>
                <p><?php echo esc($firstName) ?></p>
                <label>Last name:</label>
                <p><?php echo esc($lastName) ?></p>
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
        <script src="/js/barcode-detect.js"></script>
    </section>
    
    <?php echo view('templates/footer') ?>

</html>