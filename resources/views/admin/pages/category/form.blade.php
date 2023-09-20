<?php
    echo '<h3 style="color:red">ID: ' . $id . '</h3>';
    echo '<h3 style="color:red">TITLE: ' . $title . '</h3>';
    echo '<h3 style="color:red">SliderController - form </h3>';
    $linkList = route($controllerName)
    ?>

{{-- nút back để nó quay về trang danh sách --}}
<a href="<?php echo $linkList;?>">Back</a>