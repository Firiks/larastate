<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealtorListingImageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Listing $listing
     *
     * @return \Inertia\ResponseFactory|\Inertia\Response
     */
    public function create(Listing $listing)
    {
        $listing->load(['images']);
        return inertia(
            'Realtor/ListingImage/Create',
            ['listing' => $listing]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\Listing $listing
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Listing $listing, Request $request)
    {
        if ($request->hasFile('images')) {
            $request->validate([
                'images.*' => 'mimes:jpg,png,jpeg,webp|max:5000'
            ], [
                'images.*.mimes' => 'The file should be in one of the formats: jpg, png, jpeg, webp'
            ]);

            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');

                $listing->images()->save(new ListingImage([
                    'filename' => $path
                ]));
            }
        }

        return redirect()->back()->with('success', 'Images uploaded!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Listing $listing
     * @param \App\Models\ListingImage $image
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Listing $listing, ListingImage $image)
    {
        Storage::disk('public')->delete($image->filename);
        $image->delete();

        return redirect()->back()->with('success', 'Image was deleted!');
    }
}
