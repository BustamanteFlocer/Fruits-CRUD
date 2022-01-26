<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Ajax CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Fruit List</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewFruit"
    style="float:right">Add Fruit</a>
    <table class=" table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
    
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="fruitForm" name="fruitForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="fruit_id" id="fruit_id">
                        <div class="form-group">
                            Name: <br>
                            <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter Fruit" value=""required>
                        </div>
                        <div class="form-group">
                            Price: <br>
                            <input type="text" class="form-control" id="price" name="price"
                            placeholder="Enter Price" value="" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveBtn"
                        value="Create">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"> </script>
</body>

<script type="text/javascript">
$(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });
  

    var table= $(".data-table").DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{ route('fruits.index') }}",
        columns:[
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'price', name: 'price'},
            {data: 'action', name: 'action'},
        ]
    });

    $("#createNewFruit").click(function(){
        $("#fruit_id").val('');
        $("#fruitForm").trigger("reset");
        $("#modalHeading").html("Add Fruit");
        $("#ajaxModel").modal("show");
    });

    $("#saveBtn").click(function(e){
        e.preventDefault();
        $(this).html('Save');
        $.ajax({
            data:$("#fruitForm").serialize(),
            url: "{{route('fruits.store')}}",
            type:"POST",
            dataType:'json',  
            success:function(data){
                $("#studentForm").trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();
            },
            error:function(data){
                console.log('Error:',data);
                $("#saveBtn").html('Save');
            }
        });
    });

    $('body').on('click','.deleteFruit',function(){
 
        var fruit_id= $(this).data("id");
        confirm("Are you sure you want to delete?");
        $.ajax({
            type:"DELETE",
          
            url:"{{route('fruits.store')}}"+'/'+ fruit_id,
   
            success:function(data){
                table.draw();
            },
            error: function (data) {
                console.log('Error:',data);
            }
        });
    });

    $('body').on('click','.editFruit',function(){
        var fruit_id = $(this).data('id');
        $.get("{{ route('fruits.index') }}" + "/" + fruit_id +"/edit",function(data){
            $("modalHeading").html("Edit Fruit");
            $('#ajaxModel').modal('show');
            $("#fruit_id").val(data.id);
            $("#name").val(data.name);
            $("#price").val(data.price);
            
        });

    });

 });
  
</script>
</html>
