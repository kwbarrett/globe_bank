<?php

require_once('../../../private/initialize.php');
require_login();
if(!isset($_GET['id'])){
    redirect_to(url_for('/staff/subjects/index.php'));
}
$id = $_GET['id'];
$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set);
mysqli_free_result($subject_set);

if (is_post_request()){
    $subject = [];
    $subject['menu_name'] = $_POST['menu_name'] ? $_POST['menu_name'] : '';
    $subject['position'] = $_POST['position'] ? $_POST['position'] : '';
    $subject['visible'] = $_POST['visible'] ? $_POST['visible'] : '0';
    $subject['start_pos'] = $_POST['start_pos'] ? $_POST['start_pos']: '0';

    $result = update_subject($id,$subject);
    $position = shift_subject_positions($subject['start_pos'], $subject['position'], $id);
    if($result === true){
        $_SESSION['message'] = "Subject updated successfully!";
        redirect_to(url_for('/staff/subjects/show.php?id=' . $id));
    }else{
        $errors = $result;
    }
}else{
    $subject = find_subject($id);
}



?>

<?php $page_title = 'Edit Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

    <div class="subject edit">
        <h1>Edit Subject</h1>

        <?= display_errors($errors);?>

        <form action="<?php echo url_for('/staff/subjects/edit.php?id=' . h(u($id))); ?>" method="post">
            <dl>
                <dt>Menu Name</dt>
                <dd><input type="text" name="menu_name" value="<?= $subject['menu_name']; ?>" /></dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <input type="hidden" name="start_pos" value="<?= $subject['position'] ;?>">
                    <select name="position">
                        <?php
                            for ($i=1; $i <= $subject_count; $i++) { ?>
                                <option value="<?= $i; ?>" <?= $i == $subject['position'] ? 'selected':''; ?>><?= $i; ?></option>
                            <?php } ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd>
                    <input type="hidden" name="visible" value="0" <?= h($subject['visible']) == 0 ? 'checked':'';?>/>
                    <input type="checkbox" name="visible" value="1" <?= h($subject['visible']) == 1 ? 'checked':'';?>/>
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Edit Subject" />
            </div>
        </form>
    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
