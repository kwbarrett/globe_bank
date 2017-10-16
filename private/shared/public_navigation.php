<?php
    $page_id = isset($page_id) ? $page_id : '';
    $subject_id = isset($subject_id) ? $subject_id : '';
?>


<navigation>
    <?php  $nav_subjects = find_all_subjects(); ?>
    <ul class="subjects">
        <?php while ($nav_subject = mysqli_fetch_assoc($nav_subjects)) { ?>
            <li class="<?php if($nav_subject['id'] == $subject_id){echo 'selected';}?>">
                <a href="<?= url_for('index.php?subject_id=' . h(u($nav_subject['id']))); ?>">
                    <?= h($nav_subject['menu_name']); ?>
                </a>
                <?php if($nav_subject['id'] == $subject_id){ ?>
                    <?php  $nav_pages = find_pages_by_subject_id($nav_subject['id']);?>
                    <ul class="pages">
                        <?php while ($nav_page = mysqli_fetch_assoc($nav_pages)) { ?>
                            <?php
                                if($nav_page['subject_id'] = $subject_id){
                            ?>
                            <li class="<?php if($nav_page['id'] == $page_id){echo 'selected';}?>">
                                <a href="<?= url_for('index.php?id=' . h(u($nav_page['id']))); ?>">
                                    <?= h($nav_page['menu_name']);?>
                                </a>
                            </li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                    <?php mysqli_free_result($nav_pages); ?>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
    <?php mysqli_free_result($nav_subjects); ?>
</navigation>
