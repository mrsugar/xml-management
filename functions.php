<?php

define('DATA_LIB', 'data/');
define('IMAGE_LIB', 'data/images/');

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
                foreach($xml as $item){
                    if( (string)$value == $item->$where ){
                        return $item;
                    }
                }
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
        $html .= '<a class="nav-link" href="?bid=' . $item->ID . '">' . $item->TEN . '</a>';
        $html .= '</li>';
    }
    
    echo $html;
}

function get_source_deck($source = NULL, $source_id = NULL){
    $xml = ($source == NULL) ? parseXML("manguon.xml") : parseXML($source);

    $html = '<div class="card-deck">';
    foreach($xml as $item){
        $html .=    '<div class="card" id="source-' . $item->ID . '">' .
                        '<img class="card-img-top" src="' . IMAGE_LIB . $item->IMG . '" alt="' . $item->TEN . ' banner">' .
                        '<div class="card-block">' .
                            '<h4 class="card-title">' . $item->TEN . '</h4>' .
                            '<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>' .
                            '<p class="card-text"><small class="text-muted">' . findXML_toString("ngonngu.xml", "TEN", "ID", $item->SID) . '</small></p>' .
                        '</div>' .
                    '</div>';
    }
    $html .= '</div>';
    echo $html;
}
?>