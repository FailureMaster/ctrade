<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = auth()->user();
        return view($this->activeTemplate . 'user.profile_setting', compact('pageTitle', 'user'));
    }

    public function submitProfile(Request $request)
    {

        $request->validate([
            'firstname' => 'required|string',
            'lastname'  => 'required|string',
            'image'     => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ], [
            'firstname.required' => 'First name field is required',
            'lastname.required'  => 'Last name field is required'
        ]);

        $user            = auth()->user();
        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;

        $user->address = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];

        if ($request->hasFile('image')) {
            try {
                $old         = @$user->image;
                $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change Password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required', 'confirmed', $passwordValidation]
        ]);

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = ['success', 'Password changes successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }

    public function updatePassword(Request $request)
    {
        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            // 'current_password' => 'required',
            'password' => ['required', 'confirmed', $passwordValidation]
        ]);

        $user = auth()->user();

        if( $request->has('current_password') ){
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                return response()->json(['success' => 'success', 'message' => 'Password changes successfully'], 200);
            } else {
                return response()->json(['success' => 'error', 'message' => 'The password doesn\'t match!'], 200);
            }
        }
        else{
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            return response()->json(['success' => 'success', 'message' => 'Password changes successfully'], 200);
        }
    }

    public function updateProfile(Request $request)
    {
        if( $request->ajax() ){
            
            $request->validate([
                'firstname' => 'required|string',
                'lastname'  => 'required|string',
                'image'     => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            ], [
                'firstname.required' => 'First name field is required',
                'lastname.required'  => 'Last name field is required'
            ]);
    
            $user            = auth()->user();
            $user->firstname = $request->firstname;
            $user->lastname  = $request->lastname;
    
            $user->address = [
                'address' => $request->address,
                'state' => $request->state,
                'zip' => $request->zip,
                'country' => @$user->address->country,
                'city' => $request->city,
            ];
    
            if ($request->hasFile('image')) {
                try {
                    $old         = @$user->image;
                    $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
                } catch (\Exception $exp) {
                    return response()->json(['success' => 'error', 'message' => 'Couldn\'t upload your image'], 200);
                }
            }
            
            if( $user->save() )
                return response()->json(['success' => 'success', 'message' => 'Profile updated successfully'], 200);
        }
        
        return abort(403, 'Unauthorized!');
    } 
}
