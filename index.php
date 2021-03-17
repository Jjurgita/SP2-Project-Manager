<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Manager</title>
</head>

<body>

    <header>
        <div>
            <h1>Sprint #2 - Project Manager</h1>
        </div>
        <div>
            <a href="?path=projects">Projects</a>
        </div>
        <div>
            <a href="?path=employees">Employees</a>
        </div>
    </header>
    <?php
    if (isset($_GET['path'])) {
        if ($_GET['path'] == 'projects') {
            include 'projects.php';
        } else if ($_GET['path'] == 'employees') {
            include 'employees.php';
        }
    }
    ?>
</body>

</html>