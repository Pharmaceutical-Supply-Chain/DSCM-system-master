<?php

namespace App\Http\Controllers\DashboardControllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use HttpResponses;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::where('descrition', 'Admin')->firstOrFail();
        
        if (Auth::user()->role_id === $role->id)
        {
            return UserResource::collection(
                User::all()
            );
        }
        
        return $this->error('', 'You are not authorized to make this request', 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $role = Role::where('descrition', 'Admin')->firstOrFail();
        
        if (Auth::user()->id === $user->id || Auth::user()->role_id === $role->id)
        {
            return new UserResource ($user);
        }

        return $this->error('', 'You are not authorized to make this request', 403);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->id === $user->id)
        {
            $user->update($request->all());

            return new UserResource ($user);
        }

        return $this->error('', 'You are not authorized to make this request', 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $role = Role::where('descrition', 'Admin')->firstOrFail();
        
        if (Auth::user()->id === $user->id || Auth::user()->role_id === $role->id)
        {
            $user->delete();
            $user->tokens()->delete();
            
            return $this->success([
                'message' => 'User Successfully Deleted'
            ]);
        }

        return $this->error('', 'You are not authorized to make this request', 403); 
    }

    public function getWholesalers ()
    {
        $role = Role::where('descrition', 'Wholesaler')->firstOrFail();
        
        return UserResource::collection(
            User::where('role_id', $role->id)->get()
        );
    }

    public function getRetailers ()
    {
        $role = Role::where('descrition', 'retailer')->firstOrFail();
        
        return UserResource::collection(
            User::where('role_id', $role->id)->get()
        );
    }

    public function getEmployees ()
    {
        $role = Role::where('descrition', 'Employee')->firstOrFail();
        
        return UserResource::collection(
            User::where('role_id', $role->id)->get()
        );
    }
}
