<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Toko;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.profile.index');
    }

    public function email()
    {
        return view('pages.profile.email');
    }

    public function toko()
    {
        $id = Auth::user()->id_toko;
        $toko = Toko::select('tokos.id', 'tokos.id_user', 'tokos.name AS name', 'tokos.phone', 'tokos.address', 'tokos.photo')->where('tokos.id', '=', $id)->get();
        $id_toko = Toko::select('tokos.id')->where('tokos.id', $id)->value('tokos.id');
        // dd($id);
        return view('pages.toko.index', compact('toko', 'id_toko'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'string|min:3|max:255|required',
        //     'phone' => 'required|numeric|min:1',
        //     'address' => 'required|string|min:3|max:255',
        //     // 'filephoto' => 'image|mimes:jpeg,jpg,png|max:2048',
        // ]);
        $users = Auth::user();
        $id = $users->id;
        $user = User::find($id);
    
        if ($request->image == null) {
            $image = $users->photo;
        } else {
            $image = $request->file('image')->store('profile');
            $gambar_path = $users->photo;
            if (Storage::exists($gambar_path)) {
                Storage::delete($gambar_path);
            }
        }

        $status = $user->update([
            'name' => $request->name,
            'phone' => $request->telp,
            'address' => $request->address,
            'photo' => $image,
        ]);
        if ($status) {
            request()->session()->flash('success', 'Profile successfully updated');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }
        return redirect()->route('profile.index');
    }

    public function email_store(Request $request)
    {
        $this->validate($request, [
            'password' => 'min:6',
            'confirmpassword' => 'required_with:password|same:password|min:6'
        ]);
        $id = Auth::user()->id;
        $user = User::find($id);
        $status = $user->update([
            'password' => Hash::make($request->password),
            'confirmpassword' => $request->confirmpassword,

        ]);
        if ($status) {
            request()->session()->flash('success', 'Profile successfully updated');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }
        return redirect()->route('profile.index');
    }

    public function toko_store(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'string|min:3|max:255|required',
        //     'phone' => 'required|numeric|min:1',
        //     'address' => 'required|string|min:3|max:255',
        //     // 'filephoto' => 'image|mimes:jpeg,jpg,png|max:2048',
        // ]);

        $image = $request->file('image')->store('toko');
        $status = Toko::create([
            'id_user' => Auth::user()->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => $image,
        ]);

        $lastid = $status->id;
        User::where('id', auth::user()->id)->update([
            'id_toko' => $lastid,
        ]);

        if ($status) {
            request()->session()->flash('success', 'Toko successfully Created');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }
        return redirect()->route('toko.index');
    }

    public function toko_update(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'string|min:3|max:255|required',
        //     'phone' => 'required|numeric|min:1',
        //     'address' => 'required|string|min:3|max:255',
        //     // 'filephoto' => 'image|mimes:jpeg,jpg,png|max:2048',
        // ]);
        $id = Auth::user()->id_toko;
        if ($request->image == null) {
            $image = $request->imageold;
        } else {
            $image = $request->file('image')->store('toko');
            $gambar_path = $request->imageold;
            if (Storage::exists($gambar_path)) {
                Storage::delete($gambar_path);
            }
        }

        $status = Toko::where('id', $id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => $image,
        ]);

        if ($status) {
            request()->session()->flash('success', 'Toko successfully updated');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }
        return redirect()->route('toko.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
