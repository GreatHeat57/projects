@foreach($prods as $prod)
	<div class="docname">
		<a href="{{ route('front.product', $prod->slug) }}">
			{!! strlen($prod->name) > 66 ? str_replace($slug,'<b>'.$slug.'</b>',substr($prod->name,0,66)).'...' : str_replace($slug,'<b>'.$slug.'</b>',$prod->name)  !!} - {{ $prod->showPrice() }}
		</a>
	</div> 
@endforeach