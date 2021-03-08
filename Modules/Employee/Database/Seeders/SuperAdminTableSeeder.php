<?php

namespace Modules\Employee\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Employee\Entities\UserAdditional;
use App\User;
use App\Role;

class SuperAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $owner = new Role();
        $owner->name         = 'owner';
        $owner->display_name = 'Owner ALC Race'; // optional
        $owner->description  = ''; // optional
        $owner->save();

        $super = new Role();
        $super->name         = 'superadministrator';
        $super->display_name = 'Super Administrator'; // optional
        $super->description  = ''; // optional
        $super->save();

        $investor = new Role();
        $investor->name         = 'investor';
        $investor->display_name = 'Investor'; // optional
        $investor->description  = ''; // optional
        $investor->save();

        $staff = new Role();
        $staff->name         = 'staff';
        $staff->display_name = 'Staff ALC Race'; // optional
        $staff->description  = ''; // optional
        $staff->save();

        $investor = new Role();
        $investor->name         = 'storemanager';
        $investor->display_name = 'Store Manager'; // optional
        $investor->description  = ''; // optional
        $investor->save();
        
        /* -------------------- */

        $employee = new User;
        $employee->code = '65201913001';
        $employee->name = 'ALC Race';
        $employee->email = 'alcrace';
        $employee->password = bcrypt('123456');
        $employee->save();

        $additional = new UserAdditional;
        $additional->user_id = $employee->id;
        $additional->phone = '021234567';
        $additional->address = 'Gedung Patra Jasa (PT ALC)';
        $additional->save();
        $employee->attachRole(2);
        
        
        // $this->call("OthersTableSeeder");
    }
}
