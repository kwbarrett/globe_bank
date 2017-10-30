<?php
    //subjects

    function find_all_subjects($options=[]){
        global $db;

        $visible = isset($options['visible']) ? $options['visible'] : false;

        $sql = "select * from subjects ";
        if($visible){
            $sql .= "where visible = true ";
        }
        $sql .= "order by position ASC";
        //echo $sql;
        //exit;
        $result = mysqli_query($db,$sql);

        return $result;
    }

    function find_subject($id, $options=[]){
        global $db;

        $visible = isset($options['visible']) ? $options['visible'] : false;

        $sql = "select * from subjects ";
        $sql .= "where id = '" . db_escape($db,$id) ."' ";
        if($visible){
            $sql .= "and visible = true";
        }
        //echo $sql;
        //exit;
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
        $sql .= "'" .db_escape($db,$subject['menu_name']) . "',";
        $sql .= "'" .db_escape($db,$subject['position']) . "',";
        $sql .= "'" .db_escape($db,$subject['visible']) ."'";
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
        $sql .= "set menu_name = '" .db_escape($db,$subject['menu_name']) ."', ";
        $sql .= "position = '" .db_escape($db,$subject['position']). "', ";
        $sql .= "visible = '" .db_escape($db,$subject['visible']). "' ";
        $sql .= "where ";
        $sql .= "id = '" .db_escape($db,$id) . "' ";
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
        $sql .= "where id = '" . db_escape($db,$id) . "' ";
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

    //pages

    function find_all_pages(){
        global $db;

        $sql = "select p.id,p.menu_name, p.position,p.visible, s.menu_name as subject ";
        $sql .= "from pages as p ";
        $sql .= "join subjects s on p.subject_id = s.id ";

        $sql .= "order by p.subject_id ASC, p.position ASC";
        $result = mysqli_query($db,$sql);

        return $result;
    }

    function find_page_by_id($id,$options = []){
        global $db;

        $visible = isset($options['visible']) ? $options['visible'] : false;

        $sql = "select * from pages ";
        $sql .= "where id = '" . db_escape($db,$id) . "' " ;
        if($visible){
            $sql .= "and visible = true ";
        }

        $result = mysqli_query($db, $sql);
        confirm_result_set($result);

        $page = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $page;
    }

    function find_pages_by_subject_id($subject_id,$options=[]){
        global $db;

        $visible = isset($options['visible']) ? $options['visible'] : false;
        $sql = "select * from pages ";
        $sql .= "where subject_id = '" . db_escape($db,$subject_id) ."' ";
        if($visible){
            $sql .= "and visible = true ";
        }
        $sql .= "order by position ASC ";
        //echo $sql;
        //exit;
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);

        return $result;
    }

    function count_pages_by_subject_id($subject_id,$options=[]){
        global $db;

        $visible = isset($options['visible']) ? $options['visible'] : false;
        $sql = "select count(id) from pages ";
        $sql .= "where subject_id = '" . db_escape($db,$subject_id) ."' ";
        if($visible){
            $sql .= "and visible = true ";
        }

        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $row = mysqli_fetch_row($result);
        mysqli_free_result($result);
        $count = $row[0];

        return $count;
    }

    function update_page($id,$page){
        global $db;

        $errors = validate_page($page);

        if(!empty($errors)){
            return $errors;
        }

        $sql = "update pages ";
        $sql .= "set menu_name = '" .db_escape($db,$page['menu_name']) ."', ";
        $sql .= "subject_id = '" . db_escape($db,$page['subject_id']) . "', ";
        $sql .= "position = '" .db_escape($db,$page['position']) ."', ";
        $sql .= "visible = '" .db_escape($db,$page['visible']) ."',";
        $sql .= "content = '" .db_escape($db,$page['content']) . "' ";
        $sql .= "where id = '" . db_escape($db,$id) ."' ";
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
        $sql .= "where id = '" . db_escape($db,$id) . "' ";
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
        $sql .= "'" . db_escape($db,$page['menu_name']) . "', ";
        $sql .= "'" . db_escape($db,$page['subject_id']) . "', ";
        $sql .= "'" . db_escape($db,$page['position']) . "', ";
        $sql .= "'" . db_escape($db,$page['visible']) . "', ";
        $sql .= "'" . db_escape($db,$page['content']) . "' ";
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

      //admins
      function find_all_admins(){
          global $db;

          $sql = "select * ";
          $sql .= "from admins ";
          $sql .= "order by last_name ASC, first_name ASC";

          $result = mysqli_query($db,$sql);
          confirm_result_set($result);
          return $result;
      }

      function find_admin_by_id($id){
          global $db;

          $sql = "select * ";
          $sql .= "from admins ";
          $sql .= "where id = '" . db_escape($db,$id) . "' ";
          $sql .= "limit 1";

          $result = mysqli_query($db,$sql);
          confirm_result_set($result);
          $admin = mysqli_fetch_assoc($result);
          mysqli_free_result($result);
          return $admin;
      }

      function find_admin_by_username($username){
          global $db;

          $sql = "select * ";
          $sql .= "from admins ";
          $sql .= "where username = '" . db_escape($db,$username) . "' ";
          $sql .= "limit 1";

          $result = mysqli_query($db,$sql);
          confirm_result_set($result);
          $admin = mysqli_fetch_assoc($result);
          mysqli_free_result($result);
          return $admin;
      }

      function insert_admin($admin){
          global $db;

          $errors = validate_admin($admin);
          if(!empty($errors)){
              return $errors;
          }

          $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

          $sql = "insert into admins (first_name, last_name, email, username, hashed_password) ";
          $sql .= "values( ";
          $sql .= "'" . db_escape($admin['first_name']) . "', ";
          $sql .= "'" . db_escape($admin['last_name']) . "', ";
          $sql .= "'" . db_escape($admin['email']) . "', ";
          $sql .= "'" . db_escape($admin['username']) . "', ";
          $sql .= "'" . db_escape($hashed_password) . "' ";
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

      function update_admin($admin){
          global $db;

          $password_sent = !is_blank($admin['password']);

          $errors = validate_admin($admin, ['password_required' => $password_sent]);
        //   var_dump($errors);
        //   exit;
          if(!empty($errors)){
              return $errors;
          }

          $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

          $sql = "update admins set ";
          $sql .= "first_name = '" . db_escape($db,$admin['first_name']) . "', ";
          $sql .= "last_name = '" . db_escape($db,$admin['last_name']) . "', ";
          $sql .= "username = '" . db_escape($db,$admin['username']) . "', ";
          if($password_sent){
              $sql .= "hashed_password = '" . db_escape($db,$hashed_password) . "', ";
          }
          $sql .= "email = '" . db_escape($db,$admin['email']) . "' ";
          $sql .= "where id = '" . db_escape($db,$admin['id']) ."' ";
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

      function delete_admin($id){
          global $db;

          $sql = "delete from admins ";
          $sql .= "where id = '" . db_escape($db,$id) . "' ";
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

      function validate_admin($admin, $options=[]){
          //if options['password_required'] is passed in, then $password_required equals whatever was passed in. If not, we default $password_required to 'true'.
          $password_required = isset($options['password_required']) ? $options['password_required']:true;
          $errors = [];
          $current_id = isset($admin['id']) ? $admin['id']:'0';

          //first_name
          //cannot be blank and must be betweeen 2-255 characters
          if(!has_presence($admin['first_name'])){
              $errors[] = "First name cannot be blank";
          }
          if(!has_length($admin['first_name'], ['min' => 2, 'max' => 255])){
              $errors[] = "First name must be between 2 and 255 characters.";
          }

          //last_name
          //cannot be blank and must be betweeen 2-255 characters
          if(!has_presence($admin['last_name'])){
              $errors[] = "Last name cannot be blank";
          }
          if(!has_length($admin['last_name'], ['min' => 2, 'max' => 255])){
              $errors[] = "Last name must be between 2 and 255 characters.";
          }

          //email
          //cannot be blank, must be valid email format, max 255 characters
          if(!has_presence($admin['email'])){
              $errors[] = "Email cannot be blank";
          }
          if(!has_valid_email_format($admin['email'])){
              $errors[] = "Email must be of valid format.";
          }
          if(!has_length_less_than($admin['email'],255)){
              $errors[] = "Email cannot exceed 255 characters";
          }

          //username
          //cannot be blank, 8-255 characters, must be unique
          if(!has_presence($admin['username'])){
              $errors[] = "Username cannot be blank";
          }
          if(!has_length($admin['username'], ['min' => 8, 'max' => 255])){
              $errors[] = "Username must be between 2 and 255 characters.";
          }

          if(!has_unique_admin_username($admin['username'],$current_id)){
              $errors[] = "Username is already in use.";
          }

          if($password_required){
              //password
              //cannot be blank, 12+ characters, max 255 characters, 1 uppercase, 1 lowercase, 1 number, 1 symbol
              if(!has_length($admin['password'], ['min' => 12, 'max' => 255])){
                  $errors[] = "Password must be between 12 and 255 characters.";
              }
              if(!has_valid_password_requirements($admin['password'])){
                  $errors[] = "Password must contain at least 1 uppercase, 1 lowercase, 1 number, and 1 symbol.";
              }
              if($admin['password'] !== $admin['confirm_password']){
                  $errors[] = "Please confirm password.";
              }
          }

          return $errors;
      }

      function shift_subject_positions($start_pos, $end_pos, $current_id=0) {
  global $db;

  if($start_pos == $end_pos) { return; }

  $sql = "UPDATE subjects ";
  if($start_pos == 0) {
    // new item, +1 to items greater than $end_pos
    $sql .= "SET position = position + 1 ";
    $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
  } elseif($end_pos == 0) {
    // delete item, -1 from items greater than $start_pos
    $sql .= "SET position = position - 1 ";
    $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
  } elseif($start_pos < $end_pos) {
    // move later, -1 from items between (including $end_pos)
    $sql .= "SET position = position - 1 ";
    $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
    $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
  } elseif($start_pos > $end_pos) {
    // move earlier, +1 to items between (including $end_pos)
    $sql .= "SET position = position + 1 ";
    $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
    $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
  }
  // Exclude the current_id in the SQL WHERE clause
  $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";

  $result = mysqli_query($db, $sql);
  // For UPDATE statements, $result is true/false
  if($result) {
    return true;
  } else {
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

?>
