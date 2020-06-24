<?php
    include('config/db_connect.php');

    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        $sql = "SELECT * FROM cui_items WHERE id = $id";
        
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo mysqli_error($conn);
        }

        $item = mysqli_fetch_assoc($result);

        mysqli_free_result($result);
        mysqli_close($conn);
    }

    if (isset($_POST['delete'])) {
        $id = mysqli_real_escape_string($conn, $_POST['delete_id']);

        $sql = "DELETE FROM cui_items WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }

    }
?>

<!DOCTYPE html>
<html lang="en">

<?php include('public/templates/header.php') ?>

<div class="container center">
    <?php if ($item): ?>
        <h4><?php echo htmlspecialchars($item['title']); ?></h4>
        <p>Type: <?php echo htmlspecialchars($item['type']); ?></p>
        <p>Barcode: <?php echo htmlspecialchars($item['barcode']); ?></p>
        <p>Source: <?php echo htmlspecialchars($item['source']); ?></p>
        <p>Source Date: <?php echo date($item['source_date']); ?></p>
        <p>Date Entered: <?php echo date($item['entry_time']); ?></p>
        <p>Location: <?php echo htmlspecialchars($item['location']); ?></p>
        <p>Description: <?php echo htmlspecialchars($item['description']); ?></p>
        <p>Checked out: <?php echo ($item['checked_out'] ? 'Yes' : 'No'); ?></p>

        <form action="details.php" method="POST">
            <input type="hidden" name="delete_id" value="<?php echo $item['id'] ?>">
            <input type="submit" name="delete" value="Delete Item" class="btn brand z-depth-0">
        </form>
    <?php else: ?>
        <h5>Item not found</h5>
    <?php endif ?>
</div>


<?php include('public/templates/footer.php') ?>

</html>