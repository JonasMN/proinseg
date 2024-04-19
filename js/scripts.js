let vh = window.innerHeight * 0.01;
document.documentElement.style.setProperty('--vh', `${vh}px`);

// window.addEventListener('resize', () => {
//   let vh = window.innerHeight * 0.01;
//   document.documentElement.style.setProperty('--vh', `${vh}px`);
// });

// Form Validation
function valForm(data) {

	// Fields
	for (var i = 0; i < data['fields'].length; i++) {

		var field_id = data['fields'][i].id;
		var field_required = data['fields'][i].required;
		var field_message = data['fields'][i].required_message;
		var field_filter = data['fields'][i].required_filter;
		var field_filter_message = data['fields'][i].required_filter_message;

		var valEmail = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		var valPhone = /^[0-9-]+$/;

		if (field_required) {

			if ($('form[id="'+ data.id+'"] [name="'+field_id+'"]').val() == '') {
				$('form[id="'+ data.id+'"] [name="'+field_id+'"]').addClass('is-invalid');
				if ($('form[id="'+ data.id+'"] [name="'+field_id+'"]').parent().find('.invalid-feedback').length == 0) {
					$('form[id="'+ data.id+'"] [name="'+field_id+'"]').parent().append('<div class="invalid-feedback">'+field_message+'</div>');
				}

				return false
			} else if(field_filter == 'phone' && !valPhone.test($('form[id="'+ data.id+'"] [name="'+field_id+'"]').val()) && $('form[id="'+ data.id+'"] [name="'+field_id+'"]').val().length < 5){
				$('form[id="'+ data.id+'"] [name="'+field_id+'"]').removeClass('is-invalid');
				$('form[id="'+ data.id+'"] [name="'+field_id+'"]').siblings().remove('.invalid-feedback');

				$('form[id="'+ data.id+'"] [name="'+field_id+'"]').addClass('is-invalid');
				if ($('form[id="'+ data.id+'"] [name="'+field_id+'"]').parent().find('.invalid-feedback').length == 0) {
					$('form[id="'+ data.id+'"] [name="'+field_id+'"]').parent().append('<div class="invalid-feedback">'+field_filter_message+'</div>');
				}
			
				return false;
			} else if(field_filter == 'email' && !valEmail.test($('form[id="'+ data.id+'"] [name="'+field_id+'"]').val())){
				$('form[id="'+ data.id+'"] [name="'+field_id+'"]').removeClass('is-invalid');
				$('form[id="'+ data.id+'"] [name="'+field_id+'"]').siblings().remove('.invalid-feedback');

				$('form[id="'+ data.id+'"] [name="'+field_id+'"]').addClass('is-invalid');
				if ($('form[id="'+ data.id+'"] [name="'+field_id+'"]').parent().find('.invalid-feedback').length == 0) {
					$('form[id="'+ data.id+'"] [name="'+field_id+'"]').parent().append('<div class="invalid-feedback">'+field_filter_message+'</div>');
				}

				return false;
			} else {
				$('form[id="'+ data.id+'"] [name="'+field_id+'"]').removeClass('is-invalid');
				$('form[id="'+ data.id+'"] [name="'+field_id+'"]').siblings().remove('.invalid-feedback');
			}

		}

	}

	// Captcha
	if (data['captcha']['enabled']) {

		var response = grecaptcha.getResponse();

		if(response.length == 0) {
			$('#captcha').addClass('is-invalid');
			if ($('#captcha').parent().find('.invalid-feedback').length == 0) {				
				$('#captcha').append('<div class="nocaptcha">'+data['captcha']['message']+'</div>');
			}

			return false
		} else {
			$('#captcha').removeClass('.is-invalid');
			$('#captcha').remove('.nocaptcha');
		}
	}

	return true;
}

