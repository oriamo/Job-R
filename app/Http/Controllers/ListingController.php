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
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
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

        //to create a new listing in the Listing table in the database
        Listing::create($formFields);

        

        return redirect('/')->with('message', 'Listing has been added');

    }
}
