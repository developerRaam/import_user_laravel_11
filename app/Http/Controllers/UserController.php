<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('user_form');
    }
    
    public function show(){
        $data['users'] = User::all();
        return view('show_user', $data);
    }

    public function store(Request $request)
    {
        
        $validator = $request->validate([
            'profile_image' => 'nullable|image|mimes:jpg,jpeg',
            'name' => 'required|string|max:25',
            'phone' => 'required|regex:/^\+1-\(\d{3}\) \d{3}-\d{4}$/',
            'email' => 'required|email|unique:users',
            'street_address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|in:CA,NY,AT',
            'country' => 'required|in:IN,US,EU',
        ]);

        if($request->file('profile_image') != null){
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $validator['profile_image'] = $imagePath;
        }

        User::create($validator);

        return redirect()->route('home')->with('success', 'User added successfully!');
    }

    public function edit($id){
        $data['user'] = User::find($id);
        return view('edit', $data);
    }

    public function update(Request $request, $id){
        
        $validator = $request->validate([
            'profile_image' => 'nullable|image|mimes:jpg,jpeg',
            'name' => 'required|string|max:25',
            'phone' => 'required|regex:/^\+1-\(\d{3}\) \d{3}-\d{4}$/',
            'street_address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|in:CA,NY,AT',
            'country' => 'required|in:IN,US,EU',
        ]);
        
        if($request->file('profile_image') != null){
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $validator['profile_image'] = $imagePath;
        }

        User::find($id)->update($validator);

        return redirect()->route('show')->with('success', 'User updated successfully!');
    }

    public function exportCSV()
    {
        $users = User::all();
        $csvFileName = time(). '_' .'users_data.csv';
        $file = fopen($csvFileName, 'w');

        // Headers
        fputcsv($file, ['ID', 'Profile Image', 'Name', 'Phone', 'Email', 'Street Address', 'City', 'State', 'Country', 'Created At', 'Updated At']);

        foreach ($users as $user) {
            fputcsv($file, [
                $user->id,
                $user->profile_image,
                $user->name,
                $user->phone,
                $user->email,
                $user->street_address,
                $user->city,
                $user->state,
                $user->country,
                $user->created_at,
                $user->updated_at,
            ]);
        }

        fclose($file);

        return response()->download($csvFileName)->deleteFileAfterSend(true);;
    }

    public function importCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,CSV',
        ]);

        $errors = [];

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_shift($csvData);
        $header_name = [];
        foreach ($header as $line) {
            $name = str_replace(' ', '_', strtolower($line));
            $header_name[] = $name;
        }
        
        foreach ($csvData as $row) {
            $rowData = array_combine($header_name, $row);
        
            // Skip row if critical fields are missing
            if (empty($rowData['email'])) {
                $messages[] = ['type' => 'error', 'message' => 'Missing email in row: ' . json_encode($row)];
                continue;
            }
        
            $user = User::where('email', $rowData['email'])->first();
        
            if ($user) {
                $messages[] = ['type' => 'error', 'message' => 'Duplicate email: ' . $rowData['email']];
            } else {
                try {
                    $validatedData = Validator::make($rowData, [
                        'profile_image' => 'nullable|string',
                        'name' => 'required|string|max:25',
                        'phone' => 'required',//|regex:/^\+1-\(\d{3}\) \d{3}-\d{4}$/',
                        'email' => 'required|email',
                        'street_address' => 'required|string',
                        'city' => 'required|string',
                        'state' => 'required|in:CA,NY,AT',
                        'country' => 'required|in:IN,US,EU',
                    ])->validate();
        
                    User::create($validatedData);

                    $messages[] = ['type' => 'success', 'message' => 'Success email: ' . $rowData['email']];
                } catch (\Exception $e) {
                    $messages[] = ['type' => 'error', 'message' => 'Error in row: ' . json_encode($row) . ' - ' . $e->getMessage()];
                }
            }
        }
        return redirect()->route('show')->with('messages', $messages);
    }


    public function delete($id){
        try {
            $user = User::findOrFail($id);
    
            // Delete the profile image if it exists
            if ($user->profile_image && Storage::exists($user->profile_image)) {
                Storage::delete($user->profile_image);
            }
    
            // Delete the user record
            $user->delete();
    
            return redirect()->route('show')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('show')->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

}
