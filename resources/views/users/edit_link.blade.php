@extends('template.template')
@section('title', 'Edit Link')
{{-- @section('dashboard', 'active') --}}



@section('content')
						<!-- Form horizontal -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Edit Link Here</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                		<li><a data-action="close"></a></li>
			                	</ul>
		                	</div>
						</div>

						<div class="panel-body">
							@if (session()->has('success'))
								<div class="alert alert-primary" role="alert">
								  {{session('success')}}
								</div>
							@elseif(session()->has('error'))
								<div class="alert alert-danger" role="alert">
								  {!! session('error') !!}
								</div>
							@endif


							<form class="form-horizontal" method="POST" action="{{ route('edit_url_action', ['id'=> $data->id]) }}" autocomplete="off">
								@csrf
								<fieldset class="content-group">
									<legend class="text-bold">Basic inputs</legend>

									<div class="form-group">
										<label class="control-label col-lg-2">Judul Link</label>
										<div class="col-lg-10">
											<input type="text" name="judul" class="form-control" value="{{$data->name}}">
										</div>
									</div>

									<div class="form-group" >
										<label class="control-label col-lg-2">Masukan URL</label>
										<div class="col-lg-10" id="dinamic_field">
											@php
												$url = json_decode($data->url, TRUE);
												$total = count($url);
											@endphp
											@for($i=0; $i<$total; $i++)

												@if($i == 0)
													<div class="input-group">
														<input type="text" name="link[]" class="form-control" value="{{$url[$i]}}">
														<span class="input-group-btn">
															<button class="btn bg-teal" type="button" name="add" id="add">Tambah</button>
														</span>
													</div>
												@else
													<br id="enter{{$i}}">
													<div id="row{{$i}}" class="input-group">
														<input type="text" name="link[]" class="form-control" value="{{$url[$i]}}">
														<span class="input-group-btn">
															<button class="btn btn-danger btn_remove" type="button" name="remove" id="{{$i}}">Hapus</button>
														</span>
													</div>
													</td>
												@endif

											@endfor

										</div>
									</div>

									
									<div class="form-group">
										<label class="control-label col-lg-2">Deskripsi</label>
										<div class="col-lg-10">
											<textarea rows="5" cols="5" name="desc" class="form-control" placeholder="Default textarea">{{$data->desc}}</textarea>
										</div>
									</div>
								</fieldset>
								<div  class="checkbox checkbox-switchery">
								<label>
									<input type="checkbox" name="is_public" class="switchery" {{ $data->public ? 'checked' : 'unc'}}>Available For Public?
								</label>
								</div>						

								

								<div class="text-right">
									<button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>							
								</div>
							</form>

							<div class="text-right">
								<form action="{{route('delete_url', ['id' => $data->id])}}" method="POST">
									@csrf
								<button type="submit" class="btn btn-danger">Delete This <i class="icon-chevron-up"></i></button>
								</form>
							</div>
							
						</div>
					</div>
					<!-- /form horizontal -->

<script type="text/javascript">
	var i = {{$total}};
	
	$(document).ready(function(){
		alert(123123123123);
	});

	$('#add').click(function(){
		i ++;
		$('#dinamic_field').append('<br id="enter'+i+'"><div id="row'+i+'" class="input-group"><input type="text" name="link[]" class="form-control" placeholder="Masukan URL with http/https"><span class="input-group-btn"><button class="btn btn-danger btn_remove" type="button" name="remove" id="'+i+'">Hapus</button></span></div></td>');
	});

	$(document).on('click','.btn_remove', function(){
		var button_id = $(this).attr("id");
		const enter = "#enter"+button_id;
		const row   = "#row"+button_id;
		$(enter).remove()	
		$(row).remove()	
		
	});


</script>

@endsection