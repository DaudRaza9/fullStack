<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([
            'roleName'=>'Admin',
            'permission'=>"[
                {resourceName: 'Home', read:true, write:true, update:true, delete:true,name:'/'},
                {resourceName: 'Tags', read:true, write:true, update:true, delete:true,name:'tags'},
                {resourceName: 'Category', read:true, write:true, update:true, delete:true,name:'category'},
                {resourceName: 'Create blogs', read:true, write:true, update:true, delete:true,name:'createBlog'},
                {resourceName: 'Blogs', read:true, write:true, update:true, delete:true,name:'blogs'},
                {resourceName: 'Admin Users', read:true, write:true, update:true, delete:true,name:'adminusers'},
                {resourceName: 'Role', read:true, write:true, update:true, delete:true,name:'role'},
                {resourceName: 'Assign Role', read:true, write:true, update:true, delete:true,name:'assignRole'},
            ]",
            'isAdmin'=>'1'
        ]);
    }
}
