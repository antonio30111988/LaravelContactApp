<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use App\Contact;
use App\Http\Requests\SaveUserContacts;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Storage;
use Carbon\Carbon;
//vCard saved file .cvf-export
use JeroenDesloovere\VCard\VCard;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param VCard $vcard Object
     *
     * @return void
     */
    public function __construct(Vcard $vcard)
    {
        $this->middleware('auth');
        $this->vcard=$vcard;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contacts');
    }
    
    /**
     * Create contact
     *
     * @param SaveUserContacts $request
     *
     * @return \Illuminate\Http\Response
     */
    public function create(SaveUserContacts $request)
    {
        $name = $request->input('name');
        $nick_name = $request->input('nick_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $company = $request->input('company');
        $birth_date = $request->input('birth_date');
        
        if ($birth_date=="") {
            $birth_date=Carbon::now()->toDateString();
        }
        
        $gender = $request->input('gender');
        
        //save new contact
        $newContact = new Contact;
        $newContact->name = $name;
        $newContact->user_id = Auth::id();
        $newContact->nick_name = $nick_name;
        $newContact->email = $email;
        $newContact->phone = $phone;
        $newContact->address = $address;
        $newContact->company = $company;
        $newContact->birth_date = $birth_date;
        $newContact->gender = $gender;
        
        $newContact->save();
    }
    
    /**
     * Get contacts list
     *
     * @param $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $contacts=User::find(Auth::id())->contacts()->orderBy('id', 'DESC')->get();
    
        foreach ($contacts as $contact) {
            $contact->age=$contact->age();
            $contact->birth=$contact->birth_date->toDateString() ;
            switch ($contact->gender) {
                case "0";
                    $contact->gender="-";
                    $contact->gender_flag=0;
                break;
                case "1";
                    $contact->gender="Male";
                    $contact->gender_flag=1;
                break;
                case "2";
                    $contact->gender="Female";
                    $contact->gender_flag=2;
                break;
            }
        }
        return $contacts;
    }
    
    /**
     * Delete contact
     *
     * @param $request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $contact = Contact::find($id);
        $contact->delete();
    }
    
    /**
     * Updatecontact
     *
     * @param $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $nick_name = $request->input('nick_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $company = $request->input('company');
        
        $birth_date = $request->input('birth_date');
        if ($birth_date=="") {
            $birth_date=Carbon::now()->toDateString() ;
        }
        
        $gender = $request->input('gender');
        
        $messages =
        [
            'phone_number' => 'The :attribute field must start with 01.',
            'alpha_num_space' => 'The :attribute field can consist of only letters, numbers and spaces.',
        ];

        $validator = Validator::make($request->all(), Contact::updateRequestRules($id), $messages);
        
        //validation fails
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        } else {
            //update contact
            $contact = Contact::find($id);

            $contact->name = $name;
            $contact->user_id = Auth::id();
            $contact->nick_name = $nick_name;
            $contact->email = $email;
            $contact->phone = $phone;
            $contact->address = $address;
            $contact->company = $company;
            $contact->birth_date = $birth_date;
            $contact->gender = $gender;
            
            $contact->save();
        }
    }
    
    /**
     * Application Audit History
     *
     * @param Contact $contact object
     *
     * @return Json \Illuminate\Http\Response
     */
    public function listAppAudit(Contact $contact)
    {
        //get user contacts
        $contacts=User::find(Auth::id())->contacts()->orderBy('created_at', 'DESC')->get();
        
        //fetch audit rows
        foreach ($contacts as $contact) {
            $audit = $contact->audits()->orderBy('created_at', 'DESC')->first();
            $audit_arr['modified'] = $audit->getModified();
            $audit_arr['metadata'] = $audit->getMetadata();
            $audit_arr['created_at_formatted'] =Carbon::parse($audit_arr['metadata']['audit_created_at'])->format('d/m/Y H:i');
            $audits[]=$audit_arr;
        }
        return response()->json($audits);
    }
    
    /**
     * Export Contact/s to VD card
     *
     * @param $request
     *
     * @return \Illuminate\Http\Response
     */
    public function exportToVdCard(Request $request)
    {
        if ($request->input('id')!="") {
            $id=$request->input('id');
            $contact = Contact::find($id);
            $vcard=$this->vCardContactObject($contact);
        
            //saving path
            //$vcard->setSavePath( storage_path('/app/public/vcf'));
            $vcard->setSavePath( storage_path());
            
            $vcard->save();
            $vcard->download();
        }
        
        return false;
    }
    
    /**
     * Create Contact vCard content
     *
     * @param $contact
     *
     * @return VCard $vcard object
     */
    public function vCardContactObject($contact)
    {
        // define vcard
        $this->vcard = new VCard();
        $prefix = '';
        $suffix = '';

        // add personal data
        $this->vcard->addName($contact->name, '', $contact->nick_name, $prefix, $suffix);

        // add work data
        $this->vcard->addCompany($contact->company);
        $this->vcard->addJobtitle('');
        $this->vcard->addRole('');
        $this->vcard->addEmail($contact->email);
        $this->vcard->addPhoneNumber('', 'PREF;WORK');
        $this->vcard->addPhoneNumber($contact->phone, 'WORK');
        $this->vcard->addAddress(null, null, $contact->address, '', null, '', '');

        return $this->vcard;
    }
}
