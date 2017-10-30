<?php
require_once('../../../private/initialize.php');
require_login();
$page_title = "New Admin";
include(SHARED_PATH . '/staff_header.php');

if(is_post_request()){
    $admin = [];
    $admin['first_name'] = $_POST['first_name'];
    $admin['last_name'] = $_POST['last_name'];
    $admin['email'] = $_POST['email'];
    $admin['username'] = $_POST['username'];
    $admin['password'] = $_POST['password'];
    $admin['confirm_password'] = $_POST['confirm_password'];

    $result = insert_admin($admin);
    if($result === true){
        $new_id = mysqli_insert_id($db);
        $_SESSION['message'] = "Admin created successfully!";
        redirect_to(url_for('/staff/admins/show.php?id=' . $new_id));
    }else{
        $errors = $result;
    }
}else{
    $admin = [];
    $admin['first_name'] = '';
    $admin['last_name'] = '';
    $admin['email'] = '';
    $admin['username'] = '';
    $admin['password'] = '';
    $admin['confirm_password'] = '';
}
?>

<div id="content">
    <a class="back_link" href="<?= url_for('/staff/admins/index.php')?>">&laquo; Back to list</a>
    <div class="admin new">
        <h1>New Admin</h1>
        <?= display_errors($errors);?>
        <form action="<?= url_for('/staff/admins/new.php')?>" name="new admin" method="post">
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
                <dd>
                    <input type="password" name="confirm_password" value="" /><br />
                    <p>(Must be at least 12 characters and contain at least 1 uppercase, 1 lowercase, 1 number, and 1 symbol.)</p>
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Create Admin" />
            </div>
        </form>
    </div>
</div>


<?php include(SHARED_PATH . '/staff_footer.php'); ?>
