@extends('frontend.layouts.master')

@section('title','Parking parking PAGE')

@section('main-content')
	
		<!-- Breadcrumbs -->
		<div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
								<li class="active"><a href="javascript:void(0);">Shop List</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Breadcrumbs -->
		<form action="{{route('shop.filter')}}" method="POST">
		@csrf
			<!-- parking Style 1 -->
			<section class="parking-area shop-sidebar shop-list shop section">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<div class="row">
								<div class="col-12">
									<!-- Shop Top -->
									<div class="shop-top">
											<div class="single-shorter">
												<label>Sort By :</label>
												<select class='sortBy' name='sortBy' onchange="this.form.submit();">
													<option value="">Default</option>
													<option value="title" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='title') selected @endif>Name</option>
													<option value="price" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price') selected @endif>Price</option>
												</select>
											</div>
										</div>
										<ul class="view-mode">
											<li><a href="{{route('parking-grids')}}"><i class="fa fa-th-large"></i></a></li>
											<li class="active"><a href="javascript:void(0)"><i class="fa fa-th-list"></i></a></li>
										</ul>
									</div>
									<!--/ End Shop Top -->
								</div>
							</div>
							<div class="row">
								@if(count($parkings))
									@foreach($parkings as $parking)
									 	{{-- {{$parking}} --}}
										<!-- Start Single List -->
										<div class="col-12">
											<div class="row">
												<div class="col-lg-4 col-md-6 col-sm-6">
													<div class="single-parking">
														<div class="parking-img">
															<a href="{{route('parking-detail',$parking->slug)}}">
															@php 
																$photo=explode(',',$parking->photo);
															@endphp
															<img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
															<img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
															</a>
															<div class="button-head">
																<div class="parking-action">
																</div>
																<div class="parking-action-2">
																	<a title="Add to cart" href="{{route('add-to-cart',$parking->slug)}}">SELECT</a>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-lg-8 col-md-6 col-12">
													<div class="list-content">
														<div class="parking-content">
															<div class="parking-price">
																@php
																	$after_discount=($parking->price-($parking->price*$parking->discount)/100);
																@endphp
																<span>{{number_format($after_discount,2)}}Tk.</span>
																<del>{{number_format($parking->price,2)}}Tk.</del>
															</div>
															<h3 class="title"><a href="{{route('parking-detail',$parking->slug)}}">{{$parking->title}}</a></h3>
														{{-- <p>{!! html_entity_decode($parking->summary) !!}</p> --}}
														</div>
														<p class="des pt-2">{!! html_entity_decode($parking->summary) !!}</p>
														<a href="javascript:void(0)" class="btn cart" data-id="{{$parking->id}}">Buy Now!</a>
													</div>
												</div>
											</div>
										</div>
										<!-- End Single List -->
									@endforeach
								@else
									<h4 class="text-warning" style="margin:100px auto;">There are no parkings.</h4>
								@endif
							</div>
							 <div class="row">
                            <div class="col-md-12 justify-content-center d-flex">
                                {{-- {{$parkings->appends($_GET)->links()}}  --}}
                            </div>
                          </div>
						</div>
					</div>
				</div>
			</section>
			<!--/ End parking Style 1  -->	
		</form>
		<!-- Modal -->
		@if($parkings)
			@foreach($parkings as $key=>$parking)
				<div class="modal fade" id="{{$parking->id}}" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
								</div>
								<div class="modal-body">
									<div class="row no-gutters">
										<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
											<!-- parking Slider -->
												<div class="parking-gallery">
													<div class="quickview-slider-active">
														@php 
															$photo=explode(',',$parking->photo);
														// dd($photo);
														@endphp
														@foreach($photo as $data)
															<div class="single-slider">
																<img src="{{$data}}" alt="{{$data}}">
															</div>
														@endforeach
													</div>
												</div>
											<!-- End parking slider -->
										</div>
										<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
											<div class="quickview-content">
												<h2>{{$parking->title}}</h2>
												<div class="quickview-ratting-review">
													<div class="quickview-ratting-wrap">
														<div class="quickview-ratting">
															{{-- <i class="yellow fa fa-star"></i>
															<i class="yellow fa fa-star"></i>
															<i class="yellow fa fa-star"></i>
															<i class="yellow fa fa-star"></i>
															<i class="fa fa-star"></i> --}}
															@php
																$rate=DB::table('parking_reviews')->where('product_id',$parking->id)->avg('rate');
																$rate_count=DB::table('parking_reviews')->where('product_id',$parking->id)->count();
															@endphp
															@for($i=1; $i<=5; $i++)
																@if($rate>=$i)
																	<i class="yellow fa fa-star"></i>
																@else 
																<i class="fa fa-star"></i>
																@endif
															@endfor
														</div>
														<a href="#"> ({{$rate_count}} customer review)</a>
													</div>
													<div class="quickview-stock">
														@if($parking->stock >0)
														<span><i class="fa fa-check-circle-o"></i> {{$parking->stock}} in stock</span>
														@else 
														<span><i class="fa fa-times-circle-o text-danger"></i> {{$parking->stock}} out stock</span>
														@endif
													</div>
												</div>
												@php
													$after_discount=($parking->price-($parking->price*$parking->discount)/100);
												@endphp
												<h3><small><del class="text-muted">{{number_format($parking->price,2)}}Tk.</del></small>    {{number_format($after_discount,2)}}Tk.  </h3>
												<div class="quickview-peragraph">
													<p>{!! html_entity_decode($parking->summary) !!}</p>
												</div>
												@if($parking->size)
													<div class="size">
														<h4>Size</h4>
														<ul>
															@php 
																$sizes=explode(',',$parking->size);
																// dd($sizes);
															@endphp
															@foreach($sizes as $size)
															<li><a href="#" class="one">{{$size}}</a></li>
															@endforeach
														</ul>
													</div>
												@endif
												<form action="{{route('single-add-to-cart')}}" method="POST">
													@csrf 
													<div class="quantity">
														<!-- Input Order -->
														<div class="input-group">
															<div class="button minus">
																<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
																	<i class="ti-minus"></i>
																</button>
															</div>
															<input type="hidden" name="slug" value="{{$parking->slug}}">
															<input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1">
															<div class="button plus">
																<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
																	<i class="ti-plus"></i>
																</button>
															</div>
														</div>
														<!--/ End Input Order -->
													</div>
													<div class="add-to-cart">
														<button type="submit" class="btn">SELECT</button>
														<a href="{{route('add-to-wishlist',$parking->slug)}}" class="btn min"><i class="ti-heart"></i></a>
													</div>
												</form>
												<div class="default-social">
												<!-- ShareThis BEGIN --><div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
				</div>
			@endforeach
		@endif
			<!-- Modal end -->
@endsection
@push ('styles')
<style>
	 .pagination{
        display:inline-flex;
    }
	.filter_button{
        /* height:20px; */
        text-align: center;
        background:#00414A;
        padding:8px 16px;
        margin-top:10px;
        color: white;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
					else{
                        swal('error',response.msg,'error').then(function(){
							// document.location.href=document.location.href;
						}); 
                    }
                }
            })
        });
	</script> --}}
	<script>
        $(document).ready(function(){
        /*----------------------------------------------------*/
        /*  Jquery Ui slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt( $("#slider-range").data('max') ) || 500;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';
            let price_range = min_value+'-'+max_value;
            if($("#price_range").length > 0 && $("#price_range").val()){
                price_range = $("#price_range").val().trim();
            }
            
            let price = price_range.split('-');
            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: price,
                slide: function (event, ui) {
                    $("#amount").val(currency + ui.values[0] + " -  "+currency+ ui.values[1]);
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                }
            });
            }
        if ($("#amount").length > 0) {
            const m_currency = $("#slider-range").data('currency') || '';
            $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                "  -  "+m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>

@endpush