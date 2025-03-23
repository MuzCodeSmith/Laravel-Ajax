<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Users List</h2>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
    Add User
    </button>


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
        <div class="modal-body">
                <form method="POST" id="addUserForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" >
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" >
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" >
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

        $('#addUserForm').submit(function(e){
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
    }); 
</script>
</body>
</html>
