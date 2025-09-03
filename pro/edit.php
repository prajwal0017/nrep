<?php
include 'db.php';
if (!isset($_GET['id'])) {
    die("No product ID provided.");
}
$id = $_GET['id'];
$sql = $conn->prepare("SELECT * FROM q3 WHERE id=?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows === 0) {
    die("Product not found.");
}
$product = $result->fetch_assoc();
if (isset($_POST['update'])){
    $name = $_POST['name'];
    $pdesc = $_POST['desc'];
    $status = $_POST['status'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    $update = $conn->prepare("UPDATE q3 SET project_name=?, project_description=?, status=?, start_date=?, end_date=? WHERE id=?");
    $update->bind_param("sssssi", $name, $pdesc, $status, $sdate, $edate, $id);
    if ($update->execute()) {
        header("Location: addproducts.php"); // redirect back to main page
    } else {
        echo "Error updating product: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form action="" method="POST">
        Name :
        <input type="text" name="name" id="name" value="<?= $product['project_name'] ?>">
        <br>
        Project description :
        <input type="text" name="desc" id="desc" value="<?= $product['project_description'] ?>">
        <br>
        Status :
        <select name="status" id="status">
            <option value="pending" <?= ($product['status']=="pending") ? "selected" : "" ?>>pending</option>
            <option value="in-progress" <?= ($product['status']=="in-progress") ? "selected" : "" ?>>in-progress</option>
            <option value="completed" <?= ($product['status']=="completed") ? "selected" : "" ?>>completed</option>
        </select>
        <br>
        Start date :
        <input type="date" name="sdate" id="sdate" value="<?= $product['start_date'] ?>">
        <br>
        End date :
        <input type="date" name="edate" id="edate" value="<?= $product['end_date'] ?>">
        <br>
        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>
