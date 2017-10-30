<?php require_once('../../../private/initialize.php'); ?>

<?php
    require_login();
    $id = isset($_GET['id']) ? $_GET['id'] : '1';

    //$sql = "select * from subjects where id = '" . db_escape($db,$id) ."'";
    //$result = mysqli_query($db,$sql);
    //confirm_result_set($result);
    $subject = find_subject($id);
    $page_set = find_pages_by_subject_id($id);
    //$subject = mysqli_fetch_assoc($result);
    //mysqli_free_result($result);

    $page_title = 'Show Subject';
    include(SHARED_PATH . '/staff_header.php');
?>

<div id="content">
    <div class="subject show">
        <a class="back-link" href="<?= url_for('staff/subjects/index.php'); ?>">&laquo; Back to List</a>

        <h1>Subject: <?= h($subject['menu_name']);?></h1>
        <div class="attributes">
            <dl>
                <dt>
                    Menu Name
                </dt>
                <dd>
                    <?= h($subject['menu_name']); ?>
                </dd>
            </dl>
            <dl>
                <dt>
                    Position
                </dt>
                <dd>
                    <?= h($subject['position']);?>
                </dd>
            </dl>
            <dl>
                <dt>
                    Visible
                </dt>
                <dd>
                    <?= h($subject['visible']) == 1 ? 'true':'false'; ?>
                </dd>
            </dl>
        </div>

        <hr />
        <div class="pages listing">
            <h2>Pages</h2>
            <div class="actions">
                <a class="action" href="<?= url_for('/staff/pages/new.php?subject_id=' . h(u($subject['id']))); ?>">Create New Page</a>
            </div>
            <table class="list">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Position</th>
                        <th>Visible</th>
                        <th>Name</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                    <?php while($page = mysqli_fetch_assoc($page_set)) { ?>
                        <tr>
                            <td><?= h($page['id']); ?></td>
                            <td><?= h($page['position']);?></td>
                            <td><?= $page['visible'] == 1 ? 'true':'false';?></td>
                            <td><?= h($page['menu_name']);?></td>
                            <td><a href="<?= url_for('/staff/pages/show.php?id='.h(u($page['id']))); ?>">View</a></td>
                            <td><a target="_blank" href="<?= url_for('/index.php?preview=true&id='.h(u($page['id']))); ?>">Preview</a></td>
                            <td><a href="<?= url_for('/staff/pages/edit.php?id='.h(u($page['id']))); ?>">Edit</a></td>
                            <td><a href="<?= url_for('/staff/pages/delete.php?id='.h(u($page['id']))); ?>">Delete</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
                mysqli_free_result($page_set);
            ?>
        </div>
    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
