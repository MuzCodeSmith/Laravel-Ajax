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
            </tr>";
        }

        $response .= '</tbody>
        </table>';

        return $response;

    }
}
