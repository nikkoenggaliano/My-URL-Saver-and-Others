@extends('template.template')
@section('title', 'View Link')
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
							Highlighting rows and columns have be quite useful for drawing attention to where the user's cursor is in a table, particularly if you have a lot of narrow columns. Of course the highlighting of a row is easy enough using CSS, but for column highlighting, you need to use a little bit of Javascript. This example shows that in action on DataTable by making use of the <code>cell().index()</code>, <code>cells().nodes()</code> and <code>column().nodes()</code> methods.
						</div>

						<table class="table table-bordered table-hover datatable-highlight" id="my_table">
							<thead>
								<tr>
									<th>No</th>
									<th>Judul</th>
									<th class="text-center">Actions</th>
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
		        ajax: 'api/get-my-link',
		        columns: [
		            { data: 'DT_RowIndex' },
		            { data: 'name', render: function(data, type, row, meta){
		            	//return '<a href="javascript:getDetailURL('+row['id']+');>'+data+'</a>';
		            	return `<a href="javascript:getDetailURL(${row['id']})"><b>${data}</b></a>`;
		            }},
		            { data: 'edit', render:  function(data, type, row, meta){
		            	return '<ul class="icons-list"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a><ul class="dropdown-menu dropdown-menu-right"><li><a href="'+row['name']+'"><i class="icon-file-pdf"></i> Edit Link</a></li><li><a href="#"><li><a href="#"><i class="icon-file-word"></i> View Link</a></li></ul></li></ul>';

		            }, className: 'text-center',},
		            
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

