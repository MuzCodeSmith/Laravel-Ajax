<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Table</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Users List</h2>

    <button type="button" id="addUserBtn" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
    Add User
    </button>

    <div class="container mt-2 mb-4">
        <div class="input-group">
            <input type="text"  class="form-control" id="searchInput" placeholder="Search users...">
        </div>
    </div>

    <div id="user-table" >
        <span class="label label-default" >loading records...</span>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="addUpdateForm" >
                <form method="POST" id="addUserForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" autocomplete='off' class="form-control" id="name" name="name" placeholder="Enter full name" >
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" autocomplete='off' class="form-control" id="email" name="email" placeholder="Enter email" >
                    </div>
                    <div class="mb-3">
                        <label for="password" id="password-label" class="form-label">Password</label>
                        <input type="password" autocomplete='off' class="form-control" id="password" name="password" placeholder="Enter password" >
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="addUser" class="btn btn-primary">Add User</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
      
    </div>
  </div>
</div>


<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
        function fetchUsers(){
            $.ajax({
                url:'/fetch-users',
                type:'get',
                success:function(res){
                    $('#user-table').html('')   
                    $('#user-table').html(res)  
                }
            })
        }
        fetchUsers();


        // $('#addUserForm').submit(function(e){
        $('#addUser').on('click',function(e){
            e.preventDefault();

            var user_name = $('#name').val();
            var user_email = $('#email').val();
            var user_password = $('#password').val();
            
            $.ajax({
                url:'/create-user',
                type:'POST',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "name":user_name,
                    "email":user_email,
                    "password":user_password},
                success:function(res){
                    if(res){
                        console.log("user added successfully");
                        
                    fetchUsers();

                    //  Close the modal
                    $('#addUserModal').modal('hide');

                    //  Reset the form fields
                    $('#addUserForm')[0].reset();

                    }else{
                        console.log("failed to create user");
                    }
                }
            })
        })

        $(document).on('click','#addUserBtn',function(){
            $('#addUserModalLabel').text('Add User');
            $('#addUser').text('Add');
            $('#name').val('');
            $('#email').val('');
            $('#password').val('');
            $('#password-label').show();
            $('#password').show();
        });

        $(document).on('click','#delete-user',function(){
            var id = $(this).data('id');
            if(confirm("Are you really want to delete this record?")){
            var element = this;
            $.ajax({
                url:`delete-user/${id}`,
                type:'DELETE',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(res){
                    $(element).closest('tr').fadeOut();
                }
            })
            }
        })

        $(document).on('click','#edit-user',function(){
            var id = $(this).data('id');
            console.log(id)
            var element = this;
            $.ajax({
                url:`edit-user/${id}`,
                type:'GET',
                success:function(res){
                    var hiddenIdInput = `<input type="hidden" id="user_id" value="${res['id']}" name="">`;
                    $('#addUserForm').prepend(hiddenIdInput);
                    $('#addUserModalLabel').text('Update User');
                    $('#addUser').text('Update');
                    $('#name').val(res['name']);
                    $('#email').val(res['email']);
                    $('#password-label').hide();
                    $('#password').hide();
                    $('#addUser').addClass('updateUser');
                }
            })
        })

        $(document).on('click','.updateUser',function(){
            var id = $('#user_id').val();

            $.ajax({
                url:`update-user/${id}`,
                type:'PUT',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{
                    name:$('#name').val(),
                    email:$('#email').val()
                },
                success:function(res){
                    $('#addUserModal').modal('hide');
                    fetchUsers();
                }
            })
        })

        $('#searchInput').on('keyup',function(){
            var searchKey = $(this).val();
            $.ajax({
                url:'/search',
                type:'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{"key":searchKey},
                success:function(res){
                    $('#user-table').html('')   
                    $('#user-table').html(res)  
                }
            })
        })

    }); 
</script>
</body>
</html>
