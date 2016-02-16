<table width="100%" cellpadding="5" cellspacing="2" border="0">
	<tr>	
		<td valign="top" class="col_one">
		@foreach($states as $counter => $state)
				<div class="state-header"><a href="{!! URL::action('VirtualOfficesController@getCountryVirtualOffices', ['country_slug'=> $state->slug])!!}" title="{{ $state->name }} virtual offices">Virtual Office in {!! $state->name !!}</a></div>
				@foreach($state->active_cities as $city)
					<div class="city-header"><a href="{!! URL::action('VirtualOfficesController@getCityVirtualOfficesWithoutId', ['country_code' => $city->us_state_code, 'city-slug' => $city->slug])!!}" class="style5" title="{{ $city->name }} virtual offices">{!! $city->name !!}</a></div>
					<!-- <div class="city-header"><a href="{!! URL::action('VirtualOfficesController@getCityVirtualOffices', ['country_code' => $city->country_code, 'city-slug' => $city->slug, 'city_id' => $city->id])!!}" class="style5" title="{{ $city->name }} virtual offices">{!! $city->name !!}</a></div> -->
				@endforeach
				@if($counter === 10)
					</td><td valign="top" class="col_two">
				@endif
				@if($counter === 24)
					</td><td valign="top" class="col_three">
				@endif
		@endforeach
		</td>
	</tr>
</table>