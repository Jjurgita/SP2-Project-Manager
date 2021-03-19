<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title>Project Manager</title>
</head>

<body>

    <header class="header">
        <div class="title">
            <h1>Sprint #2 - Project Manager</h1>
        </div>
        <div class="nav">
            <a href="?path=projects">Projects</a>
        </div>
        <div class="nav">
            <a href="?path=employees">Employees</a>
        </div>
    </header>
    <?php
    if (isset($_GET['path'])) {
        if ($_GET['path'] == 'projects') {
            print('<div class="tbl_name"><h2 class="tbl_name">Projects Table</h2></div>');
            include 'projects.php';
        } else if ($_GET['path'] == 'employees') {
            print('<div class="tbl_name"><h2 class="tbl_name">Employees Table</h2></div>');
            include 'employees.php';
        }
    }
    ?>
</body>

</html>