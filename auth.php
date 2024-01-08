<?php
include("db_config.php");
// Guest Login
if(isset($_POST['guest_user_no'])) {
    $mbr = substr($_POST['guest_user_no'], 1);
    $sql = "SELECT * FROM {$tblUsers} WHERE `user_no` = '" . $db->real_escape_string($mbr) . "'";
    if ($result = $db->query($sql)) {
        $user = $result->fetch_assoc();
        $result->free();
        if (!empty($user)) {
            $_SESSION['user_info'] = $user;
            $sql = " UPDATE {$tblUsers} SET last_login = NOW() WHERE id=" . $user['id'];
            $db->query($sql);
            header('Location: shift_settings.php');
        } else {
            $error = 'Wrong MBR.';
            printf("Error: %s\n", $error);
            exit;
        }
    } else {
        printf("Error: %s\n", $db->sqlstate);
        exit;
    }
}
// Admin Login
if(isset($_POST['email']) && isset($_POST['password'])) {
    $sql = "SELECT * FROM {$tblUsers} WHERE `email` = '" . $db->real_escape_string($_POST['email']) . "' AND `password` = '" . $db->real_escape_string($_POST['password']) . "'";
    if ($result = $db->query($sql)) {
        $user = $result->fetch_assoc();
        $result->free();
        if (!empty($user)) {
            $_SESSION['user_info'] = $user;
            $sql = " UPDATE {$tblUsers} SET last_login = NOW() WHERE id=" . $user['id'];
            $db->query($sql);
            header('Location: shift_settings.php');
        } else {
            $error = 'Wrong email or password.';
            printf("Error: %s\n", $error);
            exit;
        }
    } else {
        printf("Error: %s\n", $db->sqlstate);
        exit;
    }
}