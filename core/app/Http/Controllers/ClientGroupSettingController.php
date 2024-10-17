<?php

namespace App\Http\Controllers;

use App\Models\ClientGroups;
use Illuminate\Http\Request;

class ClientGroupSettingController extends Controller
{
    public function updateSettings(Request $request, ClientGroups $group) {
        // Update group settings
        $group->settings()->update([
            'symbol'    => $request->symbol,
            'spread'    => $request->spread,
            'lots'      => $request->lots,
            'leverage'  => $request->leverage,
            'level'     => $request->level,
        ]);

        return redirect()->back()->with('success', 'Group settings updated successfully.');
    }
}
