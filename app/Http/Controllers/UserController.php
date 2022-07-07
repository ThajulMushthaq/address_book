<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    private $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel;
    }

    public function home()
    {
        $data['data'] = $this->userModel->get_data();
        // dd($data['data']);
        return view('welcome', $data);
    }

    public function save(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $values = array(
            'name' => @$request->get('name') ?: '',
            'email' => @$request->get('email') ?: '',
            'phone' => @$request->get('phone') ?: '',
            'address' => @$request->get('address') ?: '',
        );

        $id = $this->userModel->save_data($values);
        $data = $this->userModel->get_data_row($id);
        
        echo json_encode($data);
    }
    
    public function delete($id = 0)
    {
        $this->userModel->delete_data($id);
        return redirect()->back()->with("success", "Item Deleted successfully!");
    }
}
