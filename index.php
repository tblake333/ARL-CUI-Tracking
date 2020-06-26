<?php 

    include('config/db_connect.php');

    $sql = 'SELECT * FROM cui_items';

    $stmt = $pdo->query($sql);

    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Close PDO connection
    $stmt = null;
    $pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
    <?php include('public/templates/header.php') ?>

    <h4 class="center grey-text">CUI Items</h4>
    <div class="container">
        <div class="row">
            <?php foreach($items as $item) { ?>
                <div class="col s12 md3">
                    <div class="card z-depth-0">
                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($item['title']) ?></h6>
                            <div><?php echo htmlspecialchars($item['description']) ?></div>
                        </div>
                        <div class="card-action right-align">
                            <a href="details.php?id=<?php echo $item['id'] ?>" class="brand-text">more info</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include('public/templates/footer.php') ?>
</html>