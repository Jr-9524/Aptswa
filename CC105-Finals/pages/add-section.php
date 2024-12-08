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
    <h1>Section List</h1>
        <div class="category-form section-form">
            <div class="section-container">
                <form class="add-sub" method="POST">
                    <input type="text" placeholder="Section" name="sec-name" required value="<?php echo isset($sec) ? htmlspecialchars($sec) : ''; ?>">
                    <br>
                    <button type="submit" name="action" value="sec-add">Add</button>
                    <button type="submit" name="action" value="sec-delete">Delete</button>
                </form>

                <div class="section-table scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Section</th>
                            </tr>
                            <tr>
                                <?php 
                                    include("../dbconnection.php");
                                    $sectionTable = "SELECT * FROM `section-tbl`";
                                    $result = $conn->query($sectionTable);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                <td>{$row['section']}</td>
                                            </tr>";
                                        }
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

            $sec = isset($_POST["sec-name"]) ? $_POST["sec-name"] : '';

            if ($_POST['action'] === 'sec-add') {
                $check_sql = "SELECT * FROM `section-tbl` WHERE `section` = '$sec'";
                $check_result = $conn->query($check_sql);

                if ($check_result->num_rows > 0) {
                    echo "<script> alert(' Subject Code Already Exist'); </script>";
                } else {
                    $sql = "INSERT INTO `section-tbl` (`section`) VALUES ('$sec')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script> window.location.href='add-section.php'; </script>";
                        exit();
                    } else {
                        echo "Error: " . $conn->error;
                    } 
                }
            } elseif ($_POST['action'] === 'sec-delete') {
                $delete_sql = "DELETE FROM `section-tbl` WHERE `section` = '$sec'";
                if ($conn->query($delete_sql) === TRUE) {
                    echo "<div class='sec-deleted'>Section Successfully Deleted.</div>";
                    header("Refresh:0");
                    exit();
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
            }
            $conn->close();
        }
    ?>
    </section>

    </body>
    </html>