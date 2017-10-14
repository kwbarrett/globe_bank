<?php require_once('../../../private/initialize.php'); ?>

<?php
    $id = isset($_GET['id']) ? $_GET['id'] : '1';

    $sql = "select * from subjects where id = '" . $id ."'";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);

    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

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
    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
