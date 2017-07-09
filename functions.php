<?php

session_start();

define('DATA_LIB', 'data/');

function is_logged(){
    return isset($_SESSION['isLogged']);
}

// Tìm giá trị ID lớn nhất trong cột $select của file $source
function findMaxXML($source = NULL, $select){
    $max = 0;
    if($source == NULL){
        return false;
    }else {
        if( file_exists(DATA_LIB . $source) ){
            $xml = ($source == NULL) ? false : parseXML($source);
            // Nếu có select trả về giá trị của node
            foreach($xml as $item){
                if( (int)$max < $item->$select ){
                    $max = $item->$select;
                }
            }
        }else {
            return false;
        }
    }
    return $max;
}

// Giả lâp câu truy vấn SQL
// SELECT $select FROM $source WHERE $where = $value;
function findXML($source = NULL, $select = NULL, $where = NULL, $value = NULL){
    if($source == NULL){
        return false;
    }else {
        if( file_exists(DATA_LIB . $source) ){
            $xml = ($source == NULL) ? false : parseXML($source);
            // Nếu có select trả về giá trị của node
            if($select != NULL){
                foreach($xml as $item){
                    if( (string)$value == $item->$where ){
                        return $item->$select;
                    }
                }
            }else {
                $result = array();
                foreach($xml as $item){
                    if( (string)$value == $item->$where ){
                        array_push($result, $item);
                    }
                }
                return $result;
            }
        }else {
            return false;
        }
    }
}

function parseXML($source = NULL){
    if($source == NULL){
        return false;
    }else {
        if( file_exists(DATA_LIB . $source) ){
            return simplexml_load_file(DATA_LIB . $source);
        }else {
            return false;
        }
    }
}

// Lấy menu là danh sách ngôn ngữ hiện có
function get_menu($source = NULL){
    // Nếu không truyền dữ liệu khác vào
    // Đọc file XML mặc định
    $xml = ($source == NULL) ? parseXML("ngonngu.xml") : parseXML($source);

    // Phiên bản tới
    // Có container, container class và element, element class

    foreach($xml as $item){
        $html .= '<li class="nav-item">';
        $html .= '<a class="nav-link" href="?nid=' . $item->id . '">' . $item->ten . '</a>';
        $html .= '</li>';
    }

    echo $html;
}

// Lấy danh sách mã nguồn đang có
function get_sources($source = NULL){
    $xml = ($source == NULL) ? parseXML("") : parseXML($source);
    $loai = str_replace('.xml', '', $source);
    $innerClass = 'fewer-text';

    if( isset($_GET['nid']) ){
        $xml = findXML("manguon.xml", null, "nid", $_GET['nid']);
    }else if( isset($_GET['id']) ){
        $xml = findXML("manguon.xml", null, "id", $_GET['id']);
        $innerClass = '';
    }
    // Phát triển chức năng tìm kiếm
    /*else if( isset($_GET['s']) ){
        $xml = findXML("manguon.xml", null, "ten", $_GET['s']);
    }*/

    $html = '<div class="card-columns">';
    foreach($xml as $item){
        $ngonngu = findXML("ngonngu.xml", "ten", "id", $item->nid);
        $ngonngu_id = $item->nid;
        $html .= '  <div class="card" id="source-' . $item->id . '">
                        <div class="card-block">
                          <a href="/?id=' . $item->id . '"><h4 class"card-title">' . $item->ten . '</h4></a>
                          <p class="card-text ' . $innerClass . '">' . $item->gt . '</p>
                          <p class="card-text"><a href="?nid=' . $ngonngu_id . '"><small class="text-muted">' . $ngonngu. '</small></a></p>
                        </div>';
        if( is_logged() ) {
            $html .= '  <div class="card-footer text-muted">
                          <a href="/admin.php?type=' . $loai . '&id=' . $item->id . '&action=edit">Chỉnh sửa</a> -
                          <a href="/admin.php?type=' . $loai . '&id=' . $item->id . '&action=delete">Xóa</a>
                        </div>';
        }
        $html .= '  </div>';
    }
    $html .= '</div>';
    echo $html;
}

// Admin function
// Hiển thị form chỉnh sửa mã nguồn
function manguon_edit_form($xml){
    $html = '<form  method="POST">
              <input type="hidden" value="' . $xml->id . '" name="id" id="TenInput">
              <div class="form-group">
                <label for="TenInput" class="form-control-label">Tên mã nguồn:</label>
                <input type="text" class="form-control" value="' . $xml->ten . '" name="ten" id="TenInput">
              </div>
              <div class="form-group">
                <label for="NgonNguInput" class="form-control-label">Ngôn ngữ:</label>' .
                  get_select_from_xml("ngonngu.xml", $xml->nid) .
              '</div>
              <div class="form-group">
                <label for="GioiThieuInput" class="form-control-label">Giới thiệu:</label>
                <textarea class="form-control" rows="6" value="' . $xml->ten . '" name="gt" id="GioiThieuInput">' . $xml->gt . '</textarea>
              </div>
              <div class="form-group btn-group">';
  if($xml == null){
      $html .=    '<button class="btn btn-success" name="submit">Thêm mới</button>';
  } else {
      $html .=    '<button class="btn btn-success" name="submit">Lưu</button>
                  <button class="btn btn-danger">Xóa</button>';
  }
  $html .=        '<a href="/admin.php?list=manguon" class="btn btn-secondary">Trở về</a>
              </div>
            </form>';
    return $html;
}

// Admin function
// Hiển thị form chỉnh sửa ngôn ngữ
function ngonngu_edit_form($xml){
    $html = '<form  method="POST">
              <input type="hidden" value="' . $xml->id . '" name="id" id="TenInput">
              <div class="form-group">
                <label for="TenInput" class="form-control-label">Tên ngôn ngữ:</label>
                <input type="text" class="form-control" value="' . $xml->ten . '" name="ten" id="TenInput">
              </div>
              <div class="form-group btn-group">';
    if($xml == null){
        $html .=    '<button class="btn btn-success" name="submit">Thêm mới</button>';
    } else {
        $html .=    '<button class="btn btn-success" name="submit">Lưu</button>
                    <button class="btn btn-danger">Xóa</button>';
    }
    $html .=        '<a href="/admin.php?list=ngonngu" class="btn btn-secondary">Trở về</a>
              </div>
            </form>';
    return $html;
}

// Admin function
// Trả về HTML select box từ file $source, selected = "selected" nếu trùng với ID item
function get_select_from_xml($source = null, $selected = null){
    $xml = ($source == NULL) ? parseXML("ngonngu.xml") : parseXML($source);
    $html = '<select name="nid" class="form-control" id="SInput">';
    foreach($xml as $item){
        if( (string)$selected == $item->id ){
            $html .= '<option selected="selected" value="' . $item->id . '">' . $item->ten . '</option>';
        }else {
            $html .= '<option value="' . $item->id . '">' . $item->ten . '</option>';
        }
    }
    $html .= '</select>';

    return $html;
}

// Admin function
// Lưu lại item trong XML
function saveXML($source, $xml){
    $output = new DOMDocument('1.0');
    $output->preserveWhiteSpace = false;
    $output->loadXML($xml->saveXML());
    $output->formatOutput = true;
    if($output->save(DATA_LIB . $source)){
        header("Location: /admin.php?action=" . $_GET['action'] . "&type=" . $_GET['type'] . "&message=1");
    }
}

// Admin function
// Xóa item trong XML
function deleteXML($source, $id){
    $xml = parseXML($source);
    $output = new DOMDocument;
    $output->preserveWhiteSpace = false;
    $output->loadXML($xml->saveXML());
    $output->formatOutput = true;

    $loai = str_replace('.xml', '', $source);
    $item = $output->documentElement->getElementsByTagname($loai);
    foreach($item as $dom){
        if ( (int)$dom->getElementsByTagname('id')->item(0)->nodeValue == $id ){
            $output->documentElement->removeChild($dom);
        }
    }

    if($output->save(DATA_LIB . $source)){
        header("Location: /admin.php?action=" . $_GET['action'] . "&type=" . $_GET['type'] . "&message=1");
    }
}

// Admin function
function editXML($source, $data){
    $xml = parseXML($source);
    $output = new DOMDocument;
    $output->preserveWhiteSpace = false;
    $output->loadXML($xml->saveXML());
    $output->formatOutput = true;

    $loai = str_replace('.xml', '', $source);
    $item = $output->documentElement->getElementsByTagname($loai);
    foreach($item as $dom){
        if ( (int)$dom->getElementsByTagname('id')->item(0)->nodeValue == $data['id'] ){
            foreach($data as $key => $value){
                if($key != 'submit'){
                    $replaceChild = $dom->getElementsByTagname($key)->item(0);
                    $replaceChild->nodeValue = $value;
                    $dom->replaceChild($replaceChild, $replaceChild);
                }
            }
        }
    }
    if($output->save(DATA_LIB . $source)){
        header("Location: /admin.php?action=" . $_GET['action'] . "&type=" . $_GET['type'] . "&id=" . $data['id'] . "&message=1");
    }
}

function get_header(){
    require(__DIR__ . '/template/header.php');
}

function get_footer(){
    require(__DIR__ . '/template/footer.php');
}
?>
