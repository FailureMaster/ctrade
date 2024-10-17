<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\CoinPair;
use App\Models\Currency;
use App\Constants\Status;
use App\Models\MarketData;
use App\Models\ClientGroups;
use Illuminate\Http\Request;
use App\Models\ClientGroupUser;
use App\Models\ClientGroupSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Users;

class ClientGroupsController extends Controller
{
    public function index() {
        $pageTitle  = 'Manage Group';
        $symbols    = CoinPair::all();
    
        // Get the user IDs of users who are already in any group
        $usersInGroups = ClientGroupUser::pluck('user_id')->toArray();
    
        // Fetch users that are not in any group
        $users = User::whereNotIn('id', $usersInGroups)->get();

        $usersAll = User::all();

        $userAllArr = [];
        foreach ($usersAll as $all) {
            $userAllArr[] = ['name' => $all->firstname, 'id' => $all->id];
            
        }

        $userAllArrJson =$userAllArr;
    
        // Fetch client groups with related settings and users
        $groups = ClientGroups::with(['settings', 'groupUsers', 'groupUsers.user'])->get();
    
        return view('admin.groups.index', compact('pageTitle', 'users', 'symbols', 'groups', 'usersAll', 'usersInGroups', 'userAllArrJson'));
    }
    
    

    public function create(Request $request) {
       
       // Validate the request
       $request->validate([
            'groupName'      => 'required|string|max:255',
            'symbols'        => 'required|array', // Multiple symbols
            'users'          => 'required|array', // Multiple users
            'spread'         => 'required|numeric',
            'lots'           => 'required|numeric',
            'leverage'       => 'required|numeric',
            'level'          => 'required|numeric',
        ]);

         // Create the group
        $group = ClientGroups::create(['name' => $request->groupName]);

        // Set group trading settings for multiple symbols
        foreach ($request->symbols as $symbolId) {
            ClientGroupSetting::create([
                'client_group_id'       => $group->id,
                'symbol'                => $symbolId,
                'spread'                => $request->spread,
                'lots'                  => $request->lots,
                'leverage'              => $request->leverage,
                'level'                 => $request->level,
            ]);
        }

        foreach ($request->users as $user) {
            ClientGroupUser::create([
              'client_group_id'        => $group->id,
              'user_id'                 => $user
            ]);
        }

        // $group->groupUsers()->attach($request->users);

        return returnBack('Group created successfully!', 'success');
    }




    public function truncate()
    {
        try {
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            // Truncate the tables in the right order to avoid constraint issues
            DB::table('client_group_users')->truncate();
            DB::table('client_group_settings')->truncate();
            DB::table('client_groups')->truncate();
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            return response()->json(['message' => 'Tables truncated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to truncate tables', 'details' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {
        // Validate the request
        $request->validate([
            'groupName' => 'required|string|max:255',
            'symbols'   => 'required|array', // Multiple symbols
            'users'     => 'required|array', // Multiple users
            'spread'    => 'required|numeric',
            'lots'      => 'required|numeric',
            'leverage'  => 'required|numeric',
            'level'     => 'required|numeric',
        ]);
    
        // Find the group by ID
        $group = ClientGroups::findOrFail($id);
    
        // Update the group name
        $group->update(['name' => $request->groupName]);
    
        // Update group settings (delete existing settings first)
        ClientGroupSetting::where('client_group_id', $group->id)->delete();
        foreach ($request->symbols as $symbolId) {
            ClientGroupSetting::create([
                'client_group_id' => $group->id,
                'symbol'          => $symbolId,
                'spread'          => $request->spread,
                'lots'            => $request->lots,
                'leverage'        => $request->leverage,
                'level'           => $request->level,
            ]);
        }
    
        // Update users in the group (delete existing users first)
        ClientGroupUser::where('client_group_id', $group->id)->delete();
        foreach ($request->users as $userId) {
            ClientGroupUser::create([
                'client_group_id' => $group->id,
                'user_id'         => $userId,
            ]);
        }
    
        return returnBack('Group updated successfully!', 'success');
    }
    

}
