<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;
use Illuminate\Support\Facades\DB;
use URL;

/**
 * Class ContactController.
 *
 */
class ContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Index - contact';
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $surname = $request->surname;
        $groups=$request->groups;

        if(is_null($groups)){
            $groups=Group::all('id')->pluck('id')->toArray();
        }
        $contacts = $this->searchContacts($name, $surname, $phone, $email, $groups)->paginate(5);


//        return $contacts->get()->toJson();

        return view('contact.index', compact('contacts', 'title'));
    }

    /**
     * Returns a listing of the contacts given the search parameters in JSON.
     *
     * @return  \Illuminate\Http\Response
     */

    public function search(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $surname = $request->surname;
        $groups=$request->groups;

        if(is_null($groups)){
            $groups=Group::all('id')->pluck('id')->toArray();
        }
        $contacts = $this->searchContacts($name, $surname, $phone, $email, $groups)->paginate(5);
        return response()->json($contacts);
    }


    /**
     * Show the form for creating a new contact.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add a new contact';
        $contact = new Contact();

        $groups = Group::all()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->toArray();


        return view('contact.create', compact('title', 'contact', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact = new Contact();

        $this->validateContact($request);


        //Model has been validated, proceed to save in storage.
        $contact->name = $request->name;
        $contact->surname = $request->surname;
        $contact->email = $request->email;
        $contact->phone = $request->phone;

        DB::beginTransaction();

        $contact->save();
        $contact->groups()->sync($request->groups);
        $contact->save();

        DB::commit();



        return redirect('contact');
    }

    /**
     * Display the specified contact.
     *
     * @param    \Illuminate\Http\Request $request
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $title = 'Show  contact';

        if ($request->ajax()) {
            return URL::to('contact/' . $id);
        }

        $contact = Contact::findOrfail($id);
        return view('contact.show', compact('title', 'contact'));
    }

    /**
     * Show the form for editing the contact information.
     * @param    \Illuminate\Http\Request $request
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $title = 'Edit  contact';
        if ($request->ajax()) {
            return URL::to('contact/' . $id . '/edit');
        }

        $groups = Group::all()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->toArray();

        $contact = Contact::findOrfail($id);
        return view('contact.edit', compact('title', 'contact', 'groups'));
    }

    /**
     * Update the specified contact in storage.
     *
     * @param    \Illuminate\Http\Request $request
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {

        $this->validateContact($request);


        $contact = Contact::findOrfail($id);

        $contact->name = $request->name;
        $contact->surname = $request->surname;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        //$contact->groups()->sync($request->groups);

        $contact->save();


        return redirect('contact');
    }

    /**
     * Delete confirmation message by Ajaxis.
     *
     * @link      https://github.com/amranidev/ajaxis
     * @param    \Illuminate\Http\Request $request
     * @return  String
     */
    public function DeleteMsg($id, Request $request)
    {
        $msg = Ajaxis::MtDeleting('Warning!!', 'Would you like to
         remove This?', '/contact/' . $id . '/delete');

        if ($request->ajax()) {
            return $msg;
        }
    }

    /**
     * Remove the specified contact from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::findOrfail($id);
        $contact->delete();
        return URL::to('contact');
    }

    /**
     * Validate contact information before inserting or updating.
     * @param Request $request
     */
    protected function validateContact(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:45',
            'surname' => 'required|max:45',
            'email' => 'required|email|max:20',
            'phone'=>'nullable|numeric',
            'groups'=>'required'
        ]);
    }

    /**
     * @param $name
     * @param $surname
     * @param $phone
     * @param $email
     * @param $groups
     * @return mixed
     */
    protected function searchContacts($name, $surname, $phone, $email, $groups)
    {
        $contacts = Contact::where('name', 'like', "%$name%")
            ->with('groups')
            ->where('surname', 'like', "%$surname%")
            ->where('phone', 'like', "%$phone%")
            ->where('email', 'like', "%$email%")
            ->whereHas('groups', function ($q) use ($groups) {
                $q->whereIn('groups.id', $groups);
            });
        return $contacts;
    }







}
