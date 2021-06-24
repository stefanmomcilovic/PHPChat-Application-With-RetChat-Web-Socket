<?php
require('models/UserModel.php');
require("models/ChatRooms.php");

if (!isset($_SESSION['user_data'])) {
    header('location:index.php');
}

$chat_object = new ChatRooms;
$chat_data = $chat_object->get_all_chat_data();

$user_object = new UserModel;
$user_data = $user_object->get_user_all_data();
?>
<!DOCTYPE html>
<html>

<head>
    <title>PHPChat With WebSockets</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <style type="text/css">
        html,
        body {
            height: 100%;
            width: 100%;
            margin: 0;
        }

        #wrapper {
            display: flex;
            flex-flow: column;
            height: 100%;
        }

        #remaining {
            flex-grow: 1;
        }

        #messages {
            height: 200px;
            background: whitesmoke;
            overflow: auto;
        }

        #chat-room-frm {
            margin-top: 10px;
        }

        #user_list {
            height: 450px;
            overflow-y: auto;
        }

        #messages_area {
            height: 650px;
            overflow-y: auto;
            background-color: #e6e6e6;
        }
    </style>
</head>

<body>
    <div class="container">
        <br />
        <h1 class="text-center">PHPChat With WebSockets</h1>
        <br />
        <div class="row">

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col col-sm-6">
                                <h2>Chat Room</h2>
                            </div>
                            <div class="col col-sm-6 text-end">
                                <a href="privatechat.php" class="btn btn-warning btn-md">Private Chat</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="messages_area">
                        <?php
                        foreach ($chat_data as $chat) {
                            if (isset($_SESSION['user_data'][$chat['userid']])) {
                                $from = 'Me';
                                $row_class = 'row justify-content-start';
                                $background_class = 'text-dark alert-light';
                            } else {
                                $from = $chat['user_name'];
                                $row_class = 'row justify-content-end';
                                $background_class = 'alert-success';
                            }

                            echo '
                        <div class="' . $row_class . '">
                        	<div class="col-sm-10">
                        		<div class="shadow-sm alert ' . $background_class . '">
                        			<b>' . $from . ' - </b>' . $chat["msg"] . '
                        			<br />
                        			<div class="text-right">
                        				<small><i>' . $chat["created_on"] . '</i></small>
                        			</div>
                        		</div>
                        	</div>
                        </div>
                        ';
                        }
                        ?>
                    </div>
                </div>

                <form method="post" id="chat_form">
                    <div class="input-group mb-3">
                        <textarea class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" required></textarea>
                        <div class="input-group-append">
                            <button type="submit" name="send" id="send" class="btn btn-primary btn-lg"><i class="fa fa-paper-plane"></i></button>
                        </div>
                    </div>
                    <div id="validation_error"></div>
                </form>
            </div>
            <div class="col-lg-4">
                <?php

                $login_user_id = '';

                foreach ($_SESSION['user_data'] as $key => $value) {
                    $login_user_id = $value['id'];
                ?>
                    <input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $login_user_id; ?>" />
                    <div class="mt-3 mb-3 text-center">
                        <img src="<?php echo $value['profile']; ?>" width="150" class="img-fluid rounded-circle img-thumbnail" />
                        <h3 class="mt-2"><?php echo $value['name']; ?></h3>
                        <input type="button" class="btn btn-primary mt-2 mb-2" name="logout" id="logout" value="Logout" />
                    </div>
                <?php
                }
                ?>

                <div class="card mt-3">
                    <div class="card-header">User List</div>
                    <div class="card-body" id="user_list">
                        <div class="list-group list-group-flush">
                            <?php
                            if (count($user_data) > 0) {
                                foreach ($user_data as $key => $user) {
                                    $icon = '<i class="fa fa-circle text-danger"></i>';

                                    if ($user['user_login_status'] == 'Login') {
                                        $icon = '<i class="fa fa-circle text-success"></i>';
                                    }

                                    if ($user['user_id'] != $login_user_id) {
                                        echo '
                            		<a class="list-group-item list-group-item-action">
                            			<img src="' . $user["user_profile"] . '" class="img-fluid rounded-circle img-thumbnail" width="50" />
                            			<span class="ml-1"><strong>' . $user["user_name"] . '</strong></span>
                            			<span class="mt-2 float-right">' . $icon . '</span>
                            		</a>
                            		';
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Required for Message Server //
        var conn = new WebSocket('ws://localhost:8080');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };
        // When message is received
        conn.onmessage = function(e) {
            console.log(e.data);

            var data = JSON.parse(e.data);
            var row_class = '';
            var background_class = '';

            if (data.from == 'Me') {
                row_class = 'row justify-content-start';
                background_class = 'text-dark alert-light';
            } else {
                row_class = 'row justify-content-end';
                background_class = 'alert-success';
            }

            var html_data = "<div class='" + row_class + "'><div class='col-sm-10'><div class='shadow-sm alert " + background_class + "'><b>" + data.from + " - </b>" + data.msg + "<br /><div class='text-end'><small><i>" + data.dt + "</i></small></div></div></div></div>";

            $('#messages_area').append(html_data);

            $("#chat_message").val("");
        };
        // /Required for Message Server //
        // Sending Message to Server //
        $('#chat_form').on('submit', function(event) {
            event.preventDefault();

            var user_id = $('#login_user_id').val();
            var message = $('#chat_message').val();
            var data = {
                userId: user_id,
                msg: message
            };

            conn.send(JSON.stringify(data));
            $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

        });
        // /Sending Message to Server //

        $('#logout').click(function() {
            var user_id = $('#login_user_id').val();

            $.ajax({
                url: "action.php",
                method: "POST",
                data: {
                    user_id: user_id,
                    action: 'leave'
                },
                success: function(data) {
                    var response = JSON.parse(data);

                    if (response.status == 1) {
                        window.location.href = "index.php";
                    }
                }
            });

        });
    </script>
</body>

</html>