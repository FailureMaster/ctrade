<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\PermissionGroup;
use Illuminate\Support\Facades\DB;


class PermissionGroupController extends Controller
{
  // This is Controller for PermissionGroup
  public function index()
  {
    // This function opens View with list of all permission groups
    $pageTitle = 'Permission Groups';

    if (auth()->guard('admin')->user()->id != 1) {
      $groups = PermissionGroup::where('name', '!=', 'Administrator')->get();
    } else {
      $groups = PermissionGroup::all();
    }

    return view('admin.manage_admins.permission_group.index', compact('groups', 'pageTitle'));
  }

  public function getPermissionCollection()
  {
    // This function returns default permissions collection
    $group[1] = 'Post Management';
    $collect = collect([
      [
        'name' => 'manage-order',
        'label' => 'Manage Order',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'permission_groups',
        'label' => 'permission_groups',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'manage_admins',
        'label' => 'manage_admins',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'manage-currency',
        'label' => 'Manage Currency',
        'group' => $group[1],
        'value' => false,
      ],
    //   [
    //     'name' => 'manage-market',
    //     'label' => 'Manage Market',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
    //   [
    //     'name' => 'manage-coin-pair',
    //     'label' => 'Manage Coin Pair',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
      [
        'name' => 'manage-users',
        'label' => 'Manage Users',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'access-all-users',
        'label' => 'Access All Users',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'manage-sales-leads',
        'label' => 'Manage Sales Leads',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'change-user-type',
        'label' => 'Change User Type',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'add-remove-user-balance',
        'label' => 'Add/Remove User Balance',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'add-symbol',
        'label' => 'Add Symbol',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'delete-user',
        'label' => 'Delete User',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'payment-gateways',
        'label' => 'Payment Gateways',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'deposits',
        'label' => 'Deposits',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'withdraw',
        'label' => 'Withdrawals',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'support-ticket',
        'label' => 'Support Ticket',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'report',
        'label' => 'Report',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'general-setting',
        'label' => 'General Setting',
        'group' => $group[1],
        'value' => false,
      ],
    //   [
    //     'name' => 'cron-job-setting',
    //     'label' => 'Cron Job Setting',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
      [
        'name' => 'system-configuration',
        'label' => 'System Configuration',
        'group' => $group[1],
        'value' => false,
      ],
    //   [
    //     'name' => 'charge-setting',
    //     'label' => 'Charge Setting',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
    //   [
    //     'name' => 'wallet-setting',
    //     'label' => 'Wallet Setting',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
    //   [
    //     'name' => 'logo-favicon',
    //     'label' => 'Logo & Favicon',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
    //   [
    //     'name' => 'extensions',
    //     'label' => 'Extensions',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
      [
        'name' => 'kyc-setting',
        'label' => 'KYC Setting',
        'group' => $group[1],
        'value' => false,
      ],
    //   [
    //     'name' => 'notification-setting',
    //     'label' => 'Notification Setting',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
    //   [
    //     'name' => 'manage-section',
    //     'label' => 'Manage Section',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
    //   [
    //     'name' => 'maintenance-mode',
    //     'label' => 'Maintenance Mode',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
    //   [
    //     'name' => 'gdpr-cookie',
    //     'label' => 'GDPR Cookie',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
    //   [
    //     'name' => 'system',
    //     'label' => 'System',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
    //   [
    //     'name' => 'custom-css',
    //     'label' => 'Custom CSS',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
      [
        'name' => 'delete-admin',
        'label' => 'Delete Admin',
        'group' => $group[1],
        'value' => false,
      ],
    //   [
    //     'name' => 'delete-group',
    //     'label' => 'Delete Group',
    //     'group' => $group[1],
    //     'value' => false,
    //   ],
      [
        'name' => 'delete-group',
        'label' => 'Delete Group',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'access-lead-options',
        'label' => 'Access Lead Options',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'bulk-update-leads',
        'label' => 'Bulk Update Leads',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'assign-ip-address',
        'label' => 'Assign IP Address',
        'group' => $group[1],
        'value' => false,
      ],
      [
        'name' => 'view-notification',
        'label' => 'View Notification',
        'group' => $group[1],
        'value' => false,
      ],
      [
        "name" => "notification-to-all",
        "label" => "Notification to all",
        "group" => "Post Management",
        "value" => false
      ],
      [
        "name" => "banned-user",
        "label" => "Banned user",
        "group" => "Post Management",
        "value" => false
      ],

      // details page permissions
      [
        "name" => "email-verification",
        "label" => "Email verification",
        "group" => "Post Management",
        "value" => false
      ],

      [
        "name" => "mobile-verification",
        "label" => "Mobile verification",
        "group" => "Post Management",
        "value" => false
      ],

      [
        "name" => "2fa-verification",
        "label" => "2FA verification",
        "group" => "Post Management",
        "value" => false
      ],

      [
        "name" => "kyc-verification",
        "label" => "KYC verification",
        "group" => "Post Management",
        "value" => false
      ],
    ]);
    return $collect;
  }

