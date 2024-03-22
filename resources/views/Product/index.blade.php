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
		<div class="col-md-6 text-capitalize"><h1>Products Management</h2></div>
		<div class="col-md-6 text-right"><button type="button" onclick="add_products();" class="btn btn-primary">Add Products</button></div>
		<div class="col-md-12">
			<table class="table table-bordered table-striped" id="tbl_products" style="width: 100%;"></table>
		</div>
	</div>
</div>

<!-- Modal Form -->
<form method="post" class="needs-validation" id="product_form" action="{{ route('products.save') }}" novalidate>
@csrf 
	<div class="modal fade" tabindex="-1" role="dialog" id="modal_product_form" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal_product_form_title">Add Products</h5>
					<button class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<input type="hidden" name="id" id="id" />
						<div class="col-md-12 mb-3">
							<label class="mb-2">Name</label>
							<input type="text" name="name" id="name" class="form-control " required  placeholder="Enter name"/>
						</div>
						<div class="col-md-12 mb-3">
							<label class="mb-2">Description</label>
							<textarea type="textarea" name="description" id="description" class="form-control " required placeholder="Enter description"></textarea>
						</div>
						<div class="col-md-12 mb-3">
							<label class="mb-2">Price</label>
							<input type="number" name="price" id="price" class="form-control " required  placeholder="Enter price"/>
						</div>
						<div class="col-md-12 mb-3">
							<label class="mb-2">Quantity</label>
							<input type="number" name="quantity" id="quantity" class="form-control " required  placeholder="Enter quantity"/>
						</div>
						<div class="col-md-12 mb-3">
							<label class="mb-2">Others</label>
							<input type="text" name="others" id="others" class="form-control " required  placeholder="Enter others"/>
						</div>
                        <div class="col-md-12 mb-3">
							<label class="mb-2">aa</label>
							<select  name="aa" id="aa" class="form-control "   placeholder="Enter others"></select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-success" id="product_form_btn" >Save</button>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
  var tbl_products;
show_products();
function show_products(){
	if(tbl_products){
		tbl_products.destroy();
	}
	tbl_samples = $('#tbl_products').DataTable({
		destroy: true,
		pageLength: 10,
		responsive: true,
		ajax: "{{ route('products.list') }}",
		deferRender: true,
		columns: [
			{
				className: '',
				"data": 'name',
				"title": 'Name',
			},
			{
				className: '',
				"data": 'description',
				"title": 'Description',
			},
			{
				className: '',
				"data": 'price',
				"title": 'Price',
			},
			{
				className: '',
				"data": 'quantity',
				"title": 'Quantity',
			},
			{
				className: '',
				"data": 'others',
				"title": 'Others',
			},
			{
				className: 'width-option-1 text-center',
				width: '15%',
				"data": 'id',
				"orderable": false,
				"title": 'Options',
				"render": function(data, type, row, meta){
					newdata = '';
					newdata += '<button class="btn btn-success btn-sm font-base mt-1"  onclick="edit_products('+row.id+')" type="button"><i class="fa fa-edit"></i></button> ';
					newdata += ' <button class="btn btn-danger btn-sm font-base mt-1" onclick="delete_products('+row.id+');" type="button"><i class="fa fa-trash"></i></button>';
					return newdata;
				}
			}
		]
	});
}


$("#product_form").on('submit', function(e){
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
			$('#product_form_btn').prop('disabled', true);
		},
		success:function(response){
			// console.log(response);
			if (response.status == true) {
				swal("Success", response.message, "success");
				show_products();
				$('#modal_product_form').modal('hide');
			}else{
				console.log(response);
			}
				//validation('product_form', response.error);
				$('#product_form_btn').prop('disabled', false);
		},
		error: function(error){
			$('#product_form_btn').prop('disabled', false);
			console.log(error);
		}
	});
});
function show_categories() {
    $.ajax({
		type:"GET",
		url:"{{ route('products.create') }}",
		data:{},
		dataType:'json',
		beforeSend:function(){
		},
		success:function(response){
			// console.log(response);
			if (response.status == true) {
				//$('#aa').val(response.data[0].name);
                $('#aa').html('');
				response.data.forEach(element => {
                    $('#aa').append('<option value="'+element.id+'" >'+element.name+'</option>');

                });
			}else{
				console.log(response);
			}
		},
		error: function(error){
			console.log(error);
		}
	});
}
function add_products(){
	$("#id").val('');
	$('#name').val('');
	$('#description').val('');
	$('#price').val('');
	$('#quantity').val('');
	$('#others').val('');
    show_categories();
	$("#modal_product_form").modal('show');
}


function edit_products(id){
	$.ajax({
		type:"GET",
		url:"{{ route('products.find') }}/"+id,
		data:{},
		dataType:'json',
		beforeSend:function(){
		},
		success:function(response){
			// console.log(response);
			if (response.status == true) {
				$('#id').val(response.data.id);
				$('#name').val(response.data.name);
				$('#description').val(response.data.description);
				$('#price').val(response.data.price);
				$('#quantity').val(response.data.quantity);
				$('#others').val(response.data.others);
                show_categories();
				$('#modal_product_form').modal('show');
			}else{
				console.log(response);
			}
		},
		error: function(error){
			console.log(error);
		}
	});
}


function delete_products(id){
	
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this imaginary file!",
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
			url:"{{ route('products.delete') }}/"+id,
			data:{},
			dataType:'json',
			beforeSend:function(){
		},
		success:function(response){
			// console.log(response);
			if (response.status == true) {
				show_products();
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