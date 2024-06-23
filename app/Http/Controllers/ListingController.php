<?php

namespace App\Http\Controllers;

use App\Models\Listings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index()
    {
        return view('listing.index', [
            'listings' => Listings::latest()->filter(request(['tag', 'search']))
                ->simplePaginate(6)
        ]);
    }

    public function show(Listings $listing)
    {
        return view('listing.show', [
            'listing' => $listing
        ]);
    }

    public function create()
    {
        return view('listing.create');
    }


    public function store(Request $request)
    {

        $formField = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formField['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formField['user_id'] = auth()->id();


        Listings::create($formField);


        return redirect('/')->with('message', 'Listing created successfully');
    }

    //Show Edit Form
    public function edit(Listings $listing)
    {
        return view('listing.edit', ['listing' => $listing]);
    }

    //Update Listing Data
    public function update(Request $request, Listings $listing)
    {

        //Make sure logged in user is owner
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formField = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formField['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formField);

        return redirect("/listing/{$listing->id}")->with('message', 'Listing updated successfully');
    }


    public function delete(Listings $listing)
    {
        //Make sure logged in user is owner
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $listing->delete();

        return redirect('/')->with('message', 'Listing deleted successfully');
    }


    //Manage Listings
    public function manage()
    {
        return view('listing.manage', ['listings' => auth()->user()->listings]);
    }
}