// Form
function contactForm(data) {

	var form = $('form[id="'+data.id+'"]');

	$(form).submit(function(e) {
		e.preventDefault();

		if(valForm(data)){
			var formData = $(form).serialize();

			$.ajax({
				type: 'POST',
				url: $(form).attr('action'),
				data: formData
			}).done(function(response) {
				$(form).append('<div class="form-group col-12 mt-4 alert alert-success">'+data.thanks+'</div>');
				$(form).find($('.form-control')).val('');
			}).fail(function(data) {
				$(form).remove('alert-sucess');
			});
		}

	});
	
}


// Newsletter Form
function valNewsletterForm() {

	// Email
	 var testEmail = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if ($('#newsletterForm #newsletterEmail').val() == '') {
		$('#newsletterForm #newsletterEmail').addClass('is-invalid');
		if ($('#newsletterForm #newsletterEmail').parent().find('.invalid-feedback').length == 0) {
			$('#newsletterForm #newsletterEmail').parent().append('<div class="invalid-feedback">Debes ingresar un e-mail.</div>');
		}

		return false
	} else if(!testEmail.test($('#newsletterForm #newsletterEmail').val())) {
		$('#newsletterForm #newsletterEmail').removeClass('is-invalid');
		$('#newsletterForm #newsletterEmail').siblings().remove('.invalid-feedback');

		$('#newsletterForm #newsletterEmail').addClass('is-invalid');
		if ($('#newsletterForm #newsletterEmail').parent().find('.invalid-feedback').length == 0) {
			$('#newsletterForm #newsletterEmail').parent().append('<div class="invalid-feedback">El e-mail no es vÃ¡lido.</div>');
		}

		return false;
	} else if ($('#newsletterForm #newsletterEmail').val().length < 8) {
		$('#newsletterForm #newsletterEmail').addClass('is-invalid');
		if ($('#newsletterForm #newsletterEmail').parent().find('.invalid-feedback').length == 0) {
			$('#newsletterForm #newsletterEmail').parent().append('<div class="invalid-feedback">El e-mail es muy corto.</div>');
		}

		return
	} else {
		$('#newsletterForm #newsletterEmail').removeClass('is-invalid');
		$('#newsletterForm #newsletterEmail').siblings().remove('.invalid-feedback');
	}

	return true;
}

function newsletterForm() {
	var form = $('#newsletterForm');
	
	$(form).submit(function(e) {
		e.preventDefault();

		if(valNewsletterForm()){
			var formData = $(form).serialize();

			$.ajax({
				type: 'POST',
				url: $(form).attr('action'),
				data: formData
			}).done(function(response) {
				$(form).append('<div class="valid-feedback">Gracias por suscribirte</div>');
				$('#newsletterForm input').addClass('is-valid');
				$('#newsletterForm input').val('');
			}).fail(function(data) {
				$(form).remove('alert-sucess');
			});
		}
	});
}

/* Slides */
function slides() {









	// Single
	$('.single .relateds .slider .slides').on('init reInit beforeChange', function(event, slick, currentSlide, nextSlide){
	    var i = (nextSlide ? nextSlide : 0) + 1;
	    $('.single .relateds .arrows .count').text(i + '/' + slick.slideCount);
	});

	$('.single .relateds .slider .slides').slick({
		mobileFirst: true,
		dots: false,
		arrows: true,
        prevArrow: $('.single .relateds .arrows .prev'),
        nextArrow: $('.single .relateds .arrows .next'),
		adaptiveHeight: true,
		autoplay: true,
		pauseOnHover: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		centerMode: false,
		infinite: false,
		responsive: [
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 3
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 4
				}
			},
		]
	});


	$('.single .collections .slider .slides').on('init reInit beforeChange', function(event, slick, currentSlide, nextSlide){
	    var i = (nextSlide ? nextSlide : 0) + 1;
	    $('.single .collections .arrows .count').text(i + '/' + slick.slideCount);
	});

	$('.single .collections .slider .slides').slick({
		mobileFirst: true,
		dots: false,
		arrows: true,
        prevArrow: $('.single .collections .arrows .prev'),
        nextArrow: $('.single .collections .arrows .next'),
		adaptiveHeight: true,
		autoplay: true,
		pauseOnHover: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		centerMode: false,
		infinite: false,
		responsive: [
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 3
				}
			},
		]
	});

}

