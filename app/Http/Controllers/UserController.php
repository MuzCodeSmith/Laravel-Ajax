<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUsers(){
        return view("users-list");
    }
    public function fetchUsers(){
        $users = User::get();
        $response = '<table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';
        
        foreach($users as $user){
            $response .= "
            <tr>
                <td>".$user->id."</td>
                <td>".$user->name."</td>
                <td>".$user->email."</td>
                <td>".$user->password."</td>
                <td>
                    <button class='btn btn-success' id='edit-user' data-id='{$user->id}' data-bs-toggle='modal' data-bs-target='#addUserModal' >Edit</button>
                    <button class='btn btn-danger' id='delete-user' data-id='{$user->id}'>Delete</button>
                </td>
            </tr>";
        }

        $response .= '</tbody>
        </table>';

        return $response;

    }

    public function creatUser(Request $request){
        $userData = $request->all();
        $status = User::create([
            'name' =>$userData['name'],
            'email' =>$userData['email'],
            'password' =>$userData['password']
        ]);

        if($status){
            return true;
        }else{
            return false;
        }

    }

    public function deleteUser($id){
        $status = User::destroy($id);
        if($status){
            return 1;
        }else{
            return 0;
        }
    }

    public function editUser($id){
        $userData = User::find($id);
        return $userData;
    }
    public function updateUser($id, Request $request){
        $userData = User::find($id);
        if(!$userData){
            return false;
        }
        $status = $userData->update([
            'name'=>$request->name,
            'email'=>$request->email
        ]);
        if(!$status){
            return false;
        }else{
            return true;
        }
    }

    public function searchResults(Request $request){
        $searckKey = $request->key;
        $results = User::where('name','LIKE',"%$searckKey%")->orWhere('email','LIKE',"%{$searckKey}%")->get();

        $response = '<table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        foreach($results as $result){
            $response .= "
            <tr>
                <td>".$result->id."</td>
                <td>".$result->name."</td>
                <td>".$result->email."</td>
                <td>".$result->password."</td>
                <td>
                    <button class='btn btn-success' id='edit-user' data-id='{$result->id}' data-bs-toggle='modal' data-bs-target='#addUserModal' >Edit</button>
                    <button class='btn btn-danger' id='delete-user' data-id='{$result->id}'>Delete</button>
                </td>
            </tr>";
        }

        $response .= '</tbody>
        </table>';

        return $response;

    }
}
