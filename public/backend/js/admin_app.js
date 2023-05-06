$(document).ready(function () {

    // Declaration varible
    let avatar = $('.header__dashboard--avatar');
    let category = $('.category');
    let sidebarLi = $('.sidebar__li');
    let checkboxAll = $('#check__all');
    var checkboxItem = $('.check__item');
    var btnAction = $('input[name="btn-action"]');
    // var btnSearch = $('input[name="keyword"]');

    // Show Hide Tab Info
    if(isExist(avatar)) {
        avatar.click(function() {
            $(this).parents('.header__dashboard--infoUserTitle').next('.header__dashboard--showInfo').stop().slideToggle();
        });
    } 

    // CLick toggle sidebar li
    if(isExist(sidebarLi)) {
        sidebarLi.click(function (e) { 
            $(this).children('.sidebar__submenu--contain').stop().slideToggle();
        });
    }

    // Click slideToggle submenu category
    if(isExist(category)) {
        category.click(function () { 
            $(this).parents('.sidebar__submenu--categoryTitle').next('.sidebar__submenu--category').stop().slideToggle();
            return false;
        });
    }

    // Change checked all
    if(isExist(checkboxAll) && isExist(checkboxItem)) {
        checkboxAll.change(function() {
            let isCheckboxAll = $(this).prop('checked');
            checkboxItem.prop('checked', isCheckboxAll);
            if(isCheckboxAll === true) {
                btnAction.prop('disabled', false);
            } else {
                btnAction.prop('disabled', true);
            }
        });

        // Change checkboxitem 
        checkboxItem.change(function() {
            let checkAll = checkboxItem.length === $('input[name="check__item[]"]:checked').length;
            checkboxAll.prop('checked', checkAll);
            if($('input[name="check__item[]"]:checked').length === 0) {
                btnAction.prop('disabled', true);
            } else {
                btnAction.prop('disabled', false);
            }
        });
    }

    // Keyup submit form search
    // if(isExist(btnSearch)) {
    //     btnSearch.keyup(function(event) {
    //         if(event.keyCode === 13) {
    //             $('.header__dashboard--form').submit();
    //         }
    //     });
    // }

    // Generration slug keyup
    if(isExist($(".name__type"))) {
        $(".name__type").keyup(function() {
            let inputValue = $(this).val();
            let str1 = removeAccents(inputValue);
            let str2 = convertToSlug(str1).toLowerCase();
            $(".slug__type").val(str2);
        });
    }

    // Generation type keyup
    // if(isExist($(".card__type"))) {
    //     $(".card__type").keyup(function() {
    //         let inputValue = $(this).val();
    //         let str1 = removeAccents(inputValue);
    //         let str2 = convertToSlug(str1).toLowerCase();
    //         $("#type__hidden").val(str2);
    //     });
    // }


    // Handle Discount Price
    if($(".regular_price").length && $(".sale_price").length)
	{	
		$(".sale_price").keyup(function(){
			$(".regular_price").prop('disabled', false);
			var price = $(this).val();
			$(this).attr('value', price);
		});
		$(".sale_price").blur(function(){
			var key = $('.sale_price').attr('value');
			if(key>0){
				$(".regular_price").prop('disabled', false);
			} else {
				$(".regular_price").val(0);
				$(".regular_price").prop('disabled', true);
			}
		});
        
		$(".regular_price, .sale_price").keyup(function(){
			var regular_price = $('.regular_price').val();
			var sale_price = ($('.sale_price').length) ? $('.sale_price').val() : 0;
			var discount = 0;

			if(regular_price=='' || regular_price=='0' || sale_price=='' || sale_price=='0')
			{
				discount = 0;
			}
			else
			{
				regular_price = regular_price.replace(/,/g,"");
				sale_price = (sale_price) ? sale_price.replace(/,/g,"") : 0;
				regular_price = parseInt(regular_price);
				sale_price = parseInt(sale_price);
				
				if(sale_price < regular_price)
				{
					discount = 100-((sale_price * 100) / regular_price);
					discount = roundNumber(discount,0);
				}
				else
				{
					if($(".discount").length)
					{
						discount = 0;
					}
				}
				
			}

			if($(".discount").length)
			{
				$('.discount').val(discount);
			}
		});
    }

    ImgUpload();


    // Click check add noibat service
    if(isExist($('.show-checkbox'))) {
        $('.show-checkbox').change(function() {
            let id = $(this).data('id');
            let show = $(this).data('show');
            let $this = $(this);

            $.ajax({
				url: 'http://localhost/travelix_laravel/admin/service/state',
				method: 'POST',
				dataType: 'html',
				data: {
					id: id,
					show: show,
                    _token: $("input[name='_token']").val()
				},
				success: function()
				{
					if($this.is(':checked')) $this.prop('checked',false);
					else $this.prop('checked',true);
                    return false;
				},
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }  
			});
        });
    }


    // Click check add noibat category service
    if(isExist($('.show-checkbox-catservice'))) {
        $('.show-checkbox-catservice').change(function() {
            let id = $(this).data('id');
            let show = $(this).data('show');
            let $this = $(this);

            $.ajax({
				url: 'http://localhost/travelix_laravel/admin/category_service/state',
				method: 'POST',
				dataType: 'html',
				data: {
					id: id,
					show: show,
                    _token: $("input[name='_token']").val()
				},
				success: function()
				{
					if($this.is(':checked')) $this.prop('checked',false);
					else $this.prop('checked',true);
                    return false;
				},
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }  
			});
        });
    }


    // Click check add noibat news
    if(isExist($('.show-checkbox-news'))) {
        $('.show-checkbox-news').change(function() {
            let id = $(this).data('id');
            let show = $(this).data('show');
            let $this = $(this);

            $.ajax({
				url: 'http://localhost/travelix_laravel/admin/news/state',
				method: 'POST',
				dataType: 'html',
				data: {
					id: id,
					show: show,
                    _token: $("input[name='_token']").val()
				},
				success: function()
				{
					if($this.is(':checked')) $this.prop('checked',false);
					else $this.prop('checked',true);
                    return false;
				},
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }  
			});
        });
    }


    // Click check add noibat category news
    if(isExist($('.show-checkbox-catNew'))) {
        $('.show-checkbox-catNew').change(function() {
            let id = $(this).data('id');
            let show = $(this).data('show');
            let $this = $(this);

            $.ajax({
				url: 'http://localhost/travelix_laravel/admin/category_news/state',
				method: 'POST',
				dataType: 'html',
				data: {
					id: id,
					show: show,
                    _token: $("input[name='_token']").val()
				},
				success: function()
				{
					if($this.is(':checked')) $this.prop('checked',false);
					else $this.prop('checked',true);
                    return false;
				},
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }  
			});
        });
    }


    // Click check remove noibat service
    if(isExist($('.remove-checkbox'))) {
        $('.remove-checkbox').change(function() {
            let id = $(this).data('id');
            let $this = $(this);

            $.ajax({
				url: 'http://localhost/travelix_laravel/admin/service/remove_state',
				method: 'POST',
				dataType: 'html',
				data: {
					id: id,
                    _token: $("input[name='_token']").val()
				},
				success: function()
				{
					if($this.is(':checked')) $this.prop('checked',false);
					else $this.prop('checked',true);
                    return false;
				},
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }  
			});
        });
    }


    // Click check remove noibat news
    if(isExist($('.remove-checkbox-news'))) {
        $('.remove-checkbox-news').change(function() {
            let id = $(this).data('id');
            let $this = $(this);

            $.ajax({
				url: 'http://localhost/travelix_laravel/admin/news/remove_state',
				method: 'POST',
				dataType: 'html',
				data: {
					id: id,
                    _token: $("input[name='_token']").val()
				},
				success: function()
				{
					if($this.is(':checked')) $this.prop('checked',false);
					else $this.prop('checked',true);
                    return false;
				},
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }  
			});
        });
    }

    // Click check remove noibat category service
    if(isExist($('.remove-checkbox-catservice'))) {
        $('.remove-checkbox-catservice').change(function() {
            let id = $(this).data('id');
            let $this = $(this);

            $.ajax({
				url: 'http://localhost/travelix_laravel/admin/category_service/remove_state',
				method: 'POST',
				dataType: 'html',
				data: {
					id: id,
                    _token: $("input[name='_token']").val()
				},
				success: function()
				{
					if($this.is(':checked')) $this.prop('checked',false);
					else $this.prop('checked',true);
                    return false;
				},
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }  
			});
        });
    }


    // Click check remove noibat category new
    if(isExist($('.remove-checkbox-catNew'))) {
        $('.remove-checkbox-catNew').change(function() {
            let id = $(this).data('id');
            let $this = $(this);

            $.ajax({
				url: 'http://localhost/travelix_laravel/admin/category_news/remove_state',
				method: 'POST',
				dataType: 'html',
				data: {
					id: id,
                    _token: $("input[name='_token']").val()
				},
				success: function()
				{
					if($this.is(':checked')) $this.prop('checked',false);
					else $this.prop('checked',true);
                    return false;
				},
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }  
			});
        });
    }


    // Category load Ajax Service
    if(isExist($('.category_ajax'))) {
        $('.category_ajax').change(function() {
            let action = $(this).attr('id');
            let id = $(this).val();
            let result = '';
            if(action == 'category1')
            {
                result = 'category2';
            }
            $.ajax({
                url: "http://localhost/travelix_laravel/admin/service/edit_ajax",
                data: {action:action, id:id, _token: $("input[name='_token']").val(),},
                method: "POST",
                success: function(data) {
                    $('#'+result).html(data);
                    return false;
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        });
    }


    // Category load Ajax News
    if(isExist($('.category_ajax-new'))) {
        $('.category_ajax-new').change(function() {
            let action = $(this).attr('id');
            let id = $(this).val();
            let result = '';
            if(action == 'category_new1')
            {
                result = 'category_new2';
            }
            $.ajax({
                url: "http://localhost/travelix_laravel/admin/news/edit_ajax",
                data: {action:action, id:id, _token: $("input[name='_token']").val(),},
                method: "POST",
                success: function(data) {
                    $('#'+result).html(data);
                    return false;
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        });
    }
});