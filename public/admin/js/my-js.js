$(document).ready(function() {
    console.log('Hello world');

    let $btnSearch = $("button#btn-search");
    let $btnClearSearch = $("button#btn-clear-search");

    let $inputSearchField = $("input[name  = search_field]");
    let $inputSearchValue = $("input[name  = search_value]");

    // let $selectFilter     = $("select[name = select_filter]");
    // let $selectChangeAttr = $("select[name =  select_change_attr]");
    // let $selectChangeAttrAjax = $("select[name =  select_change_attr_ajax]");

    //js bắt sự kiện click vào ô select by...
    $("a.select-field").click(function(e) {
        e.preventDefault();

        let field = $(this).data('field');
        let fieldName = $(this).html();
        $("button.btn-active-field").html(fieldName + ' <span class="caret"></span>');
        $inputSearchField.val(field); // lấy field gán lại cho inputSearchField
    });

    $btnSearch.click(function() {

        var pathname = window.location.pathname; // lấy đường dẫn hiện tại 
        let params = ['filter_status'];
        let searchParams = new URLSearchParams(window.location.search);

        let link = "";
        $.each(params, function(key, param) { // param: filter_status
            if (searchParams.has(param)) {
                link += param + "=" + searchParams.get(param) + "&" //link: filter_status=active // lấy lại trạng thái hiện tại (active/ inactive/ tất cả) và gắn vào cho link để nó ko bị nhảy về toàn bộ các trạng thái (chỉ hiện the trạng thái mình đang lựa chọn)
            }
        });

        let search_field = $inputSearchField.val(); // cập nhật khi người dùng click vào ô search by ...
        let search_value = $inputSearchValue.val(); // giá trị mà người dùng nhập vào

        if (search_value.replace(/\s/g, "") == "") { //replace - xoá bỏ tất cả những khoảng trắng mà nó bằng rỗng -> hiện lên thông báo kêu người dùng nhập vào giá trị cần tìm
            alert("Nhập vào giá trị cần tìm!!");
        } else {
            window.location.href = pathname + "?" + link + 'search_field=' + search_field + '&search_value=' + search_value; //đẩy lên trên url 
            //window.location.href = pathname + "?" + link + 'search_field=' + search_field + '&search_value=' + search_value.replace(/\s+/g, '+').toLowerCase(); 
        }
    });

    $btnClearSearch.click(function() {
        var pathname = window.location.pathname;
        let searchParams = new URLSearchParams(window.location.search);

        params = ['filter_status'];

        let link = "";
        $.each(params, function(key, param) {
            if (searchParams.has(param)) {
                link += param + "=" + searchParams.get(param) + "&"
            }
        });

        window.location.href = pathname + "?" + link.slice(0, -1); //slice() hàm cắt chuỗi, dấu & cuối cùng bị dư thừa ta sẽ xoá nó đi 
    });

    //hiển thị hộp thoại hỏi người dùng có chắc muốn xoá phần tử đó đi hay không, nếu chắc mới xoá, còn không sẽ dừng quá trình lại¥
    $('.btn-delete').on('click', function() {
        if (!confirm('Bạn có chắc muốn xoá phần tử?'))
            return false;
    });

    // //Event onchange select filter
    // $selectFilter.on('change', function () {
    // 	var pathname	= window.location.pathname;
    // 	let searchParams= new URLSearchParams(window.location.search);

    // 	params 			= ['page', 'filter_status', 'search_field', 'search_value'];

    // 	let link		= "";
    // 	$.each( params, function( key, value ) {
    // 		if (searchParams.has(value) ) {
    // 			link += value + "=" + searchParams.get(value) + "&"
    // 		}
    // 	});

    // 	let select_field = $(this).data('field');
    // 	let select_value = $(this).val();
    // 	window.location.href = pathname + "?" + link.slice(0,-1) + 'select_field='+ select_field + '&select_value=' + select_value;
    // });

    // // Change attributes with selectbox
    // // $selectChangeAttr.on('change', function() {
    // // 	let item_id = $(this).data('id');
    // // 	let url = $(this).data('url');
    // // 	let csrf_token = $("input[name=csrf-token]").val();
    // // 	let select_field = $(this).data('field');
    // // 	let select_value = $(this).val();
    // //
    // // 	$.ajax({
    // // 		url : url,
    // // 		type : "post",
    // // 		dataType: "html",
    // // 		headers: {'X-CSRF-TOKEN': csrf_token},
    // // 		data : {
    // // 			id : item_id,
    // // 			field: select_field,
    // // 			value: select_value
    // // 		},
    // // 		success : function (result){
    // // 			if(result == 1)
    // // 				alert('Bạn đã cập nhật giá trị thành công!');
    // // 			else
    // // 				console.log(result)
    // //
    // // 		}
    // // 	});
    // // });

    // $selectChangeAttr.on('change', function() {
    // 	let select_value = $(this).val();
    // 	let $url = $(this).data('url');
    // 	window.location.href = $url.replace('value_new', select_value);
    // });

    // $selectChangeAttrAjax.on('change', function() {
    // 	let select_value = $(this).val();
    // 	let $url = $(this).data('url');
    // 	let csrf_token = $("input[name=csrf-token]").val();

    // 	$.ajax({
    // 		url : $url.replace('value_new', select_value),
    // 		type : "GET",
    // 		dataType: "json",
    // 		headers: {'X-CSRF-TOKEN': csrf_token},
    // 		success : function (result){
    // 			if(result) {
    // 				$.notify({
    // 					message: "Cập nhật giá trị thành công!"
    // 				}, {
    // 					delay: 500,
    // 					allow_dismiss: false
    // 				});
    // 			}else {
    // 				console.log(result)
    // 			}
    // 		}
    // 	});

    // });

    // //Init datepicker
    // $('.datepicker').datepicker({
    // 	format: 'dd-mm-yyyy',
    // });


    // //Confirm button delete item
    // $('.btn-delete').on('click', function() {
    // 	if(!confirm('Bạn có chắc muốn xóa phần tử?'))
    // 		return false;
    // });
});