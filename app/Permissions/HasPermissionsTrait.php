<?php

namespace App\Permissions;

use App\Models\Permission;
use App\Models\Role;

trait HasPermissionsTrait {

   public function givePermissionsTo(... $permissions) {

    $permissions = $this->getAllPermissions($permissions);
    if($permissions === null) {
      return $this;
    }
    $this->permissions()->saveMany($permissions);
    return $this;
  }

  public function withdrawPermissionsTo( ... $permissions ) {

    $permissions = $this->getAllPermissions($permissions);
    $this->permissions()->detach($permissions);
    return $this;

  }

  public function refreshPermissions( ... $permissions ) {

    $this->permissions()->detach();
    return $this->givePermissionsTo($permissions);
  }

  public function hasPermissionTo($slug) {
    if($this->isAdmin()) {
      return true;
    }
    $permission= Permission::where('slug', $slug)->first();
    if($permission){
     return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }
    return false;
  }

  /*public function hasPermissionTo($permission) {

    return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
  }
 */
  public function hasPermissionThroughRole($permission) {
    foreach ($permission->roles as $role){
      if($this->roles->contains($role)) {
        return true;
      }
    }
    return false;
  }
  public function getRole() {
    return $this->roles()->first()->name;
  }

  public function hasRole( ... $roles ) {

    foreach ($roles as $role) {
      if ($this->roles->contains('slug', $role)) {
        return true;
      }
    }
    return false;
  }

  public function isSuperAdmin(){
    if($this->roles->contains('slug', 'super-admin')){
      return true;
    }
    return false;
  }
  
  public function isAdmin(){
    if($this->roles->contains('slug', 'admin') || $this->isSuperAdmin()){
      return true;
    }
    return false;
  }

  public function roles() {

    return $this->belongsToMany(Role::class,'admins_roles');

  }
  public function permissions() {

    return $this->belongsToMany(Permission::class,'admins_permissions');

  }
  protected function hasPermission($permission) {

    return (bool) $this->permissions->where('slug', $permission->slug)->count();
  }

  protected function getAllPermissions(array $permissions) {

    return Permission::whereIn('slug',$permissions)->get();
    
  }

}