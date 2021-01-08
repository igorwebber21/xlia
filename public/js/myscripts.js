$(function(){
	
	$("#main-menu-btn").click(function(){
		$("body").addClass('open-panel');
	});

    // =========== input phone checker ================== //
    $("body .phone-checker").mask("+38 (999) 999-99-99", {autoclear: false});
    $(".phone-checker").click(function(){
        $(this).focus();
    });


/* ==========================================  Order - cart ===================================================================*/
    // =========== orderForm validator ================== //
    $('body #orderForm').validator();

    // =========== nova poshta - cities ================== //
    $("#userCity").bind("click keyup", function() {

            var userCitySearch = $('#userCity').val();
            console.log(userCitySearch);

            $.ajax({
                url: '/novaPoshta/searchSettlements',
                data: {userCitySearch: userCitySearch},
                type: 'GET',
                success: function(res){

                    var result = JSON.parse(res);
                    console.log(result);

                    var userCityDropdown = '';

                    if(result !== "no-results" && result.length !== 0){
                        for (let t=0; t<result.length; t++){
                            userCityDropdown += "<li><a href='#' data-delivery=\"" + result[t]['DeliveryCity'] + "\"=\"" + result[t]['Number'] + "\" class='np-settlement'>" + result[t]['Present'] + "</a></li>";
                        }
                        console.log(result);

                        if(result !== '' && result !== null){
                            $("#userCityDropdown").html(userCityDropdown);
                            $("#userCity").dropdown('toggle');
                        }
                    }
                    else{
                        userCityDropdown = "<li><a href='#' class='np-settlement text-center no-results'>Нет результатов</a></li>";
                        $("#userCityDropdown").html(userCityDropdown);
                        $("#userCity").dropdown('toggle');
                    }

                },
                error: function(){
                    alert('Error!');
                }
            });
    });

    // =========== nova poshta - click to selected city ================== //
    $("#orderForm").on("click", "#userCityDropdown li a.np-settlement:not(.no-results)", function () {

        var npSettlement =  $(this).text();
        var npDeliveryCity = $(this).attr('data-delivery');

        $("#userCity").val(npSettlement);
        $(this).closest('.dropdown').removeClass('open');

        $('body #orderForm').validator('validate');

        $.ajax({
            url: '/novaPoshta/getWarehouses',
            data: {cityRef: npDeliveryCity},
            type: 'GET',
            success: function(res){

                var result = JSON.parse(res);

                var warehousesDropdown = '<option value="" readonly="readonly" selected>Не выбрано</option>';

                if(result !== "no-results")
                {
                    for (let t=0; t<result.length; t++){
                        var categoryOfWarehouse = "№" + result[t]['Number'];
                        if(result[t]['CategoryOfWarehouse'] === "Postomat"){
                            categoryOfWarehouse = "Почтомат " + "№" + result[t]['Number'];
                        }
                        warehousesDropdown += "<option value=\"" + categoryOfWarehouse + ", " + result[t]['ShortAddressRu'] + "\">"
                           + categoryOfWarehouse + ", " + result[t]['ShortAddressRu'] + "</option>";
                    }

                    if(result !== '' && result !== null){
                        $("#warehousesDropdown").html(warehousesDropdown);
                    }
                }
                else{
                }


            },
            error: function(){
                alert('Error!');
            }
        });

        return false;
    });


    $("#orderForm").submit(function () {

        var formData = new FormData($(this)[0]);

        $.ajax({
            type: 'POST',
            url: '/cart/checkout',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res){
                console.log('res', res);
               // var result = JSON.parse(res);
            },
            error: function(){
                alert('Error!');
            }
        });

        return false;
    });
/* ==========================================  Order - cart ===================================================================*/


/* ==========================================  Cart ===================================================================*/

    // функция динамического обновления корзины
    function showCartViews(result)
    {
        var returnedData = JSON.parse(result);
        $('#footer-cart-block').html(returnedData.cartFooter);
        $('#header-cart-block').html(returnedData.cartHeader);

        if(returnedData.cartIsEmpty === true)
        {
            $('#cart-content').html(returnedData.cartContent);
            $("#footer-cart-block").addClass('disable');
           // $("#orderForm").hide();
        }
        else{
            $('#cart-content .cart-table').html(returnedData.cartContent);
            $("#orderForm .cartTotalQty").text(returnedData.cartTotalQty);
            $("#orderForm .cartTotalSum").text(returnedData.cartTotalSum);
            $("#footer-cart-block").removeClass('disable');
           // $("#orderForm").show();
        }
    }

    // добавить в корзину (делегируем событие для нового контента на странице, которое загружается динамически AJAX-ом)
    $('body').on('click', '.add-to-cart', function(e){
        e.preventDefault();
        var id = $(this).data('id'),
            qty = $('.quantity input').val() ? $('.quantity input').val() : 1,
            mod = $('.available select').val();

        $.ajax({
            url: '/cart/add',
            data: {id: id, qty: qty, mod: mod},
            type: 'GET',
            success: function(res){
                showCartViews(res);
            },
            error: function(){
                alert('Ошибка! Попробуйте позже');
            }
        });
    });

    // удаление товара из корзины
    $('#header-cart-block, #cart-content').on('click', '.action.delete', function(){

        var id = $(this).data('id');
        //console.log(id);

        $.ajax({
            url: '/cart/delete',
            data: {id: id},
            type: 'GET',
            success: function(res){
                showCartViews(res);
            },
            error: function(){
                alert('Error!');
            }
        });

        return false;
    });

    // изменение количества товаров в корзине
    $('#header-cart-block, #cart-content').on('click', '.product-item-qty .icon', function() {

        var id = $(this).data('id');
        var qty = $(this).siblings('.cart-item-qty').val();
        var operation = $(this).hasClass('icon-minus') ? 'minus' : 'plus';

        $.ajax({
            url: '/cart/change',
            data: {id: id, qty: qty, operation: operation},
            type: 'GET',
            success: function(res){
                showCartViews(res);
            },
            error: function(){
                alert('Error!');
            }
        });

        return false;
    });

    // очистить корзину
    $('body').on('click', '.cart-clear-confirm', function() {

        $.ajax({
            url: '/cart/clear',
            type: 'GET',
            success: function(res){
                showCartViews(res);
                $("#clearCart .modal-body").html('<h3 class="text-center" style="margin-top: 20px;">Корзина успешно очищена</h3>');
            },
            error: function(){
                alert('Ошибка! Попробуйте позже');
            }
        });

        return false;
    });

    // вызов модального окна по очистке корзины
    $('#header-cart-block, #cart-content').on('click', '.cart-clear', function() {

        $("#clearCart").modal();
        return false;
    });

/* ==========================================  Cart ===================================================================*/



});