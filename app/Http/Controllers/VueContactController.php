<?php
namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VueContactController extends Controller
{

    /**
     * Validate contact info for inserting or updating the resource.
     *
     * @param Request $request
     */

    protected function validateContact(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:45',
            'surname' => 'required|max:45',
            'email' => 'required|email|max:20',
            'phone'=>'nullable|numeric',
            'groups'=>'nullable'
        ]);
    }


    /**
     * Validate search contact form
     *
     * @param Request $request
     */
    protected function validateSearch(Request $request)
    {
        $this->validate($request, [
            'name' => 'nullable|max:45',
            'surname' => 'nullable|max:45',
            'email' => 'nullable|email|max:20',
            'phone'=>'nullable|numeric',
            'groups'=>'nullable'
        ]);
    }


    /**
     * Render Vue Contact Book view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function manageVue()
    {
        return view('manageVueContact');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */


    public function search(Request $request)
    {
        $this->validateSearch($request);


        return response("OK", 200);
    }


    /**
     * List contacts
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */



    public function index(Request $request)
    {


        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $surname = $request->surname;
        $groups=$request->groups;

     /*   if (is_null($groups)) {
            $groups=Group::all('id')->pluck('id')->toArray();
        }*/
        $contacts = $this->searchContacts($name, $surname, $phone, $email, $groups)->paginate(5);





        $response = [

            'pagination' => [

                'total' => $contacts->total(),
                'per_page' => $contacts->perPage(),
                'current_page' => $contacts->currentPage(),
                'last_page' => $contacts->lastPage(),
                'from' => $contacts->firstItem(),
                'to' => $contacts->lastItem()

            ],

            'data' => $contacts

        ];


        return response()->json($response);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
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


        return response()->json($contact);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {

        $this->validateContact($request);


        $contact = Contact::findOrfail($id);

        $contact->name = $request->name;
        $contact->surname = $request->surname;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->groups()->sync($request->groups);

        $contact->save();




        return response()->json($contact);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {

        Contact::find($id)->delete();

        return response()->json(['done']);
    }


    /**
     * Filter contacts by the supplied parameters
     *
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
            ->where('email', 'like', "%$email%");

        if(count($groups)>0){
            $contacts=$contacts->whereHas('groups', function ($q) use ($groups) {
                $q->whereIn('groups.id', $groups);
            });
        }

        return $contacts;
    }
}
