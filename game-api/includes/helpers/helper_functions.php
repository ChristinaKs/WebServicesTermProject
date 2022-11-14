<?php

function getErrorUnsupportedFormat() {
    $error_data = array(
        "error:" => "unsuportedResponseFormat",
        "message:" => "The requested resource representation is available only in JSON."
    );
    return $error_data;
}


function makeCustomJSONError($error_code, $error_message) {
    $error_data = array(
        "error:" => $error_code,
        "message:" => $error_message
    );    
    return json_encode($error_data);
}