function sticky(){

	var scroll = $(window).scrollTop();

	if(scroll > 300){
		$('body, .header').addClass('fixed');
	} else {
		$('body, .header').removeClass('fixed');
	}
}


// Share Links Windows Fix
function shareWindowFix(){
	$('.share ul li a').click(function(e) {
		e.preventDefault();
		window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=600, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
		return false;
	});
}

// Data Open
function dataOpen() {

	width = $(window).width();

    // Menu
    $('[data-open="menu"]').click(function(e){
        e.preventDefault();

        $('.header').toggleClass('active');
        $('body').toggleClass('overh');
    });


    // Submenu
    $('[data-open="submenu-shop"]').click(function(e){
        
    });

	$('.submenu .close').click(function(e){
		e.preventDefault();

		$('body').removeClass('overh');
		$('.header .navigation .active').removeClass('active');
	});

    //if (width < 1200Â ) {

		$('[data-open="submenu-shop"]').click(function(e){
			e.preventDefault();

            if (!$(this).parent().hasClass('active')) {
	            $('body').removeClass('overh');
	            $('.header .navigation .menu li').removeClass('active');
            }

			$('body').toggleClass('overh');
	        $(this).parent().toggleClass('active');
        });

     //}else{

		// $('[data-open="submenu-shop"]').hover(function(e){
		// 	$('.header .navigation .menu li').removeClass('active');
		// 	$('body').addClass('overh');
  // 			$(this).parent().addClass('active');
  // 		});

  // 		$('.header .navigation .menu, .header .navigation .menu li .submenu').on('mouseleave', function(){
  // 			$('body').removeClass('overh');
		// 	$(this).parent().removeClass('active');
  // 		});
//    }


    // Submenu Search
    $('[data-open="search"]').click(function(e){
        e.preventDefault();

        $('.header').toggleClass('active-search');
        $('.header .search').toggleClass('active');
        $('.header .search .submenu').toggleClass('active');
        
    });

    if (width > 1200 ) {
		$('.header .account .search .submenu').on('mouseleave', function(){
			$(this).parent().removeClass('active');
		});
	}

    // Filter
    $('[data-open="filter"]').click(function(e){
        e.preventDefault();

        $('.filter').toggleClass('active');
    });

    // Login
    $('[data-open="login"]').click(function(e) {
    	if (islogged == 'no') {
    		e.preventDefault();
    		$('#modalLogin').modal('show');
    	}
    });

}

// Data Scroll
function dataScroll(){

    $('a[data-scroll]').on('click',function (e){
        e.preventDefault();

        var target = this.hash,
        $target = $(target);

        $('html, body').stop().animate({
            'scrollTop': $target.offset().top - 65
        }, 900, 'swing', function () {
            window.location.hash = target;
        });
    });

}

function filter(){

	// Pagination
    $('.archive.store .pagination a').click(function(e){
        e.preventDefault();

        var url = $(this).attr('href');
        if (url.indexOf("?") != -1) {
            paged = url.match(/paged=([0-9]+)/)[1];
        } else {
            paged = 1;
        }

        $('.filter [name="paged"]').val(paged);
        $('.filter').submit();
    });

	$('.filter select').bind('change', function(){
		$('.filter').submit();
	});
}

