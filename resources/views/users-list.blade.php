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

    <button class="btn btn-primary mb-3" id="fetchUsers" data-bs-toggle="modal" data-bs-target="#addUserModal">
        Fetch Users
    </button>
    <div id="user-table" >
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Muzaffar</td>
                <td>shakhmuzffar82@gmail.com</td>
                <td>*********</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('#fetchUsers').click(function(){
            $.ajax({
                url:'/fetch-users',
                type:'get',
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
