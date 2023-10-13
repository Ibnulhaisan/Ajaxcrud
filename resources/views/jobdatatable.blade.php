<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>data table</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <style>
        th,td{
            font-size: 18px;
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="text-center mt-4">All Student Job</h3>
    <br/>
    <div class="text-right">
        <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">ADD</button>
    </div>
    <table id="dataTable" style="width:100%" >
       <thead style="background-color: cornflowerblue">
        <tr >
            <th>Id</th>
            <th>name</th>
            <th>description</th>
            <th>position</th>
            <th>Action</th>
            <th><button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-info btn-xs"></i>Multidelete</button></th>
        </tr>
     </thead>
   </table>
</div>

<div id="jobModel" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="job_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <span  id="form_output"></span>
                    <div class="form-group">
                        <label>Enter name</label>
                        <input type="text" name="name" id="name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter description</label>
                        <input type="text" name="description" id="description" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter position</label>
                        <input type="text" name="position" id="position" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="job_id" id="job_id" value=""/>
                    <input type="hidden" name="button_action" id="button_action" value="insert"/>
                    <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                    <button type="button" class="btn btn-default" id="closeModal" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>  
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>  
<script src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.13.4/datatables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            ajax: "{{ route('job.show') }}",
            scrollY: '65vh',
            processing: false,
            serverSide: false,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'position', name: 'position'},
                {data: 'action', name: 'action',oderable:false, searchable:false},
                {data: 'checkbox',oderable:false, searchable:false},
                
            ],
        });
     

        $('#add_data').click(function(){
            $('#jobModel').modal('show');
            $('#job_form')[0].reset();
            $('#form_output').html('');
            $('.modal-title').text('Add Data');
            $('#button_action').val('insert');
            $('#action').val('Add');

        });

        $('#job_form').on('submit',function(event){
           event.preventDefault();
           var form_data = $(this).serialize();
           $.ajax({
                url:"{{ route('job.store') }}",
                method:"POST",   
                data:form_data,
                dataType:"json",
                success:function(data)
                {
                    if(data.error.length > 0)
                    {
                        var error_html = '';
                        for(var count = 0; count< data.error.length; count++)
                        {
                            error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                        }
                        $('#form_output').html(error_html);
                    }
                    else
                    {
                        $('#form_output').html(data).success;
                        $('#job_form')[0].reset(); // ata form thaka data reset kora diba
                        $('#action').val('Add');
                        $('.modal-title').text('Add Data');
                        $('#button_action').val('insert');
                        $('#dataTable').DataTable().ajax.reload();
                        // $('#studentModel').modal('hide');
                      
                    }

                }

           });

        });

        $('#closeModal').click(function () {
            $('#jobModel').modal('hide');
        });

        $(document).on('click','.edit', function(){
            var id = $(this).attr("id");
        //    console.log(id);
            $.ajax({
                url:"{{ route('job.fetchdata') }}",
                method:'get',
                data:{id:id},
                dataType:'json',
                success:function(data)
                {
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#position').val(data.position);
                    $('#job_id').val(id);  
                    $('#jobModel').modal('show');
                    $('#action').val('Update');
                    $('.modal-title').text('Update Data');
                    $('#button_action').val('update');
                    $('#dataTable').DataTable().ajax.reload();
                }
            })
        });

        $(document).on('click','.delete', function(){
            var id = $(this).attr('id');

            if(confirm("Are you sure you want to delete this data?"))
            {
                $.ajax({
                url:"{{ route('job.removedata') }}",
                method:"get",
                data:{id:id},
                dataType:'json',
                success:function(data)
                {
                    alert(data);
                    $('#dataTable').DataTable().ajax.reload();
                }
            })

            }
            else
            {
                return false;
            }
        });

        $(document).on('click','#bulk_delete',function(){
           var id = [];

           if(confirm("Are you sure you want to delete this data?"))
           {
               $('.job_checkbox:checked').each(function(){
                id.push($(this).val());
               });
               if(id.length > 0)
               {
                   $.ajax({
                        url:"{{ route('job.massremove') }}",
                        method:"get",
                        data:{id:id},
                        success:function(data)
                        {
                            alert(data);
                            $('#dataTable').DataTable().ajax.reload();
                        }
                   });

               }
               else
               {
                    alert("Please select atleast one checkbox");
               }
           }

        });
    });

</script>
</body>
</html> 
