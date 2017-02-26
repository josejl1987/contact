<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Model class for Contacts table.
 */
class Contact extends Model
{
    
    
    public $timestamps = false;
    
    protected $table = 'contacts';

    

    /**
     * group.
     *
     * @return \Illuminate\Support\Collection;
     */
    public function groups()
    {
        return $this->belongsToMany('App\Group', 'contacts_groups');
    }

    /**
     * Assign a group.
     *
     * @param  $group
     * @return mixed
     */
    public function assignGroup($group)
    {
        return $this->groups()->attach($group);
    }
    /**
     * Remove a group.
     *
     * @param  $group
     * @return mixed
     */
    public function removeGroup($group)
    {
        return $this->groups()->detach($group);
    }
}
