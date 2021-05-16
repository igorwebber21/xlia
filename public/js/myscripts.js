

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


 function addToCart(){

 showModal('__cart');

};

function productTryOn(){
	 showModal('__productTryOn');
}


$(".search__button, .btn-search").click(function(){

	var search = $(this).siblings(".search__input").val();

	window.location.replace(sitename + "/?view=search&q=" + search);


	return false;
});



$(".counter-btn.__plus").click(function(){

	var input = $(this).siblings('.counter-input').find('input');
	
	$(this).siblings('.counter-btn.__minus').removeClass('__disabled');


	input.val(Number(input.val()) + 1);
	

	return false;
});

$(".counter-btn.__minus:not('__disabled')").click(function(){

	var input = $(this).siblings('.counter-input').find('input');
	var inputVal = Number(input.val());
	
	//$(this).siblings('.counter-btn.__minus').removeClass('__disabled');

	if(inputVal > 1){
    	input.val(inputVal - 1);

    	if(inputVal - 1 === 1){
    		$(this).addClass('__disabled');
    	}
	}
	

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



	 
})