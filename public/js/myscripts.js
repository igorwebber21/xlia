$(function(){

    const sitename = location.protocol + "//" + location.hostname;
	
	$("#main-menu-btn").click(function(){
		$("body").addClass('open-panel');
	});

    // =========== input phone checker ================== //
    $("body .phone-checker").mask("+38 (999) 999-99-99", {autoclear: false});
    $(".phone-checker").click(function(){
        $(this).focus();
    });

    /* Search */
    var products = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            wildcard: '%QUERY',
            url: path + '/search/typeahead?query=%QUERY'
        }
    });

    products.initialize();

    $("#typeahead").typeahead({
        // hint: false,
        highlight: true
    },{
        name: 'products',
        display: 'title',
        limit: 10,
        source: products
    });

    $('#typeahead').bind('typeahead:select', function(ev, suggestion) {
        // console.log(suggestion);
        window.location = path + '/search/?s=' + encodeURIComponent(suggestion.title);
    });


/* ==========================================  Order - cart ===================================================================*/
    // =========== orderForm validator ================== //
    $('body #orderForm, body #orderFormQuick, body #registrationForm, body #authForm').validator();

    // =========== nova poshta - cities ================== //
    $("#userCity").bind("click keyup", function() {

            var userCitySearch = $('#userCity').val();
            console.log(userCitySearch);

            $.ajax({
                url: '/novaPoshta/searchSettlements',
                data: {userCitySearch: userCitySearch},
                beforeSend: function(){
                    $(".cityBlock label i.fa-refresh").removeClass('hide');
                },
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

                    $(".cityBlock label i.fa-refresh").addClass('hide');   

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
        $("#userCity").attr('data-delivery', npDeliveryCity);
        $("#warehousesDropdown").val('');

        getNovaPoshtaBranches(npDeliveryCity);

        $("#userCity").val(npSettlement);
        $(this).closest('.dropdown').removeClass('open');

        $('body #orderForm').validator('validate');



        return false;
    });


    function getNovaPoshtaBranches(npDeliveryCity)
    {
        var deliveryMethod = Number($("#orderForm #deliveryMethod").val());

        if(deliveryMethod === 1 && npDeliveryCity !== '' && npDeliveryCity != null){
            $.ajax({
                url: '/novaPoshta/getWarehouses',
                data: {cityRef: npDeliveryCity},
                beforeSend: function(){
                   $(".addressBlock label i.fa-refresh").removeClass('hide');
                },
                type: 'GET',
                success: function(res){

                    var result = JSON.parse(res);
                    var warehousesDropdown = '';

                    if(result !== "no-results")
                    {
                        for (let t=0; t<result.length; t++){
                            var categoryOfWarehouse = "№" + result[t]['Number'];
                            if(result[t]['CategoryOfWarehouse'] === "Postomat"){
                                categoryOfWarehouse = "Почтомат " + "№" + result[t]['Number'];
                            }
                            warehousesDropdown += "<li><a href='#'>" + categoryOfWarehouse + ", " + result[t]['ShortAddressRu'] + "</a></li>";
                        }

                        if(result !== '' && result !== null){
                            $("#dropdownMenuWarehouses").html(warehousesDropdown);
                        }

                        $(".addressBlock label i.fa-refresh").addClass('hide');

                        $("#dropdownMenuWarehouses").dropdown('toggle');
                    }
                    else{
                    }


                },
                error: function(){
                    alert('Error!');
                }
            });
        }
    }

    $("#dropdownMenuWarehouses").on("click", "li a", function (){
        var warehouse =  $(this).text();
        $("#warehousesDropdown").val(warehouse);
        $(this).closest('.dropdown').removeClass('open');
        $('body #orderForm').validator('validate');
        return false;
    });

    $("#warehousesDropdown").focus(function () {
        var npDeliveryCity = $("#userCity").attr('data-delivery');
        getNovaPoshtaBranches(npDeliveryCity);
    });

    $("#orderForm #deliveryMethod").change(function () {
        var deliveryType = $(this).find('option:selected').attr('data-type');
        var deliveryPrice = Number($(this).find('option:selected').attr('data-price'));
        $("#addressLabel").text(deliveryType);
        $("#warehousesDropdown").val('');

        // recalc cart sum
        var cartDeliveryPrice = Number($("#orderForm .cartDeliveryPrice").text());
        var cartTotalSum = Number($("#orderForm .cartTotalSum").text());
        var cartSum = Number(cartTotalSum - cartDeliveryPrice);

        $("#orderForm .cartDeliveryPrice").text(deliveryPrice);
        $("#orderForm .cartTotalSum").text(cartSum + deliveryPrice);

    });


    $("#orderForm").submit(function () {

        var formData = new FormData($(this)[0]);

        $("#cart-content .form-errors").slideUp();

        $.ajax({
            type: 'POST',
            url: '/cart/checkout',
            data: formData,
            beforeSend: function(){
                $("#cart-content .spinningSquaresLoader, #cart-content .bg-loader").removeClass('hide');
            },
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res){
                setTimeout(function () {
                    $("#cart-content .spinningSquaresLoader, #cart-content .bg-loader").addClass('hide');

                    if(res.status === 1)
                    {
                        showCartViews(res.cart, 0);
                        $("#cart-content").html("<div class=\"no-products-block\"><h1>" + res.message + "</h1></div>");
                    }
                    else{
                        $("#cart-content .form-errors").html(res.message).removeClass('hide').slideDown();
                    }
                }, 1500);
            },
            error: function(){
                alert('Error!');
            }
        });

        return false;
    });

    $("body").mouseup(function (e){ // событие клика по веб-документу
        var div = $('#warehousesDropdown, #userCityDropdown').closest('.dropdown'); // тут указываем ID элемента
        if (!div.is(e.target) && div.has(e.target).length === 0) { // и не по его дочерним элементам
            div.removeClass('open'); // скрываем его
        }
    });

    $("#orderFormQuick").submit(function () {

        var formData = new FormData($(this)[0]);

        $("#cart-content .form-errors").slideUp();

        $.ajax({
            type: 'POST',
            url: '/cart/checkoutQuick',
            data: formData,
            beforeSend: function(){
                $("#cart-content .spinningSquaresLoader, #cart-content .bg-loader").removeClass('hide');
            },
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res){
                setTimeout(function () {
                    $("#cart-content .spinningSquaresLoader, #cart-content .bg-loader").addClass('hide');

                    if(res.status === 1)
                    {
                        showCartViews(res.cart, 0);
                        $("#cart-content").html("<div class=\"no-products-block\"><h1>" + res.message + "</h1></div>");
                    }
                    else{
                        $("#cart-content .form-errors").html(res.message).removeClass('hide').slideDown();
                    }
                }, 1500);
            },
            error: function(){
                alert('Error!');
            }
        });

        return false;
    });
