<?php

require_once('../../../private/initialize.php');
require_login();
if(!isset($_GET['id'])){
    redirect_to(url_for('/staff/admins/index.php'));
}

$id = $_GET['id'];
if(is_post_request()){
    $admin = [];
    $admin['id'] = $_GET['id'];
    $admin['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $admin['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $admin['email'] = isset($_POST['email']) ? $_POST['email'] : '';
    $admin['username'] = isset($_POST['username']) ? $_POST['username'] : '';
    $admin['password'] = isset($_POST['password']) ? $_POST['password'] : '';
    $admin['confirm_password'] = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    $result = update_admin($admin);
    if($result === true){
        $_SESSION['message'] = "Admin updated successfully!";
        redirect_to(url_for('/staff/admins/show.php?id=' .$admin['id']));
    }else{
        $errors = $result;
    }
}else{
    $admin = find_admin_by_id($id);
}
$page_title = "Edit Admin";
include(SHARED_PATH . '/staff_header.php');
?>

<div id="content">
    <a class="back_link" href="<?= url_for('/staff/admins/index.php')?>">&laquo; Back to list</a>
    <div class="admin edit">
        <h1>Edit Admin</h1>
        <?= display_errors($errors);?>
        <form action="<?= url_for('/staff/admins/edit.php?id=' . h(u($id)))?>" name="edit_admin" method="post">
            <dl>
                <dt>First Name</dt>
                <dd><input type="text" name="first_name" value="<?= $admin['first_name'] ;?>" /></dd>
            </dl>
            <dl>
                <dt>Last Name</dt>
                <dd><input type="text" name="last_name" value="<?= $admin['last_name'] ;?>" /></dd>
            </dl>
            <dl>
                <dt>Email</dt>
                <dd><input type="text" name="email" value="<?= $admin['email'] ;?>" /></dd>
            </dl>
            <dl>
                <dt>Username</dt>
                <dd><input type="text" name="username" value="<?= $admin['username'] ;?>" /></dd>
            </dl>
            <dl>
                <dt>Password</dt>
                <dd><input type="password" name="password" value="" /></dd>
            </dl>
            <dl>
                <dt>Confirm Password</dt>
                <dd><input type="password" name="confirm_password" /></dd>
            </dl>
            <p>
                Passwords should be at least 12 characters and contain at least 1 number, 1 uppercase letter, 1 lowercase letter, 1 number, and 1 symbol.
            </p>
            <div id="operations">
                <input type="submit" value="Edit Admin" />
            </div>
        </form>
    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php');?>
