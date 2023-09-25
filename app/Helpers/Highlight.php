<?php
namespace App\Helpers; 

class Highlight {
    public static function show($input, $paramsSearch, $field) {
        // echo '<pre style="color:red">';
        // print_r($paramsSearch); 
        // echo '</pre>';

        if($paramsSearch['value'] == "") return $input;
        if($paramsSearch['field'] == "all" || $paramsSearch['field'] == $field ) {
            //câu lệnh hightlight cho value đang search
            return preg_replace("/".preg_quote($paramsSearch['value'], "/")."/i", "<span class='highlight'>$0</span>", $input);
        }
        return $input;
    }
}

