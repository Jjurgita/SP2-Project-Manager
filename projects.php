<?php include 'db_connection.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./style.css">
    <title>Projects</title>
</head>

<body>
    <div class="main_table">
        <?php
        /*  DELETE  */
        if (isset($_POST['delete'])) { // add: && !empty($_POST['delete']
            $delete = $conn->prepare("DELETE FROM projects WHERE p_id = ?");
            $delete->bind_param("i", $delete_id);
            $delete_id = $_POST['id'];
            $delete->execute();
            $delete->close();
            header('Location: ' . $_SERVER['REQUEST_URI']);
            die;
        }

        /*  UPDATE  */
        if (isset($_POST['update_name'])) {
            $id = $_POST['id'];
            $update = $conn->prepare("UPDATE projects SET p_name = ? WHERE p_id = '$id'");
            $update->bind_param("s", $new_name);
            $new_name = $_POST['p_name'];
            $update->execute();
            $update->close();
            header('Location: ' . $_SERVER['REQUEST_URI']);
            die;
        }

        /*  ADD NEW ROW - Project  */
        if (isset($_POST['create_project'])) {
            $newP = $conn->prepare("INSERT INTO projects (p_name) VALUES (?)");
            $newP->bind_param("s", $name);
            $name = $_POST['p_name'];
            $newP->execute();
            $newP->close();
            header('Location: ' . $_SERVER['REQUEST_URI']);
            die;
        }

        // SELECT query
        $sql = 'SELECT projects.p_id, projects.p_name, GROUP_CONCAT(CONCAT_WS("  " , employees.e_name) SEPARATOR ", ") 
                AS e_names FROM projects LEFT JOIN employees ON projects.p_id = employees.pro_id GROUP BY p_id';
        $result = $conn->query($sql); // Same as: $result = mysqli_query($conn, $sql);

        // If we have results more than 0, print content
        if ($result->num_rows > 0) { // Same as: (mysqli_num_rows($result)
            print('<table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Employees</th>
                            <th>Actions</th>
                        </tr>
                    </thead>');
            while ($row = $result->fetch_assoc()) { // Same as: ($row = mysqli_fetch_assoc($result))
                print('<tr>
                            <td>' . $row['p_id'] . '</td>
                            <td>' . $row['p_name'] . '</td>
                            <td>' . $row['e_names'] . '</td>
                            <td>
                                <form class="actions" action="" method="POST">
                                    <input type="hidden" name="id" value="' . $row['p_id'] . '">
                                    <button class="btn btn-default" type="submit" name="delete" value="' . $row['p_id'] . '">Delete</button>
                                </form>
                                <form class="actions" action="" method="POST">
                                    <input type="hidden" name="id" value="' . $row['p_id'] . '">
                                    <input type="hidden" name="name" value="' . $row['p_name'] . '">
                                    <button class="btn btn-primary" type="submit" name="update" value="' . $row['p_id'] . '">Update</button>
                                </form>
                            </td>
                        </tr>');
            }
            print('</table>');
        } else {
            echo "0 results";
        }

        /*  UPDATE FORMS  */
        if (isset($_POST['update'])) {
            $crnt_name = $_POST['name'];
            $crnt_id = $_POST['id'];
            print('<div>
                    <form class="actions" action="" method="POST">
                        <input type="hidden" name="id" value="' . $crnt_id . '">
                        <input type="text" id="p_name" name="p_name" value="' . $crnt_name . '">
                        <br>
                        <button class="btn btn-primary" type="submit" name="update_name">Change</button>
                    </form>
                </div>');
        } else {
            print('<div>
                    <form class="actions" action="" method="POST">
                        <label for="p_name">To add new project:</label><br>
                        <input type="text" id="p_name" name="p_name" placeholder="Project name"><br>
                        <button class="btn btn-primary" type="submit" name="create_project">Submit</button>
                    </form>
                </div>');
        }
        $conn->close();
        ?>
    </div>
</body>

</html>