  public function create()
  {
    // This function opens the View for Create Permission Group page
    // with defaule permissions in the form fields
    $pageTitle = 'Create User Group';

    $newPermission = $this->newGetPermissionCollection();

    return view('admin.manage_admins.permission_group.create', compact('pageTitle', 'newPermission'));
  }

  public function store(Request $request)
  {
    // This function actually Creates PermissionGroup (meaning, user group)
    // with the permissions set from $request
    $this->validate($request, [
      'name' => 'required',
    ]);
    try {
      if (!$request->has('permission')) {
        $request['permission'] = [];
      }
      // $permission = $this->getPermissionCollection()->map(function ($item, $key) use ($request) {
      //   $value = array_key_exists($item['name'], $request->permission) ? true : false;
      //   $item['value'] = $value;
      //   return $item;
      // });
 
      $permission = $this->saveGetPermissionCollection()->map(function ($item, $key) use ($request) {

          foreach( $item as $key => $val ){
              $value = array_key_exists($item[$key]['name'], $request->permission) ? true : false;
              $item[$key]['value'] = $value;
          }
  
          return $item;
      });

      $group = new PermissionGroup();
      $group->name = $request->name;
      $group->status = $request->has('status') ? 1 : 0;
      $group->permission = $permission->toJson();
      $group->save();

      $notify[] = ['success', 'Group Create Successful'];

      return redirect()->route('admin.manage_admins.permission_groups')->withNotify($notify);
      // return back()->with('success', 'Group Create Successful');
    } catch (\Exception $e) {

      return back()->with('alert', $e->getMessage());
    }
  }

  public function edit($id)
  {
    // dump($id);
    $pageTitle = 'User Group edit';
    $group = PermissionGroup::findOrFail($id);
    $permission = $this->getPermissionCollection()->map(function ($item, $key) use ($group) {

      $value = false;
      if ($per = $group->permissions()->where('name', $item['name'])->first()) {
        $value = $per['value'];
      };
      $item['value'] = $value;
      return $item;
    });

    $newPermission = $this->newGetPermissionCollection()->map(function ($item, $key) use ($group) {
        $value            = false;
        $activePermission = [];
   
        foreach( $group->permissions()[$key] as $val ){
            if( $val['value'] ) array_push($activePermission, $val['name']);
        }

        foreach( $item as $key => $val ){
            if( in_array($val['name'], $activePermission)){
              $item[$key]['value'] = true;
            }
        }

        return $item;
    });

    if (auth()->guard('admin')->user()->id != 1) {
        $permission = $permission->filter(function ($permission) {
            return $permission['value'] === true;
        });
    }

    return view('admin.manage_admins.permission_group.edit', compact('group', 'pageTitle', 'permission', 'newPermission'));
  }

