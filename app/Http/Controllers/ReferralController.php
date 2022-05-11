<?php

namespace App\Http\Controllers;

use App\Referral;
use Illuminate\Http\Request;
use \App\Rules\PhoneNumber;

class ReferralController extends Controller
{
    public function index()
    {
        $referrals = Referral::orderBy('name', 'asc')->with('categories')->paginate(10);

        return $referrals;
    }

    public function getAllReferrals()
    {
        $referrals = Referral::orderBy('name', 'asc')->with('categories')->get();

        return $referrals;
    }

    public function search(Request $request)
    {
//        $keyword =$request->input('string');
//        $resultReferrals = Referral::search($keyword)->take(10)->get();

        $resultReferrals = Referral::search($request->input('string'), null, true)
            ->with('categories')
            ->paginate(10);

        return $resultReferrals;
    }

    public function store(Request $request)
    {
        $phoneNumber = new PhoneNumber;
        $request->validate([
            'name' => 'required|string|max:255',
            'categories'=> 'required',
            'phone'=> ['nullable',  $phoneNumber],
        ]);

        $referral = Referral::create([
            'name' => $request->name,
            'community' => $request->community,
            'address' => $request->address,
            'phone' => $phoneNumber->formatPhoneNumber($request->phone),
            'website' => $request->website,
            'notes' => $request->notes,
        ]);
        $categories = array();

        foreach ($request->categories as $category) {
            $categories[] = $category['id'];
        }

        $referral->categories()->sync($categories);

        return $referral;
    }

    public function update(Request $request, $id)
    {
        $phoneNumber = new PhoneNumber;
        $request->validate([
            'name' => 'required|string|max:255',
            'categories'=> 'required',
            'phone'=> ['nullable',  $phoneNumber],
        ]);

        $referral = Referral::findOrFail($id);

        $referral->update([
            'name' => $request->name,
            'community' => $request->community,
            'address' => $request->address,
            'phone' => $phoneNumber->formatPhoneNumber($request->phone),
            'website' => $request->website,
            'notes' => $request->notes,
        ]);

//        $referral->categories()->detach();
//
//        foreach ($request->categories as $category) {
//            $referral->categories()->attach($category['id']);
//        }

        $categories = array();

        foreach ($request->categories as $category) {
            $categories[] = $category['id'];
        }

        $referral->categories()->sync($categories);

        return $referral;
    }

    public function show($id)
    {
        $referral = Referral::findOrFail($id);

        return $referral;
    }

    public function destroy($id)
    {
      $aptemplate = Referral::findorFail($id);
      $aptemplate->delete();

      return 204;
    }
}
