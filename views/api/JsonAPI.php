<?php
header( "Content-type: application/json; charset=utf-8");

$newData = [];
foreach( $data as $key => $value ) {
    if( gettype($value) == "string")
        $newData[urlencode($key)] = urlencode($value);
    else
        $newData[urlencode($key)] = $value;
}

echo urldecode(json_encode( $newData ));