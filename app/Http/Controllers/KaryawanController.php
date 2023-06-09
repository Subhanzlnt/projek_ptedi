<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    public function data()
    {
        if (auth::user()->id_toko == null) {
            request()->session()->flash('error', 'complete your store profile first!');
            return redirect()->route('toko.index');
        } else {
            $karyawan = Karyawan::select('karyawans.id', 'karyawans.name', 'karyawans.email AS email', 'karyawans.phone', 'karyawans.address', 'karyawans.id_toko', 'users.role', 'users.email AS emails')->leftjoin('users', 'users.email', '=', 'karyawans.email')->where('karyawans.id_toko', auth::user()->id_toko)->get();
            return view('pages.karyawan.index', compact('karyawan'));
        }
    }

    public function user()
    {
        $karyawan = Karyawan::select('karyawans.id', 'karyawans.name', 'karyawans.email AS email', 'karyawans.phone', 'karyawans.address', 'karyawans.id_toko', 'users.role', 'users.email AS emails', 'users.photo', 'users.id AS id_user')->join('users', 'users.email', '=', 'karyawans.email')->where('karyawans.id_toko', auth::user()->id_toko)->get();
        // return $karyawan;
        return view('pages.karyawan.listuser', compact('karyawan'));
    }

    public function create()
    {
        return view('pages.karyawan.create');
    }

    public function store(Request $request)
    {

        $data = $request->except('_method', '_token', 'submit');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'email|min:3|max:255',
            'phone' => 'required|numeric|min:1',
            'address' => 'required|string|min:3|max:255',
            'id_toko' => 'required'
        ]);

        if ($validator->fails()) {

            return redirect()->Back()->withInput()->withErrors($validator);
        }

        if ($record = Karyawan::firstOrCreate($data)) {
            Session::flash('message', 'Karyawan Added Successfully!');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('karyawan.data');
        } else {
            Session::flash('message', 'Error occurred, Please try again!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect()->route('karyawan.data');
    }

    public function edit($id)
    {

        $karyawan = Karyawan::find($id);

        return view('pages.karyawan.edit')->with('karyawan', $karyawan);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_method', '_token', 'submit');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'email|min:3|max:255',
            'phone' => 'required|numeric|min:1',
            'address' => 'required|string|min:3|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->Back()->withInput()->witErrors($validator);
        }
        $karyawan = Karyawan::find($id);

        if ($karyawan->update($data)) {

            Session::flash('message', 'Update successfully!');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('karyawan.data');
        } else {
            Session::flash('message', 'Data not updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return Back()->withInput();
    }

    public function destroy($id)
    {

        Karyawan::destroy($id);

        Session::flash('message', 'Delete successfully!');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('karyawan.data');
    }

    public function userdestroy($id)
    {
        // $karyawan = Karyawan::select('email,id')->where('id', $id)->value('email');
        // $user = User::select('email,id')->where('email', $karyawan)->value('id');

        // return $user;
        $status = User::destroy($id);

        if ($status) {
            request()->session()->flash('success', 'Successfully Deleted');
            return redirect()->route('karyawan.user');
        } else {
            request()->session()->flash('error', 'Please try again!');
            return back();
        }
    }

    public function set_user($id)
    {
        $karyawan = Karyawan::find($id);
        // dd($karyawan);
        return view('pages.karyawan.setuser')->with('karyawan', $karyawan);
    }

    public function buatakun(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'name' => 'string|required|min:2',
            'email' => 'string|required|unique:users,email',
            'password' => 'required|min:6',
        ]);
        // $data = $request->all();
        // dd($data);
        // $check = $this->createregis($data);
        // Session::put('user', $data['email']);
        $status = User::create([
            'id_toko'  => $data['id_toko'],
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone'],
            'address'  => $data['address'],
            'role'     => 'karyawan',
            'status'   => 'active'
        ]);
        if ($status) {
            request()->session()->flash('success', 'Successfully registered');
            return redirect()->route('karyawan.data');
        } else {
            request()->session()->flash('error', 'Please try again!');
            return back();
        }
        // dd($data);
    }
}
