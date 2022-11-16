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

// Helper function when POST, PUT, and DELETE requests are made
function makeCustomJSONsuccess($success_code, $success_message){
    $success_data = array(
        "Successful:" => $success_code,
        "Message:" => $success_message
    );
    return json_encode($success_data);
}