// Quantity
function quantity(){

    // Quantity Input
    $('.form-control-quantity').each(function() {

        $(this).find('input').attr('readonly', 'true');

        // Minus value
        $(this).find(".minus").click(function() {

            input = $(this).parents(".form-control-quantity").find("input");
            val = input.val();
            step = input.attr('step');
            min = input.attr('min');

            if (typeof min === undefined || min == '') {
                min = 1;
            }

            if(typeof step !== undefined){
                v = parseInt(input.val()) - step;
            }else{
                v = parseInt(input.val()) - 1;
            }

            if (v >= min) {
                input.val(v);
            }

            $("[name='update_cart']").removeAttr('disabled');
        });

        // Plus value
        $(this).find(".plus").click(function() {

            input = $(this).parents(".form-control-quantity").find("input");
            val = input.val();
            step = input.attr('step');
            max = input.attr('max');

            if (typeof max === undefined || max == '') {
                max = 300;
            }

            if(typeof step !== undefined){
                v = parseInt(input.val()) + parseInt(step);
            }else{
                v = parseInt(input.val()) + 1;
            }

            if (v <= max) {
                input.val(v);
            }

            $("[name='update_cart']").removeAttr('disabled');
        });

        // Prevent negative number
        $(this).find('input[type="number"]').keypress(function(){
            var testNumberQty = /^\d+$/;
            if (!testNumberQty.test($(this))) {
                $(this).val('')
            }
        });
    });

    $('[name="update_cart"]').click(function(){
        setTimeout(function(){
            quantity();
        }, 2000);
    });

}

function obtenerPresentacion()
{
	$.ajax({
	type: 'POST',
	url: './admin/php/request.php?Landing=obtenerPresentacion',        
	dataType : 'JSON',
	success: function(response) {
		console.log('RESPUESTA',response);
		if(typeof response  === 'object')
		{
			$('#titulo_presentacion').text(response[0].titulo);
			$('#imagen_presentacion').attr('style', 'background-image: url("admin'+response[0].archivo.substring(1)+'")');
		}	
	}
	});		
	
}

function obtenerProductos() {
	$.ajax({
		type: 'POST',
		url: './admin/php/request.php?Productos=listarProductosIndex&categoria=Camaras',
		//url: './admin/php/request.php?Productos=listarProductosIndex&categoria=Camaras',
		dataType: 'JSON',
		success: function (response) {
			console.log(response);
			if (typeof response === 'object') {
				for (let i = 0; i < response.length; i++) {
					const element = response[i];
					let divBase = $('#divBaseProductos').clone();
					$(divBase).addClass('');
					$(divBase).attr('style', 'display:block');
					$(divBase).find('#h1Nombre').text(element.nombre);
					$(divBase).find('#precioProducto').text(element.precio);

					$(divBase).find('#hrefProducto').attr('href','detalle_producto.html?id=' + element.id);
					$(divBase).find('#imgProducto').attr('style','background-image: url("admin'+ element.foto_index.substring(1) +'")');
					$('#divPadreProductos').append(divBase);
					$('#sinProductos').attr('style','display:none');
				}
			}
		}
	});

}


function obtenerLineas() {
	$.ajax({
		type: 'POST',
		url: './admin/php/request.php?Landing=obtenerLineas',
		dataType: 'JSON',
		success: function (response) {
			console.log(response);
			if (typeof response === 'object') {

				for (let i = 0; i < response.length; i++) {
					let divBase = $('#slideBase').clone();
					$(divBase).attr('style', 'display:block');
					$(divBase).find('#titulo').text(response[i].titulo);
					$(divBase).find('#descripcion').text(response[i].descripcion);
					if (response[i].precio != 0) {
						$(divBase).find('#precio').text('$' + response[i].precio);
					}
					$(divBase).find('#img1').attr('style', 'background-image: url("admin' + response[i].foto1.substring(1) + '")');
					$(divBase).find('#img2').attr('style', 'background-image: url("admin' + response[i].foto2.substring(1) + '")');
					$('#slidesPadre').append(divBase);
				}


				// Collection
				$('.home .collections .slider .slides').on('init reInit beforeChange', function (event, slick, currentSlide, nextSlide) {
					var i = (nextSlide ? nextSlide : 0) + 1;
					$('.home .collections .arrows .count').text(i + '/' + slick.slideCount);
				});

				$('.home .collections .slider .slides').slick({
					mobileFirst: true,
					arrows: true,
					prevArrow: $('.home .collections .slider .arrows .prev'),
					nextArrow: $('.home .collections .slider .arrows .next'),
					dots: false,
					verical: true,
					verticalSwiping: true,
					adaptiveHeight: true,
					autoplay: true,
					autoplaySpeed: 3000,
					pauseOnHover: true,
					speed: 1000,
					fade: true,
				});
			}
		}
	});

}

function obtenerProyectos() {
	$.ajax({
		type: 'POST',
		url: './admin/php/request.php?Landing=listar&tipo=proyectos',
		dataType: 'JSON',
		success: function (response1) {
			if (typeof response1 === 'object') {
				$.ajax({
					type: 'POST',
					url: './admin/php/obtenerImagenes.php',
					data: { 'directorio': response1[0].archivo },
					dataType: 'JSON',
					success: function (response) {
						if (typeof response === 'object') {
							let contadorImg = 1;
							let initialPreview = [];
							for (let i = 0; i < response.length; i++) {
								if (response[i] != '.' && response[i] != '..' && contadorImg <= 2) {
									$('#imgProyecto' + contadorImg).attr('src', './admin' + response1[0].archivo.substring(2) + response[i]);
									$('#imgProyecto' + contadorImg).attr('style', 'display:block');
									contadorImg++;
								}
							}
						}
					}
				});

			}
		}
	});

}

function obtenerTaller() {
	$.ajax({
		type: 'POST',
		url: './admin/php/request.php?Landing=listar&tipo=taller',
		dataType: 'JSON',
		success: function (response1) {
			if (typeof response1 === 'object') {
				$.ajax({
					type: 'POST',
					url: './admin/php/obtenerImagenes.php',
					data: { 'directorio': response1[0].archivo },
					dataType: 'JSON',
					success: function (response) {
						if (typeof response === 'object') {
							let initialPreview = [];
							for (let i = 0; i < response.length; i++) {
								if (response[i] != '.' && response[i] != '..') {

									const element = response[i];
									let divBase = $('#divTallerBase').clone();
									$(divBase).attr('style', 'display:block');
									$(divBase).find('#imgTaller').attr('style', 'background-image: url("admin' + response1[0].archivo.substring(2) + response[i] + '")');
									$('#divTallerPadre').append(divBase);
								}
							}

							// Collection
							$('.taller .slider .slides').on('init reInit beforeChange', function (event, slick, currentSlide, nextSlide) {
								var i = (nextSlide ? nextSlide : 0) + 1;
								$('.taller .arrows .count').text(i + '/' + slick.slideCount);
							});

							$('.taller .slider .slides').slick({
								mobileFirst: true,
								dots: false,
								arrows: true,
								prevArrow: $('.taller .arrows .prev'),
								nextArrow: $('.taller .arrows .next'),
								adaptiveHeight: true,
								autoplay: true,
								pauseOnHover: true,
								slidesToShow: 1,
								slidesToScroll: 1,
								centerMode: true,
								infinite: true,
								responsive: [
									{
										breakpoint: 480,
										settings: {
											slidesToShow: 2
										}
									},
									{
										breakpoint: 992,
										settings: {
											slidesToShow: 4
										}
									},
								]
							});
						}
					}
				});

			}
		}
	});

}








$(document).ready(function(){

	newsletterForm();

	slides();
	shareWindowFix();
	dataOpen();
	dataScroll();
	sticky();
	filter();

	// Cart
	quantity();

	// Header Scroll
	$(window).bind('scroll resize',function() {
		sticky();
	});


	//Carga de secciones
	obtenerPresentacion();
	obtenerProductos();
	obtenerLineas();
	obtenerProyectos();
	obtenerTaller();
	

});