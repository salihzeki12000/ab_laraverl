@extends('white-site.layouts.layout')
@section('content')	
	<link rel="stylesheet" href="/css/photoswipe.css">
	<link rel="stylesheet" href="/css/default-skin.css">
	<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
	    <div class="pswp__bg"></div>
	    <div class="pswp__scroll-wrap">
	        <div class="pswp__container">
	            <div class="pswp__item"></div>
	            <div class="pswp__item"></div>
	            <div class="pswp__item"></div>
	        </div>
	        <div class="pswp__ui pswp__ui--hidden">
	            <div class="pswp__top-bar">
	                <div class="pswp__counter"></div>
	                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
	                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
	                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
	                <div class="pswp__preloader">
	                    <div class="pswp__preloader__icn">
	                      <div class="pswp__preloader__cut">
	                        <div class="pswp__preloader__donut"></div>
	                      </div>
	                    </div>
	                </div>
	            </div>
	            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
	                <div class="pswp__share-tooltip"></div>
	            </div>
	            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
	            </button>
	            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
	            </button>
	            <div class="pswp__caption">
	                <div class="pswp__caption__center"></div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="col-md-8 col-md-offset-2 center-show">
		<div class="col-md-7 address-image">
			<div class="col-md-5">
				<div class="row">
					@if(isset($center['vo_photos']) && !empty($center['vo_photos']))
						<img src="http://www.abcn.com/images/photos/{{ $center['vo_photos'][0]['path'] }}" alt="" width="100%">
					@endif
					<div class="address">
						<div class="title">
							Address
						</div>
						<div class="location">
							{{ $center['address1'] }}<br>
							{{ $center['address2'] }}<br>
							{{ $center['city_name'] }} {{ $center['us_state'] }} {{ $center['postal_code'] }} {{ $center['country'] }}
						</div>
					</div>					
				</div>
			</div>
		</div>
		<div class="col-md-5 packages">
			<div class="title">
				Virtual Office Options
			</div>
			<div class="prices">
				@if(isset($center['prices']))					
					@foreach($center['prices'] as $price)
						@if(isset($price['package']))
							<input type="radio"> {{ $price['package']['name'] }} -$ {{ $price['package']['price'] }} <br>
						@endif
					@endforeach
				@endif				
			</div>
			<button class="compare-plans">Compare Plans</button>
			<div class="terms">
				<div class="title">
					Virtual Office Term Length					
				</div>
				<input type="radio"> 6 Months <br>
				<input type="radio"> 12 Months <br>
				<button class="continue">Continue</button>
			</div>
		</div>
		<div class="col-md-12 description">
			<div class="title">
				Location
			</div>
			<div class="notes">
				{{ $center['location'] }}
			</div>
		</div>
		<div class="col-md-12 aminities">
			<div class="title">
				Amenities
			</div>
			<div>
				{{ $center['amenities'] }}
			</div>
		</div>
		<div class="images col-md-12">			
			<div class="title">
				Images
			</div>
			<div class="row">
				@if(isset($images))
					@foreach($images as $image)
						<div class="col-md-4 image">
							<img src="{{ $image }}" width="100%" height="200px" onclick="imageOpen('{{ $image }}', {{ json_encode($images) }})">
						</div>
					@endforeach
				@endif				
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script src="/js/photoswipe.min.js"></script>
	<script src="/js/photoswipe-ui-default.min.js"></script>
	<script type="text/javascript">
		function imageOpen(source, sources){
			var pswpElement = document.querySelectorAll('.pswp')[0];

			// build items array
			var items = [
			    {
			        src: source,
			        w: 1200,
			        h: 900
			    }
			];
			for( var src in sources ){
				if( sources[src] !== source ){
					items.push({
						src: sources[src],
						w: 1200,
						h: 900
					})
				}
			}

			// define options (if needed)
			var options = {
			    // optionName: 'option value'
			    // for example:		 *
			    bgOpacity : 0.5,
			    index: 0 // start at first slide
			};

			// Initializes and opens PhotoSwipe
			var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
			gallery.init();		
		}
	</script>
@stop