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
          if( $data['NID'] == "" || $data['Ten'] == "" || $data['GT'] == "" ){
            header("Location: /admin.php?action=" . $_GET['action'] . "&type=" . $_GET['type'] . "&error=1");
            break;
          }
          $xml = parseXML("manguon.xml");
          $maxID = findMaxXML("manguon.xml", "ID") + 1;
          $manguon = $xml->addChild("MANGUON");
          $manguon->addChild("ID", $maxID);
          $manguon->addChild("NID", $data['NID']);
          $manguon->addChild("TEN", $data['Ten']);
          $manguon->addChild("GT", $data['GT']);
          
          saveXML("manguon.xml", $xml);
          break;
        case 'ngonngu':
          if( $data['Ten'] == "" ){
            header("Location: /admin.php?action=" . $_GET['action'] . "&type=" . $_GET['type'] . "&error=1");
            break;
          }
          $xml = parseXML("ngonngu.xml");
          $maxID = findMaxXML("ngonngu.xml", "ID") + 1;
          $ngonngu = $xml->addChild("NGONNGU");
          $ngonngu->addChild("ID", $maxID);
          $ngonngu->addChild("TEN", $data['Ten']);
          $ngonngu->addChild("GT", $data['GT']);
          
          saveXML("ngonngu.xml", $xml);
          break;
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
              
              if($_GET['list'] == 'manguon'){
                get_sources("manguon.xml");
              }else if($_GET['list'] == 'ngonngu'){
                get_sources("ngonngu.xml");
              }else if($_GET['action'] == 'edit'){
                if( ($_GET['id'] != null) ){
                  // Chỉnh sửa mã nguồn
                  $xml = findXML("manguon.xml", null, "ID", $_GET['id']);
                  echo manguon_edit_form($xml[0]);
                }
              }else if($_GET['action'] == 'add'){
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