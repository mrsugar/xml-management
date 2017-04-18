<?php

session_start();

define('DATA_LIB', 'data/');
define('IMAGE_LIB', '/data/images/');

function is_logged(){
    return isset($_SESSION['isLogged']); 
}

function findXML_toString($source = NULL, $select = NULL, $where = NULL, $value = NULL){
    
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
    
    if( isset($_GET['nid']) ){
        $xml = findXML_toString("manguon.xml", null, "NID", $_GET['nid']);
    }else if( isset($_GET['id']) ){
        $xml = findXML_toString("manguon.xml", null, "ID", $_GET['id']);
    }
    /*else if( isset($_GET['s']) ){
        $xml = findXML_toString("manguon.xml", null, "TEN", $_GET['s']);
    }*/
    
    $html = '<div class="card-columns">';
    foreach($xml as $item){
        $html .=    '<div class="card" id="source-' . $item->ID . '">' .
                        '<div class="card-block">' .
                            '<a href="?id=' . $item->ID . '"><h4 class"card-title">' . $item->TEN . '</h4></a>' .
                            '<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>' .
                            '<p class="card-text"><small class="text-muted">' . findXML_toString("ngonngu.xml", "TEN", "ID", $item->NID) . '</small></p>' .
                        '</div>' .
                    '</div>';
    }
    $html .= '</div>';
    echo $html;
}
?>