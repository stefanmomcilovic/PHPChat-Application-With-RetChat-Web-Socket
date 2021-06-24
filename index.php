<?php
require "models/UserModel.php";

if(isset($_SESSION['user_data'])) {
    header('location:chatroom.php');
}

if(isset($_POST['login'])) {
    $user_object = new UserModel();

    $user_object->setUserEmail($_POST['user_email']);
    $user_data = $user_object->get_user_data_by_email();

    if(is_array($user_data) && count($user_data) > 0) {
        if($user_data['user_status'] == 'Enable'){
            if($user_data['user_password'] == $_POST['user_password']) {
                $user_object->setUserId($user_data['user_id']);
                $user_object->setUserLoginStatus('Login');
                $user_token = md5(uniqid());
                $user_object->setUserToken($user_token);

                if($user_object->update_user_login_data()) {
                    $_SESSION['user_data'][$user_data['user_id']] = [
                        'id'    =>  $user_data['user_id'],
                        'name'  =>  $user_data['user_name'],
                        'profile'   =>  $user_data['user_profile'],
                        'token' =>  $user_token
                    ];

                    if($user_object->getUserLoginStatus() == "Login"){
                        header('Location: chatroom.php');
                    }

                }else{
                    $error = "Something went wrong";
                }

            }else{
                $error = 'Wrong Password';
            }
        }
    }else{
        $error = 'Wrong Email Address';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login on PHPChat Application with WebSocket</title>

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
            <div class="col-sm-12 text-center my-3">
                <?php
                if (isset($_SESSION['success_message'])) {
                    echo '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION["success_message"] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
                    unset($_SESSION['success_message']);
                }

                if (isset($error) && $error != '') {
                    echo '
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    ' . $error . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
                }
                ?>
            </div>
            <h1 class="text-center my-3">Login on PHPChat Application with WebSocket</h1>
            <div class="col-sm-6 border my-5 p-5">
                <form method="POST" id="login_form">
                    <div class="form-group my-3">
                        <label for="Email Address">Enter your email address:</label>
                        <input type="email" name="user_email" id="user_email" class="form-control" required>
                    </div>
                    <div class="form-group my-3">
                        <label for="Password">Enter your password</label>
                        <input type="password" name="user_password" id="user_password" class="form-control" required>
                    </div>
                    <div class="form-group text-center my-3">
                        <input type="submit" name="login" id="login" class="btn btn-primary" value="Login">
                    </div>
                </form>

                <p class="text-center lead">
                    <a class="nav nav-link" href="register.php">Register on PHPChat</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>