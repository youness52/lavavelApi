<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="assets\css\plugins\dataTables\datatables.min.css" rel="stylesheet">
<script src="/assets/js/jquery-3.1.1.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="\assets\js\plugins\dataTables\datatables.min.js"></script>
<script src="\assets\js\plugins\dataTables\dataTables.bootstrap4.min.js"></script>

</head>
<body>
<div class="container-fluid pt-3">
	<div class="row mb-3">
		<div class="col-md-6 text-capitalize"><h1>Categories Management</h2></div>
		<div class="col-md-6 text-right"><button type="button" onclick="add_categories();" class="btn btn-primary">Add Categories</button></div>
		<div class="col-md-12">
			<table class="table table-bordered table-striped" id="tbl_categories" style="width: 100%;"></table>
		</div>
	</div>
</div>

<!-- Modal Form -->
<form method="post" class="needs-validation" id="Category_form" action="{{ route('categories.save') }}" novalidate>
@csrf 
	<div class="modal fade" tabindex="-1" role="dialog" id="modal_Category_form" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal_Category_form_title">Add Categories</h5>
					<button class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<input type="hidden" name="id" id="id" />
						<div class="col-md-12 mb-3">
							<label class="mb-2">Name</label>
							<input type="text" name="name" id="name" class="form-control " required  placeholder="Enter name"/>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-success" id="Category_form_btn" >Save</button>
				</div>
			</div>
		</div>
	</div>
</form>

<!-- Modal Form -->

<script>
 var tbl_categories;
show_categories();
function show_categories(){
	if(tbl_categories){
		tbl_categories.destroy();
	}
	tbl_samples = $('#tbl_categories').DataTable({
		destroy: true,
		pageLength: 10,
		responsive: true,
		ajax: "{{ route('categories.list') }}",
		deferRender: true,
		columns: [
			{
				className: '',
				"data": 'name',
				"title": 'Name',
			},
			{
				className: 'width-option-1 text-center',
				width: '15%',
				"data": 'id',
				"orderable": false,
				"title": 'Options',
				"render": function(data, type, row, meta){
					newdata = '';
					newdata += '<button class="btn btn-success btn-sm font-base mt-1"  onclick="edit_categories('+row.id+')" type="button"><i class="fa fa-edit"></i></button> ';
					newdata += ' <button class="btn btn-danger btn-sm font-base mt-1" onclick="delete_categories('+row.id+');" type="button"><i class="fa fa-trash"></i></button>';
					return newdata;
				}
			}
		]
	});
}


$("#Category_form").on('submit', function(e){
	e.preventDefault();
	let id = $('#id').val();
	let url = $(this).attr('action');
	let formData = $(this).serialize();
	$.ajax({
		type:"POST",
		url:url+'/'+id,
		data:formData,
		dataType:'json',
		beforeSend:function(){
			$('#Category_form_btn').prop('disabled', true);
		},
		success:function(response){
			// console.log(response);
			if (response.status == true) {
				swal("Success", response.message, "success");
				show_categories();
				$('#modal_Category_form').modal('hide');
			}else{
				console.log(response);
			}
				//validation('Category_form', response.error);
				$('#Category_form_btn').prop('disabled', false);
		},
		error: function(error){
			$('#Category_form_btn').prop('disabled', false);
			console.log(error);
		}
	});
});

function add_categories(){
	$("#id").val('');
	$('#name').val('');
	$("#modal_Category_form").modal('show');
}


function edit_categories(id){
	$.ajax({
		type:"GET",
		url:"{{ route('categories.find') }}/"+id,
		data:{},
		dataType:'json',
		beforeSend:function(){
		},
		success:function(response){
			// console.log(response);
			if (response.status == true) {
				$('#id').val(response.data.id);
				$('#name').val(response.data.name);
				$('#modal_Category_form').modal('show');
			}else{
				console.log(response);
			}
		},
		error: function(error){
			console.log(error);
		}
	});
}


function delete_categories(id){
	
    swal({
        title: "Are you sure?",
		text: "Do you want to delete categories?",
      icon: "warning",
      buttons: [
        'No, cancel it!',
        'Yes, I am sure!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
		$.ajax({
			type:"GET",
			url:"{{ route('categories.delete') }}/"+id,
			data:{},
			dataType:'json',
			beforeSend:function(){
		},
		success:function(response){
			// console.log(response);
			if (response.status == true) {
				show_categories();
				swal("Success", response.message, "success");
			}else{
				console.log(response);
			}
		},
		error: function(error){
			console.log(error);
		}
		});
    }
	});
}


</script>

</body>
</html>