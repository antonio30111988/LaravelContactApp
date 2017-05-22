<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
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
    	$gender = $request->input('gender');
		
    	$newContact = new Contact;
    	
		$newContact->name = $name;
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
     * @return \Illuminate\Http\Response
     */
    public function getAll() 
	{
    	//Get from cache or put in cache for 15 minutes
		$contacts = Cache::remember('contacts', 15, function() {
			return Contact::all();
		});
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
    public function edit(SaveUserContacts $request) 
	{
    	$id = $request->input('id');
		$name = $request->input('name');
    	$nick_name = $request->input('nick_name');
    	$email = $request->input('email');
    	$phone = $request->input('phone');
    	$address = $request->input('address');
    	$company = $request->input('company');
    	$birth_date = $request->input('birth_date');
    	$gender = $request->input('gender');
    	
		$contact = Contact::find($id);

    	$contact->name = $name;
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
