<?php

require('functions.php');

if(is_logged()):
  
  // Thêm mã nguồn
  if( isset($_POST['submit']) ){
    if(isset($_GET['action'])){
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
          
          $output = new DOMDocument('1.0');
          $output->preserveWhiteSpace = false;
          $output->loadXML($xml->saveXML());
          $output->formatOutput = true;
          if($output->save(DATA_LIB . "manguon.xml")){
            header("Location: /admin.php?action=" . $_GET['action'] . "&type=" . $_GET['type'] . "&message=1");
          }
          break;
      }
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
                echo manguon_edit_form($xml[0]);
              }
            }
            ?>
        </div>
    </div>
</main>

<?php

else:
  die();
endif;

?>