<?php 
$footer_script = '';

require_once 's.php';

require 'Db.class.php';

require 'SimpleXLSX.php';

function getId() {
    return str_replace('.', '', uniqid(rand(100,999),true));
}

function replace_constant($text){
    $db = new Db();
    $q1 = $db->query("SELECT * FROM constant");
    if(!empty($q1)){
        $cs = array_column($q1, 'constant_shortcode');
        $cc = array_column($q1, 'constant_content');
        $newtext = str_ireplace($cs, $cc, $text);
    } else {
        $newtext = $text;
    }
    return $newtext;
}
?>