/* ==========================================  Order - cart ===================================================================*/


/* ==========================================  Registration  ===================================================================*/

// =========== nova poshta - select user city ================== //
    $("#registrationForm").on("click", "#userCityDropdown li a.np-settlement:not(.no-results)", function () {

        var npSettlement =  $(this).text();

        $("#userCity").val(npSettlement);
        $(this).closest('.dropdown').removeClass('open');

        $('body #registrationForm').validator('validate');

        return false;

    }).submit(function () {

        var formData = new FormData($(this)[0]);

        $("#registrationWrapp .form-errors").slideUp();

        $.ajax({
            type: 'POST',
            url: '/user/signup',
            data: formData,
            beforeSend: function(){
                $("#registrationWrapp .spinningSquaresLoader, #registrationWrapp .bg-loader").removeClass('hide');
            },
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res){

                setTimeout(function () {

                    $("#registrationWrapp .spinningSquaresLoader, #registrationWrapp .bg-loader").addClass('hide');

                    if(res.status === 1)
                    {
                        $("#registrationWrapp").html("<div class=\"no-products-block\"><h1>" + res.message + "</h1></div>");
                    }
                    else{
                        $("#registrationWrapp .form-errors").html(res.message).removeClass('hide').slideDown();
                    }
                }, 1500);
            },
            error: function(){
                alert('Error!');
            }
        });

        return false;
    });

    // authorization
    $("#authForm").submit(function () {

        var formData = new FormData($(this)[0]);

        $("#authWrapp .form-errors").slideUp();

        $.ajax({
            type: 'POST',
            url: '/user/login',
            data: formData,
            beforeSend: function(){
                $("#authWrapp .spinningSquaresLoader, #authWrapp .bg-loader").removeClass('hide');
            },
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res){

                setTimeout(function () {

                    $("#authWrapp .spinningSquaresLoader, #authWrapp .bg-loader").addClass('hide');

                    if(res.status === 1)
                    {
                        window.location.replace(location.href);
                    }
                    else{
                        $("#authWrapp .form-errors").html(res.message).removeClass('hide').slideDown();
                    }
                }, 1500);
            },
            error: function(){
                alert('Error!');
            }
        });

        return false;

    });

    // click on "Забыли пароль"
    $("#forgotPassword").on("click", function () {

        $("#authBlock").slideUp();
        $("#forgotPasswordBlock").removeClass('hide');
        $("#forgotPasswordBlock").slideDown();

        return false;
    });

    // click on "Войти на сайт"
    $("#forgotPasswordBack").on("click", function () {

        $("#forgotPasswordBlock").slideUp();
        $("#authBlock").removeClass('hide');
        $("#authBlock").slideDown();

        return false;
    });

    // отправить письмо с восстановлением пароля
    $("#forgotPasswordForm").submit(function () {

        var formData = new FormData($(this)[0]);

        $("#authWrapp .form-errors").slideUp();

        $.ajax({
            type: 'POST',
            url: '/user/passwordRecovery',
            data: formData,
            beforeSend: function(){
                $("#authWrapp .spinningSquaresLoader, #authWrapp .bg-loader").removeClass('hide');
            },
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res){

               // console.log('res', res);

                setTimeout(function () {

                    $("#authWrapp .spinningSquaresLoader, #authWrapp .bg-loader").addClass('hide');

                    if(res.status === 1)
                    {
                        $("#forgotPasswordForm").hide();
                        $("#forgotPasswordBlock .top-text").html(res.message);
                    }
                    else{
                        $("#authWrapp .form-errors").html(res.message).removeClass('hide').slideDown();
                    }
                }, 1500);
            },
            error: function(){
                alert('Error!');
            }
        });

        return false;

    });

