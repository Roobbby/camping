<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camping;
use App\Models\User;
use App\Models\Recommendation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;


class CampController extends Controller
{
    public function dashboard()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);

        $recommendationCounts = Recommendation::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                                ->groupBy('date')
                                ->orderBy('date', 'asc')
                                ->pluck('count', 'date')
                                ->toArray();

        return view('back.index', compact('profileData', 'recommendationCounts'));
    }


    public function index()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        $data = Camping::paginate(10);
        return view('back.tools', compact('data','profileData'));
    }

    public function result()
    {
    $id = Auth::user()->id;
    $profileData = User::find($id);
    $recommendations = Recommendation::with('recommendedItems.camping')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

    return view('back.result', compact('recommendations','profileData'));
    }


    public function login()
    {
        return view('back.auth.login');
    }

    public function ActionLogin(Request $request)
    {
        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        if (Auth::Attempt($data)) {
            return redirect('dashboard');
        }else{
            session()->flash('alert', 'danger');
            session()->flash('message', 'Username atau Password Salah.');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'description' => 'required|string',
        ]);

        try {

            if ($request->file('cover')) {
                $file = $request->file('cover');
                $filename = date('Y') . '_' . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);

                $camping = new Camping([
                    'name' => $request->name,
                    'cover' => $filename,
                    'price' => $request->price,
                    'description' => $request->description,
                ]);

                $camping->save();

                session()->flash('alert', 'success');
                session()->flash('message', 'Data alat berhasil ditambahkan.');
            }
        } catch (\Exception $e) {
            session()->flash('alert', 'danger');
            session()->flash('message', 'Data alat gagal ditambahkan. Silakan coba lagi.');
        }

        return redirect()->route('data');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'description' => 'required|string',
        ]);

        try {
            $camping = Camping::find($id);

            $camping->name = $request->name;
            $camping->price = $request->price;
            $camping->description = $request->description;

            if ($request->file('cover')) {
                if ($camping->cover && file_exists(public_path('images/' . $camping->cover))) {
                    unlink(public_path('images/' . $camping->cover));
                }

                $file = $request->file('cover');
                $filename = date('Y') . '_' . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);

                $camping->cover = $filename;
            }

            $camping->save();

            session()->flash('alert', 'success');
            session()->flash('message', 'Data alat berhasil diperbarui.');
        } catch (\Exception $e) {

            session()->flash('alert', 'danger');
            session()->flash('message', 'Data alat gagal diperbarui. Silakan coba lagi.');
        }

        return redirect()->route('data');
    }

    public function destroy($id)
    {
        $camping = Camping::find($id);
        if ($camping->cover && Storage::exists('public/images/' . $camping->cover)) {
            Storage::delete('public/images/' . $camping->cover);
        }
        $camping->delete();
        session()->flash('alert', 'success');
        session()->flash('message', 'Data alat berhasil dihapus.');
        return redirect()->route('data');
    }

    public function deleteRecommendation($id)
    {
        $recommendation = Recommendation::findOrFail($id);

        $recommendation->recommendedItems()->delete();

        $recommendation->delete();

        session()->flash('alert', 'success');
        session()->flash('message', 'Data Hasil Rekomendasi berhasil dihapus.');
        return redirect()->back();
    }

    public function logout(){
        Auth::logout();
        session()->flash('alert', 'success');
        session()->flash('message', 'Anda telah Logout.');
        return redirect()->route('home');
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view ('back.auth.profile', compact('profileData'));
    }

    public function ActionProfile(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . auth()->user()->id,
            'phone' => 'required|numeric',
            'address' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048',
        ]);


        $user = auth()->user();


        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->phone = $validatedData['phone'];
        $user->address = $validatedData['address'];


        if ($request->hasFile('profile_image')) {

            // Delete the old profile image if it exists
            if ($user->profile && file_exists(public_path('images/profile/' . $user->profile))) {
                unlink(public_path('images/profile/' . $user->profile));
            }

            // Save the new profile image
            $imageName = time() . '.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('images/profile'), $imageName);
            $user->profile = $imageName;
        }


        $user->save();
        session()->flash('alert', 'success');
        session()->flash('message', 'Profile Anda Telah Berhasil di Update.');
        return redirect()->back();
    }
    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        try {
            $user->password = Hash::make($validatedData['new_password']);
            $user->save();

            session()->flash('alert', 'success');
            session()->flash('message', 'Password Anda Telah Berhasil diubah.');
        } catch (Exception $e) {
            session()->flash('alert', 'danger');
            session()->flash('message', 'Terjadi kesalahan saat mengubah password. Silakan coba lagi.');
        }

        return redirect()->back();
    }
}

