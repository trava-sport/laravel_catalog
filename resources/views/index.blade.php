<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Каталог</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
	<script src={{ asset('js/app.js') }} defer></script>
	@yield('scripts')
    {{-- <script>
		$('document').ready(function () {
			$('.ui-slider').slider({
				animate: false,
				range: true,
				values: [0, 2000],
				min: 0,
				max: 2000,
				step: 1,
				slide: function (event, ui) {
					if (ui.values[1] - ui.values[0] < 1) return false;
					$('.ui-slider-min').val(ui.values[0]);
					$('.ui-slider-max').val(ui.values[1]);
				},
				stop:function (event, ui) {
					let priceFrom = ui.values[0];
					let priceTo = ui.values[1];
					Cookies.set('priceFrom', priceFrom);
					Cookies.set('priceTo', priceTo);

					$.ajax({
						url: "{{route('catalog')}}",
						type: "GET",
						data: {
							priceFrom: priceFrom,
							priceTo: priceTo,
							razmer: Cookies.get('razmer'),
							tkan: Cookies.get('tkan')
						},
						headers: {
							'X-CSRF': $('meta[name="csrf-token"]').attr('content')
						},
						success: (data) => {
							let positionParameters = location.pathname.indexOf('?');
							let url = location.pathname.substring(positionParameters, location.pathname.length);
							let newURL = (priceTo == 2000 && priceFrom == 0 && !Cookies.get('razmer') && !Cookies.get('tkan')) ? url : url + '?';
							if (Cookies.get('razmer')) {
								newURL += 'razmer=' + Cookies.get('razmer');
							}
							if (Cookies.get('razmer') && Cookies.get('tkan')) {
								newURL += '&tkan=' + Cookies.get('tkan');
							}
							if (!Cookies.get('razmer') && Cookies.get('tkan')) {
								newURL += 'tkan=' + Cookies.get('tkan');
							}
							if (priceFrom != 0 && !Cookies.get('razmer') && !Cookies.get('tkan')) {
								newURL += 'priceFrom=' + priceFrom;
							}
							if (priceFrom != 0 && (Cookies.get('razmer') || Cookies.get('tkan'))) {
								newURL += '&priceFrom=' + priceFrom;
							}
							if (priceTo != 2000 && (priceFrom != 0 || Cookies.get('razmer') || Cookies.get('tkan'))) {
								newURL += '&priceTo=' + priceTo;
							}
							if (priceTo != 2000 && priceFrom == 0 && !Cookies.get('razmer') && !Cookies.get('tkan')) {
								newURL += 'priceTo=' + priceTo;
							}
							history.pushState({}, '', newURL);
							$('.column .columns').html(data);
						}
					});
				}
			});
		
			$(".price-input").change(function() {
				var $this = $(this);
				$(".ui-slider").slider("values",  $this.attr('index'), $this.val());
			});

			$('.filter-list').on('click', 'input:checkbox', function () {
				let razmer = '';
			   let tkan = '';
			   let id = $(this).attr('id');
			   Cookies.set(id, '');

			   $('.filter-size input:checkbox:checked').each(function() {
				   id = $(this).attr('id');
				   Cookies.set(id, '1');
				   let value = $(this).val();
				   if (razmer) {
					   razmer += "," + value;
				   }
				   else {
					   razmer += value;
				   }
			   })

			   $('.filter-tkan input:checkbox:checked').each(function(){
				   id = $(this).attr('id');
				   Cookies.set(id, '1');
				   let value = $(this).val()
				   console.log(value)
				   if (tkan) {
					   tkan += "," + value;
				   }
				   else {
					   tkan += value;
				   }
			   })

			   Cookies.set('razmer', razmer);
			   Cookies.set('tkan', tkan);

			   $.ajax({
				   url: "{{route('catalog')}}",
				   type: "GET",
				   data: {
					   razmer: razmer,
					   tkan: tkan,
					   priceFrom: Cookies.get('priceFrom'),
					   priceTo: Cookies.get('priceTo')
				   },
				   headers: {
					   'X-CSRF': $('meta[name="csrf-token"]').attr('content')
				   },
				   success: (data) => {
					   let positionParameters = location.pathname.indexOf('?');
					   let url = location.pathname.substring(positionParameters, location.pathname.length);
					   let newURL = (Cookies.get('priceTo') == 2000 && Cookies.get('priceFrom') == 0 && !razmer && !tkan) ? url : url + '?';
					   if (razmer) {
						   newURL += 'razmer=' + razmer;
					   }
					   if (tkan && razmer) {
						   newURL += '&tkan=' + tkan;
					   }
					   if (tkan && !razmer) {
						   newURL += 'tkan=' + tkan;
					   }
					   if (Cookies.get('priceFrom') != 0 && !razmer && !tkan) {
							newURL += 'priceFrom=' + Cookies.get('priceFrom');
						}
						if (Cookies.get('priceFrom') != 0 && (razmer || tkan)) {
							newURL += '&priceFrom=' + Cookies.get('priceFrom');
						}
						if (Cookies.get('priceTo') != 2000 && (Cookies.get('priceFrom') != 0 || razmer || tkan)) {
							newURL += '&priceTo=' + Cookies.get('priceTo');
						}
						if (Cookies.get('priceTo') != 2000 && Cookies.get('priceFrom') == 0 && !razmer && !tkan) {
							newURL += 'priceTo=' + Cookies.get('priceTo');
						}
					   history.pushState({}, '', newURL);

					   $('.column .columns').html(data);
				   }
			   });
           });

			$('input:checkbox').each(function() {
				id = $(this).attr('id');
				let isCheck = false;
				let checkbox_length = $('.filter-size').length;
				isCheck = Cookies.get(id) ? true : false;

				if (isCheck){
					$('#' + id).attr('checked','checked');
				}else{
					$('#' + id).removeAttr('checked') ;
				}
			});

			$(".ui-slider-min").val(Cookies.get('priceFrom'));
			$(".ui-slider-max").val(Cookies.get('priceTo'));
			$(".ui-slider").slider("values", '0', Cookies.get('priceFrom'));
			$(".ui-slider").slider("values", '1', Cookies.get('priceTo'));

			$('.filter-content .btn').click(function () {
				Cookies.set('priceFrom', 0);
				Cookies.set('priceTo', 2000);
				Cookies.set('razmer', '');
			    Cookies.set('tkan', '');
				$('input:checkbox').prop('checked', false);
				$('input:checkbox').each(function() {
					id = $(this).attr('id');
				    Cookies.set(id, '');
				});
				$(".ui-slider-min").val(0);
				$(".ui-slider-max").val(2000);
				$(".ui-slider").slider("values", '0', 0);
				$(".ui-slider").slider("values", '1', 2000);

			   $.ajax({
				   url: "{{route('catalog')}}",
				   type: "GET",
				   data: {
				   },
				   headers: {
					   'X-CSRF': $('meta[name="csrf-token"]').attr('content')
				   },
				   success: (data) => {
					let positionParameters = location.pathname.indexOf('?');
					let url = location.pathname.substring(positionParameters, location.pathname.length);
					let newURL = url;
					history.pushState({}, '', newURL);
					$('.column .columns').html(data);
				   }
			   });
			});
		});
     </script> --}}
</head>

<body>
<div class="wrapper">
    <div class="header">
        <div class="container">
        	<h2>Каталог</h2>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					@guest
						<li><a href="{{ route('login') }}">Панель администратора</a></li>
					@endguest

					@auth
						<li><a href="{{ route('items.index') }}">Панель администратора</a></li>
						<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
							Выйти
						</a> </li>   
						<form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					@endauth
				</ul>
			</div>
        </div>
    </div>
    <div class="wrap">
        <div class="container">
        	<div class="columns">
        		<div class="column col-3">
        			<!-- filter -->
        			<div class="filter">
        				<!-- filter-item -->
        				<div class="filter-item">
        					<div class="filter-title">Размер</div>
        					<div class="filter-content">
        						<ul class="filter-list size">
									@php
										$counter = 1;
									@endphp
									@foreach ($filter_size as $size)
										<li class="filter-size">
											<input type="checkbox" value="{{$size->code}}" id="filter-size-{{$size->id}}">
											<label for="filter-size-{{$size->id}}">{{$size->name}}</label>
										</li>
										@php
											$counter += 1;
										@endphp
									@endforeach
        						</ul>
        					</div>
        				</div>
        				<!-- filter-item -->
        				<div class="filter-item">
        					<div class="filter-title">Ткань</div>
        					<div class="filter-content">
        						<ul class="filter-list fabric">
									@php
										$counter = 1;
									@endphp
									@foreach ($filter_fabric as $fabric)
        							<li class="filter-tkan">
        								<input type="checkbox" value="{{$fabric->code}}" id="filter-tkan-{{$fabric->id}}">
        								<label for="filter-tkan-{{$fabric->id}}">{{$fabric->name}}</label>
        							</li>
										@php
											$counter += 1;
										@endphp
									@endforeach
        						</ul>
        					</div>
        				</div>
        				<!-- filter-item -->
        				<div class="filter-item">
        					<div class="filter-title">Цена</div>
        					<div class="filter-content">
        						<div class="price">
        							<input type="text" index="0" class="price-input ui-slider-min" value="0">
        							<span class="price-sep"></span>
        							<input type="text" index="1" class="price-input ui-slider-max" value="<?=$_COOKIE['priceTo']?>">
        						</div>
        						<div class="ui-slider"></div>
        					</div>
        				</div>
        				<!-- filter-item -->
        				<div class="filter-item">
        					<div class="filter-content">
        						<button class="btn">Сбросить фильтр</button>
        					</div>
        				</div>
        			</div>
        		</div>
        		<div class="column col-9">
        			<div class="columns">
                        
                        @foreach ($items as $item)
                            <!-- Item -->  
                            <div class="column col-4">
                                <div class="element">
                                    <div class="element-image">
                                        <img src="https://avatars.mds.yandex.net/get-mpic/1923922/img_id3485673576547289781.jpeg/6hq" alt="">
                                    </div>
                                    <div class="element-title">
                                        <a href="">КПБ Бязь "Angelina"</a>
                                    </div>
                                    <div class="element-price">770 ₽</div>
                                </div>
                            </div>   
                        @endforeach 
                    </div>
        		</div>
        	</div>
        </div>
    </div>
</div>
</body>
</html>