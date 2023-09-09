<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //to show all listings
    public function index()
    {
        //filtering the data that gets displayed on the webpage based on the tag
        //tag is an array of tags/strings that are used to filter the data
        return view('listings.index', [
            'heading' => 'Latest Listings',
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    //to show a single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //to show listing create form
    public function create()
    {
        return view('listings.create');
    }

    //to store a listing
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            //listings is the name of the table and company i sthe name of the column in the table that the incopming data should be compared to to check for duplicates
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => 'required|email',  
            'tags' => 'required',
            'description' => 'required'
        ]);
        //to check if the incoming request has a file with the name logo
        if($request->hasFile('logo'))
        {
            //to store the logo in the public folder
            //the logo will be stored in the logos folder in the public folder
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        };
        //adding the current user id to the listing as an owner 
        $formFields['user_id'] = auth()->user()->id;

        //to create a new listing in the Listing table in the database
        Listing::create($formFields);

        

        return redirect('/')->with('message', 'Listing has been added');

    }


    //edit a listing
    public function edit(Listing $listing)
    {
        return view('listings.edit', [
            'listing' => $listing
        ]);
    }

    public function Update(Request $request, Listing $listing)
    {
        //make sure the user is authorized to edit the listing
        if(auth()->user()->id !== $listing->user_id)
        {
            abort(403, 'Unauthorized Action ');
        }   
        $formFields = $request->validate([
            'title' => 'required',
            //no need to check for duplicates since its an update and the company name might be the same
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => 'required|email',  
            'tags' => 'required',
            'description' => 'required'
        ]);
        //to check if the incoming request has a file with the name logo
        if($request->hasFile('logo'))
        {
            //to store the logo in the public folder
            //the logo will be stored in the logos folder in the public folder
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        };

        //to create a new version of listing in the Listing table in the database an dreplace the old one
        $listing->update($formFields);

        
        //takes the user back to the previous page
        return back()->with('message', 'Listing has been updated');

    }

    

    //delete a listing
    public function delete(Listing $listing)
    {
         //make sure the user is authorized to edit the listing
         if(auth()->user()->id !== $listing->user_id)
         {
             abort(403, 'Unauthorized Action ');
         }
        $listing->delete();

        return redirect('/')->with('message', 'Listing has been deleted');
    }

    //show user listings
    public function manage()
    {
        return view('listings.manage', [
            'listings' => auth()->user()->listings()->paginate(6)
        ]);
    }

}
