<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\User;

class MakeDummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$hasAdmin = User::find(1);
    	if(empty($hasAdmin)){
		    DB::table('users')->insert([
			    'id' => 1,
			    'name' => 'Admin',
			    'email' => 'admin@email.com',
			    'password' => Hash::make('123456'),
			    'remember_token' => bcrypt(str_random(10)),
			    'created_at' => Carbon::now(),
			    'updated_at' => Carbon::now(),
		    ]);
	    }
	    else {
    		echo "This user Already exist!!";
	    }

    }
}
