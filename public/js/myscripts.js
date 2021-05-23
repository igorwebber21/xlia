

const sitename = location.protocol + "//" + location.hostname;


// ============================  mobile menu


const navExpand = [].slice.call(document.querySelectorAll('.nav-expand'));
const backLink = `<li class="nav-item">
	<a class="nav-link nav-back-link" href="javascript:;">
		Назад
	</a>
</li>`;

navExpand.forEach(item => {
  item.querySelector('.nav-expand-content').insertAdjacentHTML('afterbegin', backLink);
  item.querySelector('.nav-link').addEventListener('click', () => item.classList.add('active'));
  item.querySelector('.nav-back-link').addEventListener('click', () => item.classList.remove('active'));
});


// ---------------------------------------
// not-so-important stuff starts here

// const ham = document.querySelector('.hamburger');
// ham.addEventListener('click', function () {
//   document.body.classList.toggle('nav-is-toggled');
// });

// ============================== mobile menu


$('body').on('click', '.add-to-cart', function(e){

		 var id = $(this).attr('id').slice(5),
			 qty = $(this).closest('.product-order__row').find('.counter-field ').val(),
		   size = $('.modification__button.modification__button--active').text();

		 if(size === undefined || size.length === 0){
		 	alert('Пожалуйста, выберите размер!');
		 	return false;
		 }

		 $.ajax({
			 url: '/cart/add',
			 data: {id: id, qty: qty, mod: size},
			 type: 'GET',
			 success: function(res){
				 showModal('__cart');
				 showCartViews(res);
			 },
			 error: function(){
				 alert('Ошибка! Попробуйте позже');
			 }
		 });

}).on('click', ".counter-btn.__plus", function(){

	var prodData = $(this).attr('data-prod');
	var input = $(this).siblings('.counter-input').find('input');
	var result = Number(input.val()) + 1;

	$(this).siblings('.counter-btn.__minus').removeClass('__disabled');
	input.val(result);

	$.ajax({
		url: '/cart/change',
		data: {prodData: prodData, operation: 'plus'},
		type: 'GET',
		success: function(res){
			showCartViews(res);
		},
		error: function(){
			alert('Error!');
		}
	});

	return false;

}).on('click', ".counter-btn.__minus:not('__disabled')", function(){

	var prodData = $(this).attr('data-prod');
	var input = $(this).siblings('.counter-input').find('input');
	var inputVal = Number(input.val());

	if(inputVal > 1){
		var result = inputVal - 1;
		input.val(result);

		$.ajax({
			url: '/cart/change',
			data: {prodData: prodData, operation: 'minus'},
			type: 'GET',
			success: function(res){
				showCartViews(res);
			},
			error: function(){
				alert('Error!');
			}
		});

		if(inputVal - 1 === 1){
			$(this).addClass('__disabled');
		}
	}

	return false;
}).on('click', '.cart-remove-action', function(){

	var cartItemsCount = Number($("#cartItemsCount").val());

	if(cartItemsCount < 2){
		var res = confirm("Вы уверены, что хотите очистить корзину?");

		if(res !== true){
			return false;
		}
	}

	var id = $(this).attr('prod-id');

	$.ajax({
		url: '/cart/delete',
		data: {id: id},
		type: 'GET',
		success: function(res){

			var pageController = $("#pageController").val();

			if(pageController === 'Cart' && JSON.parse(res).cartItemsCount === 0){
				location.href = sitename;
			}
			else{
				showCartViews(res);
			}

		},
		error: function(){
			alert('Error!');
		}
	});

	return false;
});


// функция динамического обновления корзины
function showCartViews(result, jsonParse = 1)
{
	var returnedData = jsonParse ? JSON.parse(result) : result;

	$('#modalCartContent').html(returnedData.cartContent);
	$('#cartHeader').html(returnedData.cartHeader);
	$('#cartCheckout').html(returnedData.cartCheckout);
	$('#cartItemsCount').val(returnedData.cartItemsCount);
	$('#cartMobileCount').text(returnedData.cartTotalQty);

	return false;
}


$(".modification__button").click(function(){

	$(".modification__button").removeClass('modification__button--active');
	$(this).addClass('modification__button--active');

	return false;

});

function productTryOn(){

	 var productName = $("h1.product-title").text();

	 $("#productNameTryOn").text(productName);

	 showModal('__productTryOn');
}


$(".search__button, .btn-search").click(function(){

	var search = $(this).siblings(".search__input").val();
	window.location.replace(sitename + "/?view=search&q=" + search);

	return false;
});


// =========== input phone checker ================== //

$(".phone-checker").mask("+38 (999) 999-99-99", {autoclear: false});

$(".phone-checker").click(function(){

	$(this).focus();

});


$("#userLogin").submit(function () {

	var formData = new FormData($(this)[0]);

	$("#sign-in .form-errors").slideUp();

	$.ajax({
		type: 'POST',
		url: '/user/login',
		data: formData,
		beforeSend: function(){
			$("#sign-in .spinningSquaresLoader, #sign-in .bg-loader").removeClass('hide');
		},
		processData: false,
		contentType: false,
		dataType: "json",
		success: function(res){

			setTimeout(function () {

				$("#sign-in .spinningSquaresLoader, #sign-in .bg-loader").addClass('hide');

				if(res.status === 1)
				{
					window.location.replace(location.href);
				}
				else{
					$("#sign-in .form-errors").html(res.message).removeClass('hide').slideDown();
				}
			}, 1500);
		},
		error: function(){
			alert('Error!');
		}
	});

	return false;
});


