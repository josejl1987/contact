<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Model class for Groups table.
 */
class Group extends Model
{
    
    
    public $timestamps = false;
    
    protected $table = 'groups';

    

    /**
     * Many Many relation definition.
     *
     * @return \Illuminate\Support\Collection;
     */
    public function contacts()
    {
        return $this->belongsToMany('App\Contact', 'contacts_groups');
    }

    /**
     * Assign a contact.
     *
     * @param  $contact
     * @return mixed
     */
    public function assignContact($contact)
    {
        return $this->contacts()->attach($contact);
    }
    /**
     * Remove a contact.
     *
     * @param  $contact
     * @return mixed
     */
    public function removeContact($contact)
    {
        return $this->contacts()->detach($contact);
    }
}