  public function update(Request $request, $id)
  {
    // This function Updates existing user group
    $this->validate($request, [
      'name' => 'required',
    ]);
   
    try {
      if (!$request->has('permission')) {
        $request['permission'] = [];
      }

      $group = PermissionGroup::findOrFail($id);
      $existingGroup = $group->permission;
      $adminGroupExisting = [];
      $arrayGroup         = json_decode($existingGroup);
      $adminGroupExisting = array_merge($arrayGroup->language, $arrayGroup->{'notification setting'}, $arrayGroup->system);
      
      // Since there are hidden groups in permission,
      // We need to create this to prevent from updating hidden value
      // when the user updating is not the super admin
      foreach( $adminGroupExisting as $a ){
          if( $a->value )
            array_push($adminGroupExisting, $a->name );
      }

      $permission = $this->saveGetPermissionCollection()->map(function ($item, $key) use ($request, $adminGroupExisting) {
          foreach( $item as $key => $val ){

              if( auth()->guard('admin')->user()->id != 1 ){
                  $value = false;
                if( array_key_exists($item[$key]['name'], $request->permission) || in_array($item[$key]['name'], $adminGroupExisting) ){
                  $value = true;
                }
              }
              else{
                $value = array_key_exists($item[$key]['name'], $request->permission) ? true : false;
              }
              
              $item[$key]['value'] = $value;
          }
        
          return $item;
      });
      
      $group->name = $request->name;
      $group->status = $request->has('status') ? 1 : 0;
      $group->permission = $permission->toJson();
      $group->save();
      return back()->with('success', 'Group Update Successful');
    } catch (\Exception $e) {
      dd($e->getMessage());
      return back()->with('alert', $e->getMessage());
    }
  }

  public function getAdmins()
  {
    // This function lists some array of Admins and permission groups combined
    // wtf its Admin in the name
    $pageTitle = 'Worker list';
    if (auth()->guard('admin')->user()->id == 1) {
      $admins = Admin::get();
    } else {
      $admins = Admin::whereNot('id', 1)->get();
    }
    // dd($admins);
    $groups = PermissionGroup::whereStatus(1)->get();
    return view('admin.manage_admins.admin.index', compact('admins', 'pageTitle', 'groups'));
  }

  public function adminStore(Request $request)
  {
    // This function edits the Admin (wtf it's here?)
    $this->validate($request, [
      'name' => 'required:string',
      'username' => 'required:string:unique:admins',
      'email' => 'required:string:unique:admins',
      'password' => 'required:string',
      'group_id' => 'required',
    ]);
    // try {
    // `id` bigint(20) UNSIGNED NOT NULL,
    // `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    // `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    // `username` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    // `email_verified_at` timestamp NULL DEFAULT NULL,
    // `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    // `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    // `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    // `created_at` timestamp NULL DEFAULT NULL,
    // `updated_at` timestamp NULL DEFAULT NULL

    //       INSERT INTO `admins` (
    // `id`, 
    // `name`, 
    // `email`, 
    // `username`, 
    // `email_verified_at`, 
    // `image`, 
    // `password`, 
    // `remember_token`, 
    // `created_at`, 
    // `updated_at`) VALUES
    // (
    //   1, 
    //   'Super Admin', 
    //   'admin@site.com',
    //   'admin',
    //   NULL,
    //   '6238276ac25d11647847274.png',
    //   '$2y$10$el35r0DVW8rbSEx0xm5xDu5IsbxmiaA1CZe3tfeub4iA4HxD1QSxq', 
    //   '8T76MS12TDoSy5h11Zpjd2SJdLdm8eaRljohntFuPgDOp5kOiuAQD49AFipX',
    //   NULL, 
    //   '2022-03-28 08:17:02'
    //  );

    $admin = new Admin();
    $admin->name = $request->name;
    $admin->email = $request->email;
    $admin->username = $request->username;
    // $admin->email_verified_at = null;
    // $admin->image = null;
    $admin->password = bcrypt($request->password);
    $admin->remember_token = Str::random(10);
    // $admin->sct = $request->password;

    // $admin->created_at = now;
    // $admin->updated_at = now;
    $admin->permission_group_id = $request->group_id;
    $admin->save();
    return back()->with('success', 'Create Successful');
    // } catch (\Exception $e) {
    //   return back()->with('alert', $e->getMessage());
    // }
  }

  public function adminUpdate(Request $request, $id)
  {
   
    // if ($id == 1 && auth()->guard('admin')->user()->id !== 1) {
    //   return back()->with('alert', 'No access');
    // }
    $this->validate($request, [
      'name' => 'required:string',
      'username' => 'required:string:unique:admins',
      'email' => 'required:string:unique:admins',
      'group_id' => 'required',
      'password' => 'required|min:6',
    ]);
    
    try {
      $admin = Admin::findOrFail($id);
      $admin->name = $request->name;
      $admin->email = $request->email;
      $admin->username = $request->username;
      // $admin->email_verified_at = null;
      // $admin->image = null;
      if ($request->password) {
        $admin->password = bcrypt($request->password);
        $admin->remember_token = Str::random(10);
      }

      $admin->permission_group_id = $request->group_id;
    $admin->update();
      $notify[] = ['success', 'Admin password updated successfully'];
      return back()->withNotify($notify);
      
    } catch (\Exception $e) {
        $notify[] = ['error', $e->getMessage()];
        return back()->withNotify($notify);
   
    }
  }
  
    public function adminDelete(Admin $admin)
    {
        DB::transaction(
           
            function () use ($admin) {
                 DB::table('users_OLD')->where('owner_id', $admin->id)->update([
                    'owner_id' => null
                ]);
                
                $admin->delete();
            }
        );

        return returnBack('Admin deleted successfully', 'success');
    }
    
