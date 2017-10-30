<?php require_once('../../../private/initialize.php'); ?>
<?php
    require_login();
    $page_title = 'Show Admin';
    $id = isset($_GET['id']) ? $_GET['id']:'';
    $admin = find_admin_by_id($id);
?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
    <div class="admin show">
        <a class="back-link" href="<?= url_for('staff/admins/index.php'); ?>">&laquo; Back to List</a>
        <h1>Admin: <? echo $admin['first_name'] .' ' . $admin['last_name'] ;?></h1>
        <dl>
            <dt>Name</dt>
            <dd><?= h($admin['first_name'].' '.$admin['last_name']) ;?></dd>
        </dl>
        <dl>
            <dt>Email</dt>
            <dd><?= h($admin['email']) ;?></dd>
        </dl>
        <dl>
            <dt>Username</dt>
            <dd><?= h($admin['username']) ;?></dd>
        </dl>
    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
