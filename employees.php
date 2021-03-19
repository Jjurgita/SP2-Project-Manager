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
    <title>Employees</title>
</head>

<body>
    <div class="main_table">
        <?php
        /*  DELETE  */
        if (isset($_POST['delete'])) {
            if (isset($_POST['delete'])) { // add: && !empty($_POST['delete']
                $delete = $conn->prepare("DELETE FROM employees WHERE e_id = ?");
                $delete->bind_param("i", $delete_id);
                $delete_id = $_POST['id'];
                $delete->execute();
                $delete->close();
                header('Location: ' . $_SERVER['REQUEST_URI']);
                die;
            }
        }

        /*  UPDATE  */
        /* ASSIGN EMPLOYEE TO PROJECT  */

        if (isset($_POST['update_name'])) {
            $id = $_POST['id'];
            $update = $conn->prepare("UPDATE employees SET e_name = ? WHERE e_id = '$id'");
            $update->bind_param("s", $new_name);
            $new_name = $_POST['e_name'];
            $update->execute();
            $update->close();

            // Assign employee
            $newE_P = $conn->prepare("UPDATE employees SET pro_id = ? WHERE e_id = '$id'");
            $newE_P->bind_param("i", $p_id);
            $p_id = $_POST['p_name'];
            $newE_P->execute();
            $newE_P->close();
        }
        // NOTE: You use the WHERE clause for UPDATE queries. When you INSERT, you are assuming that the row doesn't exist.

        /*  ADD NEW ROW - Employee  */
        if (isset($_POST['create_employee'])) {
            $newE = $conn->prepare("INSERT INTO employees (e_name) VALUES (?)");
            $newE->bind_param("s", $name);
            $name = $_POST['e_name'];
            $newE->execute();
            $newE->close();
            header('Location: ' . $_SERVER['REQUEST_URI']);
            die;
        }

        // SELECT query for tables
        $sql = 'SELECT DISTINCT e_id, e_name, p_name FROM employees LEFT JOIN projects ON employees.pro_id = projects.p_id';
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            print('<table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Projects</th>
                            <th>Actions</th>
                        </tr>
                    </thead>');
            while ($row = mysqli_fetch_assoc($result)) {
                print('<tr>
                        <td>' . $row['e_id'] . '</td>
                        <td>' . $row['e_name'] . '</td>
                        <td>' . $row['p_name'] . '</td> 
                        <td>
                            <form class="actions" action="" method="POST">
                                <input type="hidden" name="id" value="' . $row['e_id'] . '">
                                <button class="btn btn-default" type="submit" name="delete" value="' . $row['e_id'] . '">Delete</button>
                            </form>
                            <form class="actions" action="" method="POST">
                                    <input type="hidden" name="id" value="' . $row['e_id'] . '">
                                    <input type="hidden" name="name" value="' . $row['e_name'] . '">
                                    <button class="btn btn-primary" type="submit" name="update" value="' . $row['e_id'] . '">Update</button>
                            </form>
                        </td>   
                    </tr>');
            }
            print('</table>');

            /*  UPDATE FORMS  */
            if (isset($_POST['update'])) {
                $crnt_name = $_POST['name'];
                $crnt_id = $_POST['id'];
                print('<div>
                    <form class="actions" action="" method="POST">
                        <input type="hidden" name="id" value="' . $crnt_id . '">
                        <input type="text" id="e_name" name="e_name" value="' . $crnt_name . '"><br>
                        <select class="actions" name="p_name" id="p_name">
                            <option value="0">Projects</option>');
                $upd = 'SELECT DISTINCT p_id, p_name FROM projects LEFT JOIN employees ON projects.p_id = employees.pro_id';
                $upd_result = mysqli_query($conn, $upd);
                while ($row = mysqli_fetch_assoc($upd_result)) {
                    print('<option name="p_name" id="p_name" value="' . $row['p_id'] . '">' . $row['p_name'] . '</option>');
                }
                print('</select>
                        <button class="btn btn-primary" type="submit" name="update_name">Change</button>
                    </form>
                </div>');
            } else {
                print('<div>
                    <form class="actions" action="" method="POST">
                        <label for="e_name">To add new employee:</label><br>
                        <input type="text" id="e_name" name="e_name" placeholder="Employee name"><br>
                        <button class="btn btn-primary" type="submit" name="create_employee">Submit</button>
                    </form>
                </div>');
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </div>
</body>

</html>