$("#userRegister").submit(function () {

	var formData = new FormData($(this)[0]);

	$("#sign-in .form-errors").slideUp();

	$.ajax({
		type: 'POST',
		url: '/user/signup',
		data: formData,
		beforeSend: function(){
			$("#sign-in .spinningSquaresLoader, #sign-in .bg-loader").removeClass('hide');
		},
		processData: false,
		contentType: false,
		dataType: "json",
		success: function(res){

			setTimeout(function () {

				$("#sign-in .spinningSquaresLoader, #sign-in .bg-loader").addClass('hide');

				if(res.status === 1)
				{
					$("#j-popup-tab-signup").html("<div class=\"success-block\"><h1>" + res.message + "</h1></div>");
				}
				else{
					var mess = str_replace('Password', 'Поле "Пароль"', res.message);
					$("#sign-in .form-errors").html(mess).removeClass('hide').slideDown();
				}
			}, 1500);
		},
		error: function(){
			alert('Error!');
		}
	});

	return false;
});


$("#orderForm").submit(function () {

	var formData = new FormData($(this)[0]);

	$(".checkout-wrapp .form-errors").slideUp();

	$.ajax({
		type: 'POST',
		url: '/cart/checkout',
		data: formData,
		beforeSend: function(){
			$(".checkout-wrapp .spinningSquaresLoader, .checkout-wrapp .bg-loader").removeClass('hide');
		},
		processData: false,
		contentType: false,
		dataType: "json",
		success: function(res){
			setTimeout(function () {
				$(".checkout-wrapp .spinningSquaresLoader, .checkout-wrapp .bg-loader").addClass('hide');

				if(res.status === 1)
				{
					showCartViews(res.cart, 0);
					$(".wrapper .layout").html("<div class=\"success-order-block\">" + res.message + "</div>");
				}
				else{
					$(".checkout-wrapp .form-errors").html(res.message).removeClass('hide').slideDown();
				}
			}, 1500);
		},
		error: function(){
			alert('Error!');
		}
	});

	return false;
});



$("#recallForm").submit(function () {

	var formData = new FormData($(this)[0]);

	$("#call-me .form-errors").slideUp();

	$.ajax({
		type: 'POST',
		url: '/user/recall',
		data: formData,
		beforeSend: function(){
			$("#call-me .spinningSquaresLoader, #call-me .bg-loader").removeClass('hide');
		},
		processData: false,
		contentType: false,
		dataType: "json",
		success: function(res){
			setTimeout(function () {
				$("#call-me .spinningSquaresLoader, #call-me .bg-loader").addClass('hide');

				if(res.status === 1)
				{
					$("#call-me #recallForm").html("<div class=\"success-block text-center\">" + res.message + "</div>");
				}
				else{
					$("#call-me .form-errors").html(res.message).removeClass('hide').slideDown();
				}
			}, 1500);
		},
		error: function(){
			alert('Error!');
		}
	});

	return false;
});


$("#try-on-form").submit(function () {

	var formData = new FormData($(this)[0]);

	$("#product-try-on .form-errors").slideUp();

	$.ajax({
		type: 'POST',
		url: '/user/tryOn',
		data: formData,
		beforeSend: function(){
			$("#product-try-on .spinningSquaresLoader, #product-try-on .bg-loader").removeClass('hide');
		},
		processData: false,
		contentType: false,
		dataType: "json",
		success: function(res){
			setTimeout(function () {
				$("#product-try-on .spinningSquaresLoader, #product-try-on .bg-loader").addClass('hide');

				if(res.status === 1)
				{
					$("#product-try-on .try-on-body").html("<div class=\"success-block text-center\">" + res.message + "</div>");
				}
				else{
					$("#product-try-on .form-errors").html(res.message).removeClass('hide').slideDown();
				}
			}, 1500);
		},
		error: function(){
			alert('Error!');
		}
	});

	return false;
});


$("#passwordRecoveryForm").submit(function () {

	var formData = new FormData($(this)[0]);

	$("#password-recovery .form-errors").slideUp();

	$.ajax({
		type: 'POST',
		url: '/user/passwordRecovery',
		data: formData,
		beforeSend: function(){
			$("#password-recovery .spinningSquaresLoader, #password-recovery .bg-loader").removeClass('hide');
		},
		processData: false,
		contentType: false,
		dataType: "json",
		success: function(res){
			setTimeout(function () {
				$("#password-recovery .spinningSquaresLoader, #password-recovery .bg-loader").addClass('hide');

				if(res.status === 1)
				{
					$("#password-recovery .popup-body").html("<div class=\"success-block text-center\">" + res.message + "</div>");
				}
				else{
					$("#password-recovery .form-errors").html(res.message).removeClass('hide').slideDown();
				}
			}, 1500);
		},
		error: function(){
			alert('Error!');
		}
	});

	return false;
});



function showModal(popupClass){

 $("#modal-overlay").show();
 $(".popup." + popupClass).show();

}


function closeModal(elem){

 	$(elem).closest(".popup").hide();
	$("#modal-overlay").hide();

 	// $("html").removeClass('layout_fixed');
 	// $("body").css("paddingRight", 0);
}

$(function(){

	$('.hamburger').click(function(){
		$("body").toggleClass('nav-is-toggled');
	});


	$('#searchMobile').click(function(){
		
		if($(".search-mobile").hasClass('search-show'))
		{
			$(".search-mobile").removeClass('search-show').animate( {'top' : '-50px' }, 500 );
			$("#searchMobile").text('search');
		}
		else{
			$(".search-mobile").addClass('search-show').animate( {'top' : '52px' }, 500 );
			$("#searchMobile").text('close');
		}
	});

});