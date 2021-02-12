<?php

    include 'action/configuration.php';

    $isError = "true";
    $title = "Authorization Failed !";
    $message = "Invalid authorization. User is not registered. Please complete your registration.";

    if(isset($_GET['token']) && $_GET['token'] != "") {

        $access_token = $_GET['token'];

        $current_time = date('Y-m-d h:i:s', time());

        $sql = "SELECT id, first_name, is_account_verified FROM app_user WHERE access_token = '".$access_token."'";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {

            $app_user_id = "";
            $name = "";
            $is_active = "";
            $is_account_verified = "";

            while ($row = $result->fetch_assoc()) {
                $app_user_id = $row["id"];
                $name = $row["first_name"];
                $is_account_verified = $row["is_account_verified"];
            }

            if($is_account_verified == "1") {

                $isError = "false";
                $title = "Already Verified";
                $message = "Your account is already verified. Please login.";

            } else {

                $sql = "UPDATE app_user SET is_account_verified = 1, modified = '".$current_time."' WHERE id = " . $app_user_id;
                mysqli_query($connection, $sql);

                $isError = "false";
                $title = "Congratulation";
                $message = "Your account has been verified. Login into your account.";

            }
        } 
    }
?>

<!DOCTYPE html>
<html>
<head><title>Account Verification</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
</head>
<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#FFA73B" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#FFA73B" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" valign="top"
                            style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-size: 20px; font-weight: 400; line-height: 48px;">

                            <?php if ($isError == "false") {?>
                                <h1><?php echo $title; ?></h1>
                                <img src="images/handshake.png" width="125" height="120" style="display: block; border: 0px;"/></td>
                            <?php } else if ($isError == "true") {?>
                                <h1 style="color: red;"><?php echo $title; ?></h1>
                            <?php } ?>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center"
                            style="padding: 20px 30px 40px 30px; color: #666666; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;"><?php echo $message; ?></p></td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>

                                                <?php if ($isError == "false") {?>
                                                    <td align="center" style="border-radius: 3px;" bgcolor="green">
                                                        <a href="<?php echo APP_BASE_URL."login.php"; ?>" target="_blank" style="font-size: 20px; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid green; display: inline-block;">
                                                            Login into your account</a>
                                                    </td>
                                                <?php } else if ($isError == "true") {?>
                                                    <td align="center" style="border-radius: 3px;" bgcolor="#f08080">
                                                        <a href="<?php echo APP_BASE_URL."login.php"; ?>" target="_blank" style="font-size: 20px; color: #ffffff; text-decoration: none;  padding: 15px 25px; border-radius: 2px; border: 1px solid #f08080; display: inline-block;">
                                                            Browse Website</a>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
</body>
</html>