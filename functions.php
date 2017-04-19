<?php

session_start();

define('DATA_LIB', 'data/');
define('IMAGE_LIB', '/data/images/');

function is_logged(){
    return isset($_SESSION['isLogged']); 
}

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

function findXML($source = NULL, $select = NULL, $where = NULL, $value = NULL){
    
    // SELECT $select FROM $source WHERE $where = $value;
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

function get_menu($source = NULL){
    // Nếu không truyền dữ liệu khác vào
    // Đọc file XML mặc định
    $xml = ($source == NULL) ? parseXML("ngonngu.xml") : parseXML($source);
                            
    // Phiên bản tới
    // Có container, container class và element, element class
    
    foreach($xml as $item){
        $html .= '<li class="nav-item">';
        $html .= '<a class="nav-link" href="?nid=' . $item->ID . '">' . $item->TEN . '</a>';
        $html .= '</li>';
    }
    
    echo $html;
}

function get_sources($source = NULL){
    $xml = ($source == NULL) ? parseXML("") : parseXML($source);
    $innerClass = 'fewer-text';
    
    if( isset($_GET['nid']) ){
        $xml = findXML("manguon.xml", null, "NID", $_GET['nid']);
    }else if( isset($_GET['id']) ){
        $xml = findXML("manguon.xml", null, "ID", $_GET['id']);
        $innerClass = '';
    }
    /*else if( isset($_GET['s']) ){
        $xml = findXML("manguon.xml", null, "TEN", $_GET['s']);
    }*/
    
    $html = '<div class="card-columns">';
    foreach($xml as $item){
        $ngonngu = findXML("ngonngu.xml", "TEN", "ID", $item->NID);
        $ngonngu_id = $item->NID;
        $html .=    '<div class="card" id="source-' . $item->ID . '">';
        $html .=        '<div class="card-block">' .
                            '<a href="?id=' . $item->ID . '"><h4 class"card-title">' . $item->TEN . '</h4></a>' .
                            '<p class="card-text ' . $innerClass . '">' . $item->GT . '</p>' .
                            '<p class="card-text"><a href="?nid=' . $ngonngu_id . '"><small class="text-muted">' . $ngonngu. '</small></a></p>' .
                        '</div>';
        if( is_logged() ) {
            $html .= '<div class="card-footer text-muted">'.
                        '<a href="/admin.php?id=' . $item->ID . '&action=edit">Chỉnh sửa</a>'.
                     '</div>';
        }
        $html .=    '</div>';
    }
    $html .= '</div>';
    echo $html;
}

// Admin function
function manguon_edit_form($xml){
    $html = '<form  method="POST">' .
    $html .=    '<div class="form-group">' .
                    '<label for="TenInput" class="form-control-label">Tên mã nguồn:</label>' .
                    '<input type="text" class="form-control" value="' . $xml->TEN . '" name="Ten" id="TenInput">' .
                '</div>';
    $html .=    '<div class="form-group">' .
                    '<label for="NgonNguInput" class="form-control-label">Ngôn ngữ:</label>' .
                    get_select_from_xml("ngonngu.xml", $xml->NID) .
                '</div>';
    $html .=    '<div class="form-group">' .
                    '<label for="GioiThieuInput" class="form-control-label">Giới thiệu:</label>' .
                    '<textarea class="form-control" rows="6" value="' . $xml->TEN . '" name="GT" id="GioiThieuInput">' . $xml->GT . '</textarea>' .
                '</div>';
    $html .=    '<div class="form-group btn-group">' .
                    '<button class="btn btn-success" name="submit">Thêm mới</button>' .
                    '<button class="btn btn-danger">Xóa</button>' .
                    '<button class="btn btn-default">Trở về</button>' .
                '</div>';
    $html .='</form>';
    return $html;
}

// Admin function
function get_select_from_xml($source = null, $selected = null){
    $xml = ($source == NULL) ? parseXML("ngonngu.xml") : parseXML($source);
    $html = '<select name="NID" class="form-control" id="SInput">';
    foreach($xml as $item){
        if( (string)$selected == $item->ID ){
            $html .= '<option selected="selected" value="' . $item->ID . '">' . $item->TEN . '</option>';
        }else {
            $html .= '<option value="' . $item->ID . '">' . $item->TEN . '</option>';
        }
    }
    $html .= '</select>';
    
    return $html;
}

function get_header(){
    require('header.php');
}

function get_footer(){
    require('footer.php');
}
?>