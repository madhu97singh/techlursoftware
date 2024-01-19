<!DOCTYPE html>
<html>
<head>
    <title>Employee Management</title>
    <meta name="_token" content="{{csrf_token()}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <style>
      #indeximg{
        height: 70px;
        width: 70px;
      }
      #showimg{
        height: 150px;
        width: 150px;
      }
      #editimg{
        height: 300px;
        width: 300px;
      }
    
    </style>
</head>
<body>
    <div class="container">
    <div class="row mb-3 mt-5">
       <div class="col-lg-6">
          <h3>Employees List</h3>
       </div>
       <div class="col-lg-6 d-flex justify-content-lg-end align-items-center">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
           Add New Employee</button>
        </div>
    </div>
    <!-- this is table portion -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>DOB</th>
                <th>Salary</th>
                <th>Joining Date</th>
                <th>Relieving Date</th>
                <th>Contact Number</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <input type="hidden" name="edit_id" id="edit_id" value="{{$employee->id}}" />

            <tr>
                <td>{{$employee->id}}</td>
                <td>{{$employee->name}}</td>
                <td>{{$employee->dob}}</td>
                <td>{{$employee->salary}}</td>
                <td>{{$employee->joining_date}}</td>
                <td>{{$employee->relieving_date}}</td>
                <td>{{$employee->contact_number}}</td>
                <td>
                    @if ($employee->status === 'active')
                    <button class="btn btn-sm btn-success toggle-status" data-user="{{ $employee->id }}">
                        Click to Inactivate
                    </button>
                    @else
                    <button class="btn btn-sm btn-danger toggle-status" data-user="{{ $employee->id }}">
                        Click to Activate
                    </button>
                    @endif</td>
                <td>
                <a data-toggle="modal" id="smallButton" data-target="#smallModal" data-attr="{{ route('employee.delete',$employee->id) }}" title="Delete Project">
                    <i  class="fa fa-trash text-danger  fa-lg" aria-hidden="true"><span class="ml-2">Delete</span></i>
                </a>
                <button type="button" class="btn btn-success edit-button" data-user-id="{{$employee->id}}"  data-toggle="modal" data-target="#editModal">Edit</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- {{-- end table --}} -->
</div>
    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" class="text-center">Add New Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" style="display:none"></div>
                    <form method="post" action="{{ route('employee.store') }}" enctype="multipart/form-data">
                        @csrf
                     <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>  
                    <div class="mb-3 row">
                        <label for="dob" class="col-sm-2 col-form-label">DOB</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" name="dob" id="dob">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="salary" class="col-sm-2 col-form-label">Salary</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="salary" id="salary">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="joining_date" class="col-sm-2 col-form-label">Joining Date</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" name="joining_date" id="joining_date">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="relieving_date" class="col-sm-2 col-form-label">Relieving Date</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" name="relieving_date" id="relieving_date">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="contact_number" class="col-sm-2 col-form-label">Contact Number</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" name="contact_number" id="contact_number">
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="formSubmit">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLabel" class="text-center">Edit Employee Details</h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert edit-alert-danger text-danger" style="display:none"></div>
                    <form method="POST" action="{{ route('employee.update',$employee->id) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" data-user-id="{{$employee->id}}" name="edit_id" id="edit_id" value="{{$employee->id}}" />

                         <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="edit_name" id="edit_name" value="{{$employee->name}}">
                            </div>
                        </div>  
                        <div class="mb-3 row">
                            <label for="dob" class="col-sm-2 col-form-label">DOB</label>
                            <div class="col-sm-10">
                              <input type="date" class="form-control" name="edit_dob" id="edit_dob" value="{{$employee->dob}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="salary" class="col-sm-2 col-form-label">Salary</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="edit_salary" id="edit_salary" value="{{$employee->salary}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="joining_date" class="col-sm-2 col-form-label">Joining Date</label>
                            <div class="col-sm-10">
                              <input type="date" class="form-control" name="edit_joining_date" id="edit_joining_date" value="{{$employee->joining_date}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="relieving_date" class="col-sm-2 col-form-label">Relieving Date</label>
                            <div class="col-sm-10">
                              <input type="date" class="form-control" name="edit_relieving_date" id="edit_relieving_date" value="{{$employee->relieving_date}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="contact_number" class="col-sm-2 col-form-label">Contact Number</label>
                            <div class="col-sm-10">
                              <input type="number" class="form-control" name="edit_contact_number" id="edit_contact_number" value="{{$employee->contact_number}}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="editFormSubmit" data-user-id="{{$employee->id}}">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#formSubmit').click(function(e){
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/employee/store') }}",
                    method: 'post',
                    data: {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        dob: $('#dob').val(),
                        joining_date: $('#joining_date').val(),
                        relieving_date: $('#relieving_date').val(),
                        contact_number: $('#contact_number').val(),
                        salary: $('#salary').val(),
                    },
                    success: function(result){
                        if(result.errors)
                        {
                            $('.alert-danger').html('');

                            $.each(result.errors, function(key, value){
                                $('.alert-danger').show();
                                $('.alert-danger').append('<li>'+value+'</li>');
                            });
                        }
                        else
                        {
                            location.reload();
                            $('.alert-danger').hide();
                            $('#exampleModal').modal('hide');
                        }
                    }
                });
            });
        });

        $(document).ready(function(){
            $('#editFormSubmit').click(function(e){
                var userId = $(this).data('user-id');

                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/employee/') }}"+"/"+userId,
                    method: 'PATCH',
                    data: {
                        name: $('#edit_name').val(),
                        dob: $('#edit_dob').val(),
                        joining_date: $('#edit_joining_date').val(),
                        relieving_date: $('#edit_relieving_date').val(),
                        contact_number: $('#edit_contact_number').val(),
                        salary: $('#edit_salary').val(),
                    },
                    success: function(result){
                        if(result.errors)
                        {
                            $('.edit-alert-danger').html('');

                            $.each(result.errors, function(key, value){
                                $('.edit-alert-danger').show();
                                $('.edit-alert-danger').append('<li>'+value+'</li>');
                            });
                        }
                        else
                        {
                            location.reload();
                            $('.edit-alert-danger').hide();
                            $('#editModal').modal('hide');
                        }
                    }
                });
            });
        });
    </script>
     <script>
        $(document).ready(function () {
        $('.edit-button').on('click', function () {
            var userId = $(this).data('user-id');
            $.ajax({
                url: '/employee/' + userId + '/edit',
                method: 'GET',
                data : {userId:userId},
                success: function (data) {
                    $('#editModal').modal('show');
                }
            });
        });
    });
    </script>
    <script>
    $(document).on('click', '#smallButton', function(event) {
        if(confirm('Are you sure you want to delete this Record?')==false){
            e.preventDefault();
        }
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href, 
            type: 'GET',
            dataType: 'html',
            // return the result
            success:function(response) {
               location.reload();
            }
            , error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            }
            , timeout: 8000
        })
    });

    $('.toggle-status').click(function() {
        var userId = $(this).attr('data-user');
        $.ajax({
            type: 'POST',
            url: '/employees/' + userId ,
            data: {
                _token: '{{ csrf_token() }}',
                userId : userId
            },
            success: function(response) {
                location.reload();
            },
            error: function(error) {
                console.error(error);
                alert('Error toggling user status.');
            }
        });
    });

</script>
</body>
</html>