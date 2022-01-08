<?php
namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{   

    public function permission()
    {   
			// Creating admin roles and add permissions
			$admin_perm = Permission::where('slug','create-posts')->first();
			$admin_role = new Role();
			$admin_role->slug = 'admin';
			$admin_role->name = 'Admin';
			$admin_role->save();
			$admin_role->permissions()->attach($admin_perm);

			$admin_perm = Permission::where('slug','edit-posts')->first();
			$admin_role->permissions()->attach($admin_perm);

			$admin_perm = Permission::where('slug','view-posts')->first();
			$admin_role->permissions()->attach($admin_perm);

			$admin_perm = Permission::where('slug','delete-posts')->first();
			$admin_role->permissions()->attach($admin_perm);

			// Creating editor roles and add permissions
			$editor_perm = Permission::where('slug', 'edit-posts')->first();
			$editor_role = new Role();
			$editor_role->slug = 'editor';
			$editor_role->name = 'Editor';
			$editor_role->save();
			$editor_role->permissions()->attach($editor_perm);

			// Creating reader roles and add permissions
			$reader_perm = Permission::where('slug', 'edit-posts')->first();
			$reader_role = new Role();
			$reader_role->slug = 'reader';
			$reader_role->name = 'Reader';
			$reader_role->save();
			$reader_role->permissions()->attach($reader_perm);

			// Fetching roles
			$admin_role = Role::where('slug', 'admin')->first();
			$editor_role = Role::where('slug','editor')->first();
			$reader_role = Role::where('slug','reader')->first();

			// Creating permissions with the roles
			$createPosts = new Permission();
			$createPosts->slug = 'create-posts';
			$createPosts->name = 'Create Posts';
			$createPosts->save();
			$createPosts->roles()->attach($admin_role);

			$editPosts = new Permission();
			$editPosts->slug = 'edit-posts';
			$editPosts->name = 'Edit Posts';
			$editPosts->save();
			$editPosts->roles()->attach($admin_role);
			$editPosts->roles()->attach($editor_role);

			$deletePosts = new Permission();
			$deletePosts->slug = 'delete-posts';
			$deletePosts->name = 'Delete Posts';
			$deletePosts->save();
			$deletePosts->roles()->attach($admin_role);

			$viewPosts = new Permission();
			$viewPosts->slug = 'view-posts';
			$viewPosts->name = 'View Posts';
			$viewPosts->save();
			$viewPosts->roles()->attach($admin_role);
			$viewPosts->roles()->attach($reader_role);

			$admin = new User();
			$admin->name = 'Super Admin';
			$admin->email = 'super_admin@gmail.com';
			$admin->password = bcrypt('12345678');
			$admin->save();
			$admin->roles()->attach($admin_role);

			$admin_perm = Permission::where('slug','create-posts')->first();
			$admin->permissions()->attach($admin_perm);

			$admin_perm = Permission::where('slug','edit-posts')->first();
			$admin->permissions()->attach($admin_perm);

			$admin_perm = Permission::where('slug','view-posts')->first();
			$admin->permissions()->attach($admin_perm);

			$admin_perm = Permission::where('slug','delete-posts')->first();
			$admin->permissions()->attach($admin_perm);

			$editor = new User();
			$editor->name = 'Editor';
			$editor->email = 'editor@gmail.com';
			$editor->password = bcrypt('12345678');
			$editor->save();
			$editor->roles()->attach($editor_role);
			$editor_perm = Permission::where('slug','edit-posts')->first();
			$editor->permissions()->attach($editor_perm);


			$reader = new User();
			$reader->name = 'Reader';
			$reader->email = 'reader@gmail.com';
			$reader->password = bcrypt('12345678');
			$reader->save();
			$reader->roles()->attach($reader_role);
			$reader_perm = Permission::where('slug','view-posts')->first();
			$reader->permissions()->attach($reader_perm);

			return redirect()->back();
    }
}