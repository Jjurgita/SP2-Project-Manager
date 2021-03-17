<?php include 'db_connection.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <style>
        .table {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <header>
        <div>
            Projects
        </div>
    </header>
    <div>
        <?php

        // DELETE
        if (isset($_POST['delete'])) {
        }

        // UPDATE
        if (isset($_POST['update'])) {
        }

        // SELECT query
        $sql = 'SELECT projects.p_id, projects.p_name, GROUP_CONCAT(CONCAT_WS("  " , employees.e_name) SEPARATOR ", ") 
                AS e_names FROM projects LEFT JOIN employees ON projects.p_id = employees.pro_id GROUP BY p_id';
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            print('<table class="table">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Employees</th>
                        <th>Actions</th>
                    </tr>');
            while ($row = mysqli_fetch_assoc($result)) {
                print('<tr>
                            <td>' . $row['p_id'] . '</td>
                            <td>' . $row['p_name'] . '</td>
                            <td>' . $row['e_names'] . '</td>
                            <td>
                                <form class="actions" action="" method="POST">
                                    <button type="submit" name="delete" value="" >Delete</button>
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