<?php include 'db_connection.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
</head>

<body>
    <div>
        Employees
    </div>
    <div>
        <?php
        // DELETE
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

        // UPDATE
        if (isset($_POST['update'])) {
        }

        // SELECT query
        $sql = 'SELECT DISTINCT e_id, e_name, p_name FROM employees LEFT JOIN projects ON employees.pro_id = projects.p_id';
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            print('<table class="table">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Projects</th>
                        <th>Actions</th>
                    </tr>');
            while ($row = mysqli_fetch_assoc($result)) {
                print('<tr>
                        <td>' . $row['e_id'] . '</td>
                        <td>' . $row['e_name'] . '</td>
                        <td>' . $row['p_name'] . '</td> 
                        <td>
                            <form class="actions" action="" method="POST">
                                <input type="hidden" name="id" value="' . $row['e_id'] . '">
                                <button type="submit" name="delete" value="' . $row['e_id'] . '">Delete</button>
                                <button type="submit" name="update" value="">Update</button>
                            </form>
                        </td>   
                    </tr>');
            }
            print('</table>');
        } else {
            echo "0 results";
        }

        $conn->close();

        ?>
    </div>
    <footer>
    </footer>
</body>

</html>