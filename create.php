<?php
include 'functions.php';

$notif = null;
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}else{
    $pdo = pdo_connect();
    if (!empty($_POST)) {
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $phone = $_POST['phone'];
        $phone = filter_var($phone, FILTER_SANITIZE_STRING);
        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        //validate input
        if(($name || $title) || !filter_var($email, FILTER_VALIDATE_EMAIL) || is_numeric($phone)){
                 $created = date('Y-m-d H:i:s');
                // Insert new record into the contacts table
                $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?)');
                $stmt->execute([$id, $name, $email, $phone, $title, $created]);
                header("location:index.php");
            }else{
                $notif = "Form tidak boleh ada yang kosong!";
            }

        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= style_script() ?>
    <title>Add new contact</title>
</head>

<body>
    <div class="container" style="margin-top:50px">
        <div class="row">
            <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add new contact</h5>
                        <form action="create.php" method="post">
                            <input class="form-control form-control-sm" placeholder="Type name" type="text" name="name" id="name" required><br>
                            <input class="form-control form-control-sm" placeholder="Email" type="text" name="email" id="email" required><br>
                            <input class="form-control form-control-sm" placeholder="Phone number" type="text" name="phone" id="phone" required><br>
                            <input class="form-control form-control-sm" placeholder="Title" type="text" name="title" id="title" required><br>
                            <div class="checkbox mb-3">
                                    <label>
                                        <?= $notif ?>
                                    </label>
                                </div>
                            <input class="btn btn-primary btn-sm" type="submit" value="Save">
                            <a href="index.php" type="button" class="btn btn-warning btn-sm">Cancel</a>
                        </form>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <p class="mt-5 mb-3 text-muted">hk &copy; 2021</p>
    </div>
</body>

</html>