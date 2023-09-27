<?php
namespace App\Helpers; 
use Config;

class Form {
    public static function show ($elements) {


        $xhtml = null;

        foreach ($elements as $element){
            // kiểm tra xem có tồn tại element: type hay không, nếu tồn tại thì ta lấy nó, còn ko sẽ để giá trị là input
            $type = isset($element['type']) ? $element['type'] : "input";
            if($type == 'input'){
                $xhtml .= sprintf('
                    <div class="form-group">
                        %s
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            %s
                        </div>
                    </div>', $element['label'], $element['element']
                );
            } else if($type == 'btn-submit') {
                $xhtml .= sprintf('
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            %s
                        </div>
                    </div>', $element['element']
                );
            }
        }
        return $xhtml; 
    }
}

