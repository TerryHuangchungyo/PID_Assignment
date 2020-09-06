<?php
header( "Content-type: application/json; charset=utf-8");

$newData = [];
foreach( $data as $row ) {
    $newRow = [];
    foreach( $row as $column => $value  ) {
        if( gettype($value) == "string")
            $newRow[urlencode($column)] = urlencode($value);
        else
            $newRow[urlencode($column)] = $value;
    }
    $newData[] = $newRow;
}

echo urldecode(json_encode( $newData ));