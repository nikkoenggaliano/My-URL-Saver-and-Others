@extends('template.template')
@section('title', 'Public Link for you')
{{-- @section('dashboard', 'active') --}}

@section('content')
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">View My Link</h5>
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
							Halo {{Auth::user()->username}} kami memiliki tautan tersimpan yang dibagikan ke pada publik sebanyak <code>{{ $data->total_url }}</code> buah dari <code>{{$data->total_user}}</code> yang aktif, kami sajikan pada <i>table</i> di bawah ini.
						</div>

						<table class="table table-bordered table-hover datatable-highlight" id="my_table">
							<thead>
								<tr>
									<th>No</th>
									<th>Judul</th>
							</thead>
						</table>
					</div>


<!-- Modal: modalCart -->
<div class="modal fade" id="modalCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <!--Body-->
      <div class="modal-body">

        <table class="table table-hover" id="detail_table">
          <thead>
            <tr>
              <th>URL</th>
            </tr>
          </thead>
        </table>
			<p style="word-wrap: break-word;" id="desc"></p>
      </div>
      <!--Footer-->
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal: modalCart -->

@push('scripts')
<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function(event) { 
			var tdt = $('#my_table').DataTable({
		        processing: true,
		        serverSide: true,
		        ajax: 'api/get-pub-link',
		        columns: [
		            { data: 'DT_RowIndex' },
		            { data: 'name', render: function(data, type, row, meta){
		            
		            	return `<a href="javascript:getDetailURL(${row['id']})"><b>${data}</b></a>`;
		            }
		        	},
		        ],
		    });
		});


		function getDetailURL(id){
			// alert(id);
			// 
			$.ajax({
				url: 'api/get-detail-my-link/'+id,
				success: function(data){
					$("#myModalLabel").html(data.judul);
					$("#desc").html(data.deskripsi);
				}
			});
			$("#detail_table").DataTable({
				pagingType: "full_numbers",
				destroy: true,
				processing: true,
				serverSide: false,
				ajax: 'api/get-detail-my-link/'+id,
				columns: [
					{data: 'url', render: function(data, type, row, meta){
						return `<a href="${data}" target="_blank">${data.substring(0, 50)}</a>`;
					}}
				]

			});

			$('#modalCart').modal('show'); 

		}
</script>
@endpush

@endsection

