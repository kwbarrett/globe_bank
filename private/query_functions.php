<?php
    function find_all_subjects(){
        global $db;

        $sql = "select * from subjects order by position ASC";
        $result = mysqli_query($db,$sql);

        return $result;
    }

    function find_subject($id){
        global $db;

        $sql = "select * from subjects where id = '" . $id ."'";
        $result = mysqli_query($db,$sql);
        confirm_result_set($result);
        $subject = mysqli_fetch_assoc($result);
        return $subject;

    }

    function insert_subject($subject){
        global $db;

        $errors = validate_subject($subject);

        if(!empty($errors)){
            return $errors;
        }

        $sql = "insert into subjects (menu_name,position, visible) values(";
        $sql .= "'" .$subject['menu_name'] . "',";
        $sql .= "'" .$subject['position'] . "',";
        $sql .= "'" .$subject['visible'] ."'";
        $sql .= ")";

        $result = mysqli_query($db,$sql);
        if($result){
            return true;
        }else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_subject($id,$subject){
        global $db;

        $errors = validate_subject($subject);

        if(!empty($errors)){
            return $errors;
        }

        $sql = "update subjects ";
        $sql .= "set menu_name = '" .$subject['menu_name'] ."', ";
        $sql .= "position = '" .$subject['position']. "', ";
        $sql .= "visible = '" .$subject['visible']. "' ";
        $sql .= "where ";
        $sql .= "id = '" .$id . "' ";
        $sql .= "limit 1";

        //echo $sql;
        $result = mysqli_query($db,$sql);
        if($result){
            return true;
        }else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_subject($id){
        global $db;

        $sql = "delete from subjects ";
        $sql .= "where id = '" . $id . "' ";
        $sql .= "limit 1";

        $result = mysqli_query($db,$sql);
        if($result){
            return true;
        }else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }

    }

    function find_all_pages(){
        global $db;

        $sql = "select p.id,p.menu_name, p.position,p.visible, s.menu_name as subject ";
        $sql .= "from pages as p ";
        $sql .= "join subjects s on p.subject_id = s.id ";
        $sql .= "order by p.subject_id ASC, p.position ASC";
        $result = mysqli_query($db,$sql);

        return $result;
    }

    function find_page_by_id($id){
        global $db;

        $sql = "select p.id,p.menu_name, p.position,p.visible, p.subject_id,p.content, s.menu_name as subject ";
        $sql .= "from pages as p ";
        $sql .= "join subjects s on p.subject_id = s.id ";
        $sql .= "where p.id = '" . $id . "'";

        $result = mysqli_query($db, $sql);
        confirm_result_set($result);

        $page = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $page;
    }

    function update_page($id,$page){
        global $db;

        $errors = validate_page($page);

        if(!empty($errors)){
            return $errors;
        }

        $sql = "update pages ";
        $sql .= "set menu_name = '" .$page['menu_name'] ."', ";
        $sql .= "subject_id = '" . $page['subject_id'] . "', ";
        $sql .= "position = '" .$page['position'] ."', ";
        $sql .= "visible = '" .$page['visible'] ."',";
        $sql .= "content = '" .$page['content'] . "' ";
        $sql .= "where id = '" . $id ."' ";
        $sql .= "limit 1";

        $result = mysqli_query($db,$sql);
        if($result){
            return true;
        }else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }


    }

    function delege_page($id){
        global $db;

        $sql = "delete from pages ";
        $sql .= "where id = '" . $id . "' ";
        $sql .= "limit 1";

        $result = mysqli_query($db,$sql);
        if($result){
            return true;
        }else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }




    }

    function insert_page($page){
        global $db;

        $errors = validate_page($page);

        if(!empty($errors)){
            return $errors;
        }

        $sql = "insert into pages (menu_name,subject_id, position, visible, content) values( ";
        $sql .= "'" . $page['menu_name'] . "', ";
        $sql .= "'" . $page['subject_id'] . "', ";
        $sql .= "'" . $page['position'] . "', ";
        $sql .= "'" . $page['visible'] . "', ";
        $sql .= "'" . $page['content'] . "' ";
        $sql .= ")";

        $result = mysqli_query($db,$sql);
        if($result){
            return true;
        }else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function validate_subject($subject) {

      $errors = [];

      // menu_name
      if(is_blank($subject['menu_name'])) {
        $errors[] = "Name cannot be blank.";
      }
      if(!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
      }

      // position
      // Make sure we are working with an integer
      $postion_int = (int) $subject['position'];
      if($postion_int <= 0) {
        $errors[] = "Position must be greater than zero.";
      }
      if($postion_int > 999) {
        $errors[] = "Position must be less than 999.";
      }

      // visible
      // Make sure we are working with a string
      $visible_str = (string) $subject['visible'];
      if(!has_inclusion_of($visible_str, ["0","1"])) {
        $errors[] = "Visible must be true or false.";
      }

      return $errors;
    }

    function validate_page($page){
        $errors = [];
        // menu_name
        if(is_blank($page['menu_name'])) {
          $errors[] = "Name cannot be blank.";
        }
        if(!has_length($page['menu_name'], ['min' => 2, 'max' => 255])) {
          $errors[] = "Name must be between 2 and 255 characters.";
        }

        $current_id = isset($page['id']) ? $page['id']:'0';
        
        if(!has_unique_page_menu_name($page['menu_name'],$current_id)){
            $errors[] = "Name is already in use.";
        }

        // position
        // Make sure we are working with an integer
        $postion_int = (int) $page['position'];
        if($postion_int <= 0) {
          $errors[] = "Position must be greater than zero.";
        }
        if($postion_int > 999) {
          $errors[] = "Position must be less than 999.";
        }

        // visible
        // Make sure we are working with a string
        $visible_str = (string) $page['visible'];
        if(!has_inclusion_of($visible_str, ["0","1"])) {
          $errors[] = "Visible must be true or false.";
        }

        //subject
        // Make sure a subject has been selected
        $subject_id_int = (int) $page['subject_id'];
        if(!has_presence($subject_id_int)){
            $errors[] = "Subject must be selected.";
        }

        if(is_blank($page['subject_id'])){
            $errors[] = "Subject must be selected.";
        }

        //content
        //make sure some content has been entered.
        if(is_blank($page['content'])){
            $errors[] = "Content cannot be blank.";
        }

        return $errors;
      }


?>
