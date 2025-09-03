<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add products </title>
</head>
<body>
    <h2>Add Products</h2>
    <form action="" method="POST">
        name :
        <input type="text" name="name" id="name">
        <br>
        project description :
        <input type="text" name="desc" id="desc">
        <br>
        status :
        <select name="status" id="status">
            <option value="pending">pending</option>
            <option value="in-progress">in-progress</option>
            <option value="completed">completed</option>
        </select>
        <br>
        start date :
        <input type="date" name="sdate" id="sdate">
        <br>
        end date :
        <input type="date" name="edate" id="edate">
        <br>
        <button type="submit" name="submit">submit</button>
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $name=$_POST['name'];
        $pdesc=$_POST['desc'];
        $status=$_POST['status'];
        $sdate=$_POST['sdate'];
        $edate=$_POST['edate'];
        $sql = $conn->prepare('INSERT INTO q3(project_name,project_description,status,start_date,end_date) VALUES(?,?,?,?,?)');
        $sql->bind_param('sssss',$name,$pdesc,$status,$sdate,$edate);
        if($sql->execute()){
            echo 'data inserted';
        }
    }
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $conn->query("DELETE FROM q3 WHERE id=$id");
    }
    ?>
    <br><br><br><br>
    <h2>Project Details</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <td>id</td>
            <td>name</td>
            <td>project description</td>
            <td>status</td>
            <td>start date </td>
            <td>end date</td>
            <td>actions</td>
        </tr>
        <?php   
        $result = $conn->query('SELECT * FROM q3');
        while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id']?></td>
            <td><?= $row['project_name']?></td>
            <td><?= $row['project_description']?></td>
            <td><?= $row['status']?></td>
            <td><?= $row['start_date']?></td>
            <td><?= $row['end_date']?></td>
            <td>
                <a href="edit.php?id=<?= $row['id']?>">Edit</a> | 
                <a href="?delete=<?= $row['id']?>" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
            </td>
        </tr>
        <?php }?>
    </table>
</body>
</html>