    public function permissionGroupDelete(PermissionGroup $permissionGroup)
    {
      try{

        DB::beginTransaction();

        $data = $permissionGroup;

        Admin::where('permission_group_id', $data->id)->update([
          'permission_group_id' => 2
        ]);

        $permissionGroup->delete();

        DB::commit();

        return returnBack('Permission Group deleted successfully', 'success');
      } 
      catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Failed to save data', 'message' => $e->getMessage()], 500);
      }
    }

    public function newGetPermissionCollection()
    {
      // This function returns default permissions collection
      $group[1] = 'Post Management';
      $collect = collect([

        'dashboard' => [
            [
              'name' => 'dashboard',
              'label' => 'Dashboard',
              'group' => $group[1],
              'value' => false,
            ]
        ],

        'all workers' => [
            [
              'name' => 'all-workers',
              'label' => 'All Workers',
              'group' => $group[1],
              'value' => false,
            ]
        ],

        'leads settings' => [
            [
              'name' => 'leads-status',
              'label' => 'Leads Status',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'import-leads',
              'label' => 'Import Leads',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'add-new-lead',
              'label' => 'Add New Lead',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'system-configuration',
              'label' => 'System Configuration',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'kyc-setting',
              'label' => 'KYC Setting',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'notification-to-all',
              'label' => 'Notification to All',
              'group' => $group[1],
              'value' => false,
            ],
        ],

        'manager groups' => [
            [
              'name' => 'permission-groups',
              'label' => 'Permission Group',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'banned-clients',
              'label' => 'Banned Clients',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'email-unverified',
              'label' => 'Email Unverified',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'mobile-unverified',
              'label' => 'Mobile Unverified',
              'group' => $group[1],
              'value' => false,
            ]
        ],

        'finance' => [
            [
              'name' => 'pending-deposits',
              'label' => 'Pending Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'approved-deposits',
              'label' => 'Approved Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'successful-deposits',
              'label' => 'Successful Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'rejected-deposits',
              'label' => 'Rejected Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'initiated-deposits',
              'label' => 'Initiated Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'all-deposits',
              'label' => 'All Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'withdrawal-methods',
              'label' => 'Withdrawal Methods',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'pending-withdrawal',
              'label' => 'Pending Withdrawals',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'approved-withdrawal',
              'label' => 'Approved Withdrawals',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'rejected-withdrawal',
              'label' => 'Rejected Withdrawals',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'all-withdrawal',
              'label' => 'All Withdrawals',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'automatic-gateways',
              'label' => 'Automatic Gateways',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manual-gateways',
              'label' => 'Manual Gateways',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'kyc-unverified',
              'label' => 'KYC Unverified',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'kyc-pending',
              'label' => 'KYC Pending',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'transaction-log',
              'label' => 'Transaction Log',
              'group' => $group[1],
              'value' => false,
            ],
        ],

        'manager trading' => [
            [
              'name' => 'open-orders',
              'label' => 'Open Orders',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'closed-orders',
              'label' => 'Closed Orders',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'margin-level',
              'label' => 'Margin Level',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage-symbols',
              'label' => 'Manage Symbols',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'vip-groups',
              'label' => 'VIP Groups',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'lots-volume',
              'label' => 'Lots volume',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'orders-fee',
              'label' => 'Orders fee',
              'group' => $group[1],
              'value' => false,
            ]
        ],

        'sales' => [
            [
              'name' => 'all-leads',
              'label' => 'All Leads',
              'group' => $group[1],
              'value' => false,
            ]
        ],

        'retention' => [
            [
              'name' => 'active-clients',
              'label' => 'Active Clients',
              'group' => $group[1],
              'value' => false,
            ]
        ],

        'reports' => [
            [
              'name' => 'email-notifications',
              'label' => 'Email Notifications',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'notifications',
              'label' => 'Notifications',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'logins',
              'label' => 'Logins',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'online-leads',
              'label' => 'Online Leads',
              'group' => $group[1],
              'value' => false,
            ],
        ],

        'support ticket' => [
            [
              'name' => 'pending-ticket',
              'label' => 'Pending Ticket',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'closed-ticket',
              'label' => 'Closed Ticket',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'answered-ticket',
              'label' => 'Answered Ticket',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'all-ticket',
              'label' => 'All Ticket',
              'group' => $group[1],
              'value' => false,
            ],
          ],
          'general setting' => [
              [
                'name' => 'general-setting',
                'label' => 'General Setting',
                'group' => $group[1],
                'value' => false,
              ],
          ],
          'logo & favicon' => [
              [
                'name' => 'logo-favicon',
                'label' => 'Logo & Favicon',
                'group' => $group[1],
                'value' => false,
              ],
          ],
          'permission items' => [
            [
              'name' => 'email-verification',
              'label' => 'Email verification',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => '2fa-verification',
              'label' => '2FA verification',
              'group' => $group[1],
              'value' => false,
            ],
            [
              "name" => "kyc-verification",
              "label" => "KYC verification",
              "group" => "Post Management",
              "value" => false
            ],
            [
              'name' => 'mobile-verification',
              'label' => 'Mobile verification',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage-users',
              'label' => 'Manage Users',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage-order',
              'label' => 'Manage Order',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage-currency',
              'label' => 'Manage Currency',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'deposits',
              'label' => 'Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'withdraw',
              'label' => 'Withdraw',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'report',
              'label' => 'Report',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'delete-admin',
              'label' => 'Delete Admin',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'delete-group',
              'label' => 'Delete Group',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage_admins',
              'label' => 'Manage Admins',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'view-notification',
              'label' => 'View Notification',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'add-remove-user-balance',
              'label' => 'Add remove user balance',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage-sales-leads',
              'label' => 'Manage Sales Leads',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage-retention-leads',
              'label' => 'Manage Retention Leads',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'delete-user',
              'label' => 'Delete User',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'access-all-users',
              'label' => 'Access all users',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'bulk-update-leads',
              'label' => 'Bulk Update Leads',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'change-user-type',
              'label' => 'Change User Type',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'remove-manual-gateway',
              'label' => 'Delete Manual Gateway',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'change-owner',
              'label' => 'Change Owner',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'modify-templates',
              'label' => 'Modify Templates',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'allow-user-type-test',
              'label' => 'Allow user type to test',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'export-leads',
              'label' => 'Export Leads',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'hide-unhide-comments',
              'label' => 'Allow user to hide or unhide comments',
              'group' => $group[1],
              'value' => false,
            ],
        ],
      ]);

      $adminCollect = collect([

        'language' => [
            [
              'name' => 'language',
              'label' => 'Language',
              'group' => $group[1],
              'value' => false,
            ],
        ],
        
        'notification setting' => [
            [
              'name' => 'global-template',
              'label' => 'Global Template',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'email-setting',
              'label' => 'Email Setting',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'sms-setting',
              'label' => 'SMS Setting',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'notification-templates',
              'label' => 'Notification Tempaltes',
              'group' => $group[1],
              'value' => false,
            ],
        ],

        'system' => [
            [
              'name' => 'application',
              'label' => 'application',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'server',
              'label' => 'server',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'cache',
              'label' => 'cache',
              'group' => $group[1],
              'value' => false,
            ],
        ],
      ]);

      if( auth()->guard('admin')->user()->id == 1 ){
        $collect = $collect->merge($adminCollect);
      }

      return $collect;
    }

    // This function returns default permissions collection for saving and updating
    public function saveGetPermissionCollection()
    {
      
      $group[1] = 'Post Management';
      $collect = collect([

        'dashboard' => [
            [
              'name' => 'dashboard',
              'label' => 'Dashboard',
              'group' => $group[1],
              'value' => false,
            ]
        ],

        'all workers' => [
            [
              'name' => 'all-workers',
              'label' => 'All Workers',
              'group' => $group[1],
              'value' => false,
            ]
        ],

        'leads settings' => [
            [
              'name' => 'leads-status',
              'label' => 'Leads Status',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'import-leads',
              'label' => 'Import Leads',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'add-new-lead',
              'label' => 'Add New Lead',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'system-configuration',
              'label' => 'System Configuration',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'kyc-setting',
              'label' => 'KYC Setting',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'notification-to-all',
              'label' => 'Notification to All',
              'group' => $group[1],
              'value' => false,
            ],
        ],

        'manager groups' => [
            [
              'name' => 'permission-groups',
              'label' => 'Permission Group',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'banned-clients',
              'label' => 'Banned Clients',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'email-unverified',
              'label' => 'Email Unverified',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'mobile-unverified',
              'label' => 'Mobile Unverified',
              'group' => $group[1],
              'value' => false,
            ]
        ],

        'finance' => [
            [
              'name' => 'pending-deposits',
              'label' => 'Pending Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'approved-deposits',
              'label' => 'Approved Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'successful-deposits',
              'label' => 'Successful Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'rejected-deposits',
              'label' => 'Rejected Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'initiated-deposits',
              'label' => 'Initiated Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'all-deposits',
              'label' => 'All Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'withdrawal-methods',
              'label' => 'Withdrawal Methods',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'pending-withdrawal',
              'label' => 'Pending Withdrawals',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'approved-withdrawal',
              'label' => 'Approved Withdrawals',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'rejected-withdrawal',
              'label' => 'Rejected Withdrawals',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'all-withdrawal',
              'label' => 'All Withdrawals',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'automatic-gateways',
              'label' => 'Automatic Gateways',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manual-gateways',
              'label' => 'Manual Gateways',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'kyc-unverified',
              'label' => 'KYC Unverified',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'kyc-pending',
              'label' => 'KYC Pending',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'transaction-log',
              'label' => 'Transaction Log',
              'group' => $group[1],
              'value' => false,
            ],
        ],

        'manager trading' => [
            [
              'name' => 'open-orders',
              'label' => 'Open Orders',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'closed-orders',
              'label' => 'Closed Orders',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'margin-level',
              'label' => 'Margin Level',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage-symbols',
              'label' => 'Manage Symbols',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'vip-groups',
              'label' => 'VIP Groups',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'lots-volume',
              'label' => 'Lots volume',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'orders-fee',
              'label' => 'Orders fee',
              'group' => $group[1],
              'value' => false,
            ]
        ],

        'sales' => [
            [
              'name' => 'all-leads',
              'label' => 'All Leads',
              'group' => $group[1],
              'value' => false,
            ]
        ],

        'retention' => [
            [
              'name' => 'active-clients',
              'label' => 'Active Clients',
              'group' => $group[1],
              'value' => false,
            ]
        ],

        'reports' => [
          [
            'name' => 'email-notifications',
            'label' => 'Email Notifications',
            'group' => $group[1],
            'value' => false,
          ],
          [
            'name' => 'notifications',
            'label' => 'Notifications',
            'group' => $group[1],
            'value' => false,
          ],
          [
            'name' => 'logins',
            'label' => 'Logins',
            'group' => $group[1],
            'value' => false,
          ],
          [
            'name' => 'online-leads',
            'label' => 'Online Leads',
            'group' => $group[1],
            'value' => false,
          ],
        ],

        'support ticket' => [
            [
              'name' => 'pending-ticket',
              'label' => 'Pending Ticket',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'closed-ticket',
              'label' => 'Closed Ticket',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'answered-ticket',
              'label' => 'Answered Ticket',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'all-ticket',
              'label' => 'All Ticket',
              'group' => $group[1],
              'value' => false,
            ],
          ],
          'general setting' => [
            [
              'name' => 'general-setting',
              'label' => 'General Setting',
              'group' => $group[1],
              'value' => false,
            ],
        ],

        'logo & favicon' => [
            [
              'name' => 'logo-favicon',
              'label' => 'Logo & Favicon',
              'group' => $group[1],
              'value' => false,
            ],
        ],

        'language' => [
            [
              'name' => 'language',
              'label' => 'Language',
              'group' => $group[1],
              'value' => false,
            ],
        ],

        
        'notification setting' => [
            [
              'name' => 'global-template',
              'label' => 'Global Template',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'email-setting',
              'label' => 'Email Setting',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'sms-setting',
              'label' => 'SMS Setting',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'notification-templates',
              'label' => 'Notification Tempaltes',
              'group' => $group[1],
              'value' => false,
            ],
        ],

        'system' => [
            [
              'name' => 'application',
              'label' => 'application',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'server',
              'label' => 'server',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'cache',
              'label' => 'cache',
              'group' => $group[1],
              'value' => false,
            ],
        ],

        'permission items' => [
            [
              'name' => 'email-verification',
              'label' => 'Email verification',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => '2fa-verification',
              'label' => '2FA verification',
              'group' => $group[1],
              'value' => false,
            ],
            [
              "name" => "kyc-verification",
              "label" => "KYC verification",
              "group" => "Post Management",
              "value" => false
            ],
            [
              'name' => 'mobile-verification',
              'label' => 'Mobile verification',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage-users',
              'label' => 'Manage Users',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage-order',
              'label' => 'Manage Order',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage-currency',
              'label' => 'Manage Currency',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'deposits',
              'label' => 'Deposits',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'withdraw',
              'label' => 'Withdraw',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'report',
              'label' => 'Report',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'delete-admin',
              'label' => 'Delete Admin',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'delete-group',
              'label' => 'Delete Group',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage_admins',
              'label' => 'Manage Admins',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'view-notification',
              'label' => 'View Notification',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'add-remove-user-balance',
              'label' => 'Add remove user balance',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage-sales-leads',
              'label' => 'Manage Sales Leads',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'manage-retention-leads',
              'label' => 'Manage Retention Leads',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'delete-user',
              'label' => 'Delete User',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'access-all-users',
              'label' => 'Access all users',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'bulk-update-leads',
              'label' => 'Bulk Update Leads',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'change-user-type',
              'label' => 'Change User Type',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'remove-manual-gateway',
              'label' => 'Delete Manual Gateway',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'change-owner',
              'label' => 'Change Owner',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'modify-templates',
              'label' => 'Modify Templates',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'allow-user-type-test',
              'label' => 'Allow user type to test',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'export-leads',
              'label' => 'Export Leads',
              'group' => $group[1],
              'value' => false,
            ],
            [
              'name' => 'hide-unhide-comments',
              'label' => 'Allow user to hide or unhide comments',
              'group' => $group[1],
              'value' => false,
            ],
        ],
      ]);

      return $collect;
    }
}
