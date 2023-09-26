<?php
namespace App\Helpers; 
use Config;

class Form {
    public static function show ($elements) { 
        $xhtml = null;

        foreach($elements as $element) {
            // echo '<pre style="color:red">';
            // print_r($elements); 
            // echo '</pre>';

            $xhtml .= sprintf('
            <div class="form-group">
    
                %s
                <div class="col-md-6 col-sm-6 col-xs-12">
                    %s
                </div>
            </div>',$element['label'], $element['element'] );

            // $xhtml .= sprintf('
            // <div class="form-group">
            //     <h1>%s</h1>
            // </div>', $element['label']);
        }

        return $xhtml;
    }
}

// <div class="form-group">
//     {!! $descriptionLable !!}
//     <div class="col-md-6 col-sm-6 col-xs-12">
//         {!! $descriptionInput !!}
//     </div>
// </div>
