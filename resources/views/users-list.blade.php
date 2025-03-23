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

    <button class="btn btn-primary mb-3" id="addUser" data-bs-toggle="modal" data-bs-target="#addUserModal">
        Fetch Users
    </button>
    <div id="user-table" >
        <span class="label label-default" >loading records...</span>
    </div>
</div>
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
    }); 
</script>
</body>
</html>
