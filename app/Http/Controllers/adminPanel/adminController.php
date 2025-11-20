<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
    public function listAdmins()
    {
        $admins = DB::table('admins')->select('id', 'name', 'surname', 'user_name')->get();
        return view('adminPanel.admins.list', ['admins' => $admins]);
    }

    public function createAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'user_name' => 'required|string|max:100|unique:admins,user_name',
            'password' => 'required|string|min:6|max:100',
        ], [
            'name.required' => __('common.name_required'),
            'surname.required' => __('common.surname_required'),
            'user_name.required' => __('common.user_name_required'),
            'user_name.unique' => __('common.user_name_unique'),
            'password.required' => __('common.password_required'),
            'password.min' => __('common.password_min'),
        ]);


        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        DB::table('admins')->insert([
            'name' => $request->name,
            'surname' => $request->surname,
            'user_name' => $request->user_name,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.admin_created_success')
        ]);
    }

    public function editAdmin(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:100',
            'surname' => 'sometimes|required|string|max:100',
            'user_name' => 'sometimes|required|string|max:100|unique:admins,user_name,' . $id,
            'password' => 'sometimes|nullable|string|min:6|max:100',
        ], [
            'name.required' => __('common.name_required'),
            'surname.required' => __('common.surname_required'),
            'user_name.required' => __('common.user_name_required'),
            'password.min' => __('common.password_min'),
        ]);



        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        $updateData = array_filter([
            'name' => $request->name,
            'surname' => $request->surname,
            'user_name' => $request->user_name,
            'password' => $request->password ? bcrypt($request->password) : null
        ]);

        DB::table('admins')->where('id', $id)->update($updateData);

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.admin_updated_success')
        ]);
    }

    public function deleteAdmin($id)
    {
        $admin = DB::table('admins')->where('id', $id)->first();

        if (!$admin) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.admin_not_found')
            ]);
        }

        DB::table('admins')->where('id', $id)->delete();

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.admin_deleted')
        ]);
    }
}