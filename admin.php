<?php

require('functions.php');

if(is_logged()):
  
  // Thêm mã nguồn
  if( isset($_POST['submit']) ){
    if(isset($_GET['action']) && $_GET['action'] == "add"){
      // Chỉ thực hiện khi là hành động add hoặc edit
      $data = $_POST;
      switch($_GET['type']){
        case 'manguon':
          if( $data['nid'] == "" || $data['ten'] == "" || $data['gt'] == "" ){
            header("Location: /admin.php?action=" . $_GET['action'] . "&type=" . $_GET['type'] . "&error=1");
            break;
          }
          $xml = parseXML("manguon.xml");
          $maxID = findMaxXML("manguon.xml", "id") + 1;
          $manguon = $xml->addChild("manguon");
          $manguon->addChild("id", $maxID);
          $manguon->addChild("nid", $data['nid']);
          $manguon->addChild("ten", $data['ten']);
          $manguon->addChild("gt", $data['gt']);
          
          saveXML("manguon.xml", $xml);
          break;
        case 'ngonngu':
          if( $data['ten'] == "" ){
            header("Location: /admin.php?action=" . $_GET['action'] . "&type=" . $_GET['type'] . "&error=1");
            break;
          }
          $xml = parseXML("ngonngu.xml");
          $maxID = findMaxXML("ngonngu.xml", "id") + 1;
          $ngonngu = $xml->addChild("ngonngu");
          $ngonngu->addChild("id", $maxID);
          $ngonngu->addChild("ten", $data['ten']);
          $ngonngu->addChild("gt", $data['gt']);
          
          saveXML("ngonngu.xml", $xml);
          break;
      }
    } else if(isset($_GET['action']) && $_GET['action'] == "edit"){
      if ($_GET['type'] == 'ngonngu'){
        editXML('ngonngu.xml', $_POST);
      } else {
        editXML('manguon.xml', $_POST);
      }
    }
  }
  if (isset($_GET['action']) && $_GET['action'] == "delete" && $_GET['confirm'] == 1){
    if ($_GET['type'] == 'ngonngu'){
      deleteXML("ngonngu.xml", $_GET['id']);
    } else {
      deleteXML("manguon.xml", $_GET['id']);
    }
  }
    
  
?>

<?php get_header(); ?>

<main>
    <div class="row">
        <div class="col-md-3">
            <h5>Menu</h5>
            <nav class="nav flex-column">
              <a class="nav-link active" href="?list=manguon">Danh sách mã nguồn</a>
              <a class="nav-link" href="?list=ngonngu">Danh sách ngôn ngữ</a>
            </nav>
            <nav class="nav flex-column">
              <a class="nav-link active" href="?action=add&type=manguon">Thêm mã nguồn</a>
              <a class="nav-link" href="?action=add&type=ngonngu">Thêm ngôn ngữ</a>
            </nav>
        </div>
        <div class="col-md-9">
            <?php 
            if(isset($_GET)){
              
              
              if($_GET['list'] == 'manguon'){
                get_sources("manguon.xml");
              }else if($_GET['list'] == 'ngonngu'){
                get_sources("ngonngu.xml");
                
              }else if($_GET['action'] == 'edit'){
                if( ($_GET['id'] != null) ){
                  if($_GET['error'] != null){
                    switch($_GET['error']){
                      case 1:
                        $err = 'Vui lòng điền đầy đủ nội dung cần thiết';
                        break;
                    }
                    echo '<div class="alert alert-danger" role="alert">' . $err . '</div>';
                  }else if($_GET['message'] != null){
                    switch($_GET['message']){
                      case 1:
                        $mess = 'Đã sửa nội dung thành công';
                        break;
                    }
                    echo '<div class="alert alert-success" role="alert">' . $mess . '</div>';
                  }
                  // Chỉnh sửa mã nguồn
                  switch($_GET['type']){
                    case 'manguon':
                      $xml = findXML("manguon.xml", null, "id", $_GET['id']);
                      echo manguon_edit_form($xml[0]);
                      break;
                    case 'ngonngu':
                      $xml = findXML("ngonngu.xml", null, "id", $_GET['id']);
                      echo ngonngu_edit_form($xml[0]);
                      break;
                  }
                }
              }else if($_GET['action'] == 'add'){
                if($_GET['error'] != null){
                  switch($_GET['error']){
                    case 1:
                      $err = 'Vui lòng điền đầy đủ nội dung cần thiết';
                      break;
                  }
                  echo '<div class="alert alert-danger" role="alert">' . $err . '</div>';
                }else if($_GET['message'] != null){
                  switch($_GET['message']){
                    case 1:
                      $mess = 'Đã thêm nội dung thành công';
                      break;
                  }
                  echo '<div class="alert alert-success" role="alert">' . $mess . '</div>';
                }
                switch($_GET['type']){
                  case 'manguon':
                    echo manguon_edit_form($xml[0]);
                    break;
                  case 'ngonngu':
                    echo ngonngu_edit_form($xml[0]);
                    break;
                }
              }else if($_GET['action'] == 'delete' && $_GET['confirm'] != 1){
                echo 'Bạn có chắc muốn xóa? <a href="admin.php?action=' . $_GET["action"] . '&type=' . $_GET["type"] . '&id=' . $_GET["id"] . '&confirm=1">Có</a>';
              }
            }
            ?>
        </div>
    </div>
</main>

<?php

get_footer(); 

else:
  header("Location: /");
endif;

?>