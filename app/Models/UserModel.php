<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'user';

    public function get_data()
    {
        try {
            $query = DB::table($this->table)
                ->select('id', 'name', 'address', 'phone', 'email')
                ->get();
            return $query;
        } catch (Exception $e) {
            // dd($e);
        }
    }

    public function get_data_row($id = 0)
    {
        try {
            $query = DB::table($this->table)
                ->select('id', 'name', 'address', 'phone', 'email')
                ->where('id',$id)
                ->first();
            return $query;
        } catch (Exception $e) {
        }
    }

    public function save_data($data = array())
    {
        try {
            $id = DB::table($this->table)->insertGetId($data);
            return $id;
        } catch (Exception $e) {
        }
    }

    
    public function delete_data($id = 0)
    {
        DB::table($this->table)
            ->where('id', $id)
            ->delete();
    }
}