/* ========================================== Registration===================================================================*/



/* ==========================================  Cabinet ===================================================================*/
$("#userInfoForm").submit(function () {

    var formData = new FormData($(this)[0]);

    $("#userInfo .form-errors, #userInfo .form-success").slideUp();

    $.ajax({
        type: 'POST',
        url: '/user/edit',
        data: formData,
        beforeSend: function(){
            $("#userCabinetPanel .spinningSquaresLoader, #userCabinetPanel .bg-loader").removeClass('hide');
        },
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(res){
            console.log(res);

            setTimeout(function () {

                $("#userCabinetPanel .spinningSquaresLoader, #userCabinetPanel .bg-loader").addClass('hide');

                if(res.status === 1)
                {
                    $("#userInfo .form-success").html(res.message).removeClass('hide').slideDown();

                    setTimeout(function () {
                        $("#userInfo .form-errors, #userInfo .form-success").slideUp();
                    }, 5000);
                }
                else{
                    $("#userInfo .form-errors").html(res.message).removeClass('hide').slideDown();
                }
            }, 1500);
        },
        error: function(){
            alert('Error!');
        }
    });

    return false;

}).on("click", "#userCityDropdown li a.np-settlement:not(.no-results)", function () {

    var npSettlement = $(this).text();

    $("#userCity").val(npSettlement);
    $(this).closest('.dropdown').removeClass('open');

    $('body #userInfoForm').validator('validate');

    return false;
});


$("#changePasswordForm").submit(function () {

    var formData = new FormData($(this)[0]);

    $("#userChangePassword .form-errors, #userChangePassword .form-success").slideUp();

    $.ajax({
        type: 'POST',
        url: '/user/changePassword',
        data: formData,
        beforeSend: function(){
            $("#userCabinetPanel .spinningSquaresLoader, #userCabinetPanel .bg-loader").removeClass('hide');
        },
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(res){
            console.log(res);

            setTimeout(function () {

                $("#userCabinetPanel .spinningSquaresLoader, #userCabinetPanel .bg-loader").addClass('hide');

                if(res.status === 1)
                {
                    $("#userChangePassword .form-success").html(res.message).removeClass('hide').slideDown();
                    $("#changePasswordForm")[0].reset();

                    setTimeout(function () {
                        $("#userChangePassword .form-errors, #userChangePassword .form-success").slideUp();
                    }, 5000);
                }
                else{
                    $("#userChangePassword .form-errors").html(res.message).removeClass('hide').slideDown();
                }
            }, 1500);
        },
        error: function(){
            alert('Error!');
        }
    });

    return false;

})


/* ==========================================  Cabinet ===================================================================*/




/* ==========================================  Cart ===================================================================*/

    // функция динамического обновления корзины
    function showCartViews(result, jsonParse = 1)
    {
        var returnedData = jsonParse ? JSON.parse(result) : result;
        $('#footer-cart-block').html(returnedData.cartFooter);
        $('#header-cart-block').html(returnedData.cartHeader);

        if(returnedData.cartIsEmpty === true)
        {
            $('#cart-content').html(returnedData.cartContent);
            $("#footer-cart-block").addClass('disable');
           // $("#orderForm").hide();
        }
        else{
            var cartDeliveryPrice =  Number($('#cart-content .cartDeliveryPrice').text());
            $('#cart-content .cart-table').html(returnedData.cartContent);
            $("#cart-content .cartTotalQty").text(returnedData.cartTotalQty);
            $("#cart-content .cartSum").text(returnedData.cartTotalSum);
            $("#cart-content .cartTotalSum").text(returnedData.cartTotalSum + cartDeliveryPrice);
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