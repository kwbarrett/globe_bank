<?php require_once('../../../private/initialize.php'); ?>

<?php
    require_login();
    $admin_set = find_all_admins();
    // $admins = mysqli_fetch_assoc($admin_set);
    // mysqli_free_result($admin_set);
    $page_title = 'Admins';
?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
    <div class="admins listing">
        <h1>Admins</h1>
        <div class="actions">
            <a class="action" href="<?= url_for('/staff/admins/new.php'); ?>">Create New Admin</a>
        </div>
        <table class="list">
            <tbody>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th><br /></th>
                    <th><br /></th>
                    <th><br /></th>
                </tr>
                <?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
                    <tr>
                        <td><?= $admin['id'] ;?></td>
                        <td><?= $admin['first_name'] ;?></td>
                        <td><?= $admin['last_name'] ;?></td>
                        <td><?= $admin['email'] ;?></td>
                        <td><?= $admin['username'] ;?></td>
                        <td><a href="<?= url_for('/staff/admins/show.php?id=' . $admin['id']) ;?>">View</a></td>
                        <td><a href="<?= url_for('/staff/admins/edit.php?id=' . $admin['id']) ;?>">Edit</a></td>
                        <td><a href="<?= url_for('/staff/admins/delete.php?id=' . $admin['id']) ;?>">Delete</a></td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
     </div> <!-- end admins listing div -->
 </div> <!-- end content div -->
<?php include(SHARED_PATH . '/staff_header.php'); ?>
