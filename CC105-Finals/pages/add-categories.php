<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Categories</title>
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/inputs.css">
    <link rel="stylesheet" href="../css/tables.css">
    <link rel="stylesheet" href="../css/container.css">
    <link rel="stylesheet" href="../css/media-queries.css">
    <script src="../js/index.js"></script>
</head>
<body>
    <section>
        <h1>Subject List</h1>
            <div class="category-form subject-form">
                <div class="subject-container">
                    <form class="add-sub" method="POST">
                        <input type="text" placeholder="Subject Code" name="sub-code" required value="<?php echo isset($subCode) ? htmlspecialchars($subCode) : ''; ?>">
                        <input type="text" placeholder="Subject Name" name="sub-name" value="<?php echo isset($subName) ? htmlspecialchars($subName) : ''; ?>">
                        <br>

                        <div>
                            <button type="submit" name="action" value="add">Add</button>
                            <button type="submit" name="action" value="update">Update</button>
                            <button type="submit" name="action" value="delete">Delete</button>
                        </div>
                    </form>

                    <div class="subject-table scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                </tr>
                                <tr>
                                    <?php 
                                        include("../dbconnection.php");

                                        $subjectTable = "SELECT * FROM `subject-code-tbl`";
                                        $result = $conn->query($subjectTable);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>
                                                    <td>{$row['subject-code']}</td>
                                                    <td>{$row['subject-name']}</td>
                                                </tr>";
                                            }
                                        } else {
                                            echo "<tr><td>No records found</td></tr>";
                                        }
                                    ?>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <button type="button" onclick="location.href='../index.php'" class="category-btn">Back</button>
            
        <?php 
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include("../dbconnection.php");

                $subCode = isset($_POST["sub-code"]) ? $_POST["sub-code"] : '';
                $subName = isset($_POST["sub-name"]) ? $_POST["sub-name"] : '';

                if ($_POST['action'] === 'add') {
                    $check_sql = "SELECT * FROM `subject-code-tbl` WHERE `subject-code` = '$subCode'";
                    $check_result = $conn->query($check_sql);

                    if ($check_result->num_rows > 0) {
                        echo "<script> alert(' Subject Code Already Exist'); </script>";
                    } else {
                        $sql = "INSERT INTO `subject-code-tbl` (`subject-code`, `subject-name`) VALUES ('$subCode', '$subName')";
                        if ($conn->query($sql) === TRUE) {
                            echo "<script> window.location.href='add-categories.php'; </script>";
                            exit();
                        } else {
                            echo "Error: " . $conn->error;
                        } 
                    }
                } elseif ($_POST['action'] === 'update') {
                    $update_sql = "UPDATE `subject-code-tbl` SET `subject-name` = '$subName' WHERE `subject-code` = '$subCode'";
                    if ($conn->query($update_sql) === TRUE) {
                        echo "<script> window.location.href='add-categories.php'; </script>";
                        exit();
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }     
                } elseif ($_POST['action'] === 'delete') {
                    $delete_sql = "DELETE FROM `subject-code-tbl` WHERE `subject-code` = '$subCode'";
                    if ($conn->query($delete_sql) === TRUE) {
                        echo "<script> window.location.href='add-categories.php'; </script>"; 
                        exit();
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                    $conn->close();
                }
            }
        ?>

    </section>
</body>
</html>