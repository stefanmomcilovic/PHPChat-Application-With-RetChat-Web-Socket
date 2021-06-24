<?php
require_once('models/UserModel.php');

$error = '';
$success_message = '';

if (isset($_POST["register"])) {

    if (isset($_SESSION['user_data'])) {
        header('location:chatroom.php');
    }

    $user_object = new UserModel();

    $user_object->setUserName($_POST['user_name']);
    $user_object->setUserEmail($_POST['user_email']);
    $user_object->setUserPassword($_POST['user_password']);
    $user_object->setUserProfile($user_object->make_avatar(strtoupper($_POST['user_name'][0])));
    $user_object->setUserStatus('Enable');
    $user_object->setUserCreatedOn(date('Y-m-d H:i:s'));
    $user_object->setUserVerificationCode(md5(uniqid()));
    $user_data = $user_object->get_user_data_by_email();

    if (is_array($user_data) && count($user_data) > 0) {
        $error = 'This Email Already Register';
    } else {
        if ($user_object->save_data()) {
            $success_message = "Registration successful!";
        } else {
            $error = 'Something went wrong try again';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register on PHPChat Application with WebSocket</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="text-center my-3">PHPChat with WebSocket Registeration</h1>
            <div class="col-sm-6 border p-5 my-5">
                <form method="POST" id="register_from">
                    <div class="form-group my-3">
                        <label for="Name">Enter your name:</label>
                        <input type="text" class="form-control" name="user_name" id="user_name" required>
                    </div>

                    <div class="form-group my-3">
                        <label for="Name">Enter your email:</label>
                        <input type="email" class="form-control" name="user_email" id="user_email" required>
                    </div>

                    <div class="form-group my-3">
                        <label for="Name">Enter your password:</label>
                        <input type="password" class="form-control" name="user_password" id="user_password" required>
                    </div>

                    <div class="form-group my-3 text-center">
                        <input type="submit" value="Register" class="btn btn-primary" name="register">
                    </div>
                </form>

                <p class="text-center lead">
                    <a class="nav nav-link" href="index.php">Login on PHPChat</a>
                </p>
            </div>

            <div class="col-sm-12 text-center">
                <?php
                if ($error != '') {
                    echo '
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      ' . $error . '
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
                }

                if ($success_message != '') {
                    echo '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $success_message . '
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>