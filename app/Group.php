<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Group.
 *
 * @author  The scaffold-interface created at 2017-02-24 04:51:53pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Group extends Model
{
	
	
    public $timestamps = false;
    
    protected $table = 'groups';

	

	/**
     * contact.
     *
     * @return  \Illuminate\Support\Collection;
     */
    public function contacts()
    {
        return $this->belongsToMany('App\Contact','contacts_groups');
    }

    /**
     * Assign a contact.
     *
     * @param  $contact
     * @return  mixed
     */
    public function assignContact($contact)
    {
        return $this->contacts()->attach($contact);
    }
    /**
     * Remove a contact.
     *
     * @param  $contact
     * @return  mixed
     */
    public function removeContact($contact)
    {
        return $this->contacts()->detach($contact);
    }



}
