<?php

if(!function_exists("responseCustom")) {
    function responseCustom($data = [], $status = false) {
        return [
            "status" => $status,
            "data"   => $data
        ];
    }
}