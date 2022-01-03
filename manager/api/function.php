<?php 
function err_messages($code, $message) {
    $arr = ['code' => $code, 'message' => $message];
    die(json_encode($arr));
}

function success_messages($id, $message) {
    $arr = ['code' => 0, 'message' => $message, 'id'=>$id];
    die(json_encode($arr));
}
?>