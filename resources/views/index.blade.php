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
									@foreach ($filter_size as $size)
										<li class="filter-size">
											<input type="checkbox" value="{{$size->code}}" id="filter-size-{{$size->id}}">
											<label for="filter-size-{{$size->id}}">{{$size->name}}</label>
										</li>
									@endforeach
        						</ul>
        					</div>
        				</div>
        				<!-- filter-item -->
        				<div class="filter-item">
        					<div class="filter-title">Ткань</div>
        					<div class="filter-content">
        						<ul class="filter-list fabric">
									@foreach ($filter_fabric as $fabric)
        							<li class="filter-tkan">
        								<input type="checkbox" value="{{$fabric->code}}" id="filter-tkan-{{$fabric->id}}">
        								<label for="filter-tkan-{{$fabric->id}}">{{$fabric->name}}</label>
        							</li>
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
                                        <img src="{{ Storage::url($item->image) }}" alt="">
                                    </div>
                                    <div class="element-title">
                                        <a href="">{{$item->name}}</a>
                                    </div>
                                    <div class="element-price">{{$item->price}}</div>
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