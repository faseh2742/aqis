<?php

namespace App\Http\Controllers;

use App\Aptemplate;
use App\Client;
use App\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Clientap;
use App\Clientmeeting;
use Purifier;

class ClientapsController extends Controller
{

    public function index($id)
    {
        $clientaps = Clientemployment::where('client_id', $id)
            ->orderBy('id', 'DESC')->get();

        return $clientaps;
    }

    public function store(Request $request)
    {
        $clientap = Clientap::create([
            'aptemplate_id' => $request->aptemplate_id,
            'client_id' => $request->client_id,
            'clientmeeting_id' => $request->clientmeeting_id,
            'staff_id' => $request->staff_id,
            'noc' => serialize($request->noc),
            'credAssessment' => Purifier::clean($request->credAssessment),
            'certLicense' => Purifier::clean($request->certLicense),
            'docTranslation' => Purifier::clean($request->docTranslation),
            'training' => Purifier::clean($request->training),
            'localExperience' => Purifier::clean($request->localExperience),
            'altCareers' => Purifier::clean($request->altCareers),
            'mentoring' => Purifier::clean($request->mentoring),
            'portfolioWorkshop' => Purifier::clean($request->portfolioWorkshop),
            'otherResources' => Purifier::clean($request->otherResources),
        ]);

        foreach ((array) $request->certLicenseReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'certificationLicensing']);
        }
        foreach ((array) $request->credAssessmentReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'credentialAssessment']);
        }
        foreach ((array) $request->docTranslationReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'documentTranslation']);
        }
        foreach ((array) $request->trainingReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'training']);
        }
        foreach ((array) $request->localExperienceReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'localExperience']);
        }
        foreach ((array) $request->altCareersReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'alternativeCareer']);
        }
        foreach ((array) $request->mentoringReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'mentoringNetworking']);
        }
        foreach ((array) $request->portfolioWorkshopReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'portfolioWorkshop']);
        }
        foreach ((array) $request->otherResourcesReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'otherResources']);
        }

        $clientap->noc = unserialize($clientap->noc);
        $activity = new Activity();
        $activity->description = $clientap->client->user->username . " | Action Plan Saved";
        $activity->user_id = Auth::id();
        $activity->save();

        return $clientap;
    }

    public function show($id)
    {
        $clientap = Clientap::findOrFail($id);

        $clientap->noc = unserialize($clientap->noc);

        return $clientap;
    }

    public function update(Request $request, $id)
    {
        $clientap = Clientap::findOrFail($id);

        $clientap->update([
            'aptemplate_id' => $request->aptemplate_id,
            'client_id' => $request->client_id,
            'clientmeeting_id' => $request->clientmeeting_id,
            'staff_id' => $request->staff_id,
            'noc' => serialize($request->noc),
            'credAssessment' => Purifier::clean($request->credAssessment),
            'certLicense' => Purifier::clean($request->certLicense),
            'docTranslation' => Purifier::clean($request->docTranslation),
            'training' => Purifier::clean($request->training),
            'localExperience' => Purifier::clean($request->localExperience),
            'altCareers' => Purifier::clean($request->altCareers),
            'mentoring' => Purifier::clean($request->mentoring),
            'portfolioWorkshop' => Purifier::clean($request->portfolioWorkshop),
            'otherResources' => Purifier::clean($request->otherResources),
        ]);

        $clientap->referrals()->detach();

        foreach ((array) $request->certLicenseReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'certificationLicensing']);
        }
        foreach ((array) $request->credAssessmentReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'credentialAssessment']);
        }
        foreach ((array) $request->docTranslationReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'documentTranslation']);
        }
        foreach ((array) $request->trainingReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'training']);
        }
        foreach ((array) $request->localExperienceReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'localExperience']);
        }
        foreach ((array) $request->altCareersReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'alternativeCareer']);
        }
        foreach ((array) $request->mentoringReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'mentoringNetworking']);
        }
        foreach ((array) $request->portfolioWorkshopReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'portfolioWorkshop']);
        }
        foreach ((array) $request->otherResourcesReferrals as $referral) {
            $clientap->referrals()->attach($referral['id'], ['category' => 'otherResources']);
        }

        $clientap->noc = unserialize($clientap->noc);
        $activity = new Activity();
        $activity->description = $clientap->client->user->username . " | Action Plan Updated";
        $activity->user_id = Auth::id();
        $activity->save();
        return $clientap;
    }

    public function getReferrals($id, $category)
    {

        $clientap = Clientap::find($id);

        $referrals = $clientap->referrals()->where('category', $category)->get();

        return $referrals;
    }

    public function getAllReferrals($id)
    {
        $clientap = Clientap::find($id);

        $referrals = $clientap->referrals()->get();

        return $referrals;
    }

    public function destroy($id)
    {
        $clientap = Clientap::findorFail($id);
        $activity = new Activity();
        $activity->description = $clientap->client->user->username . " | Action Plan Deleted";
        $activity->user_id = Auth::id();
        $activity->save();
        $clientap->delete();

        return 204;
    }

    public function attachTemplates()
    {
        $clientaps = Clientap::where('aptemplate_id', 0)->get();

        $clientaps->each(function ($item, $key) {
            $aptemplate = Aptemplate::where('noc', $item->noc)->first();

            //            return $aptemplate;

            if ($aptemplate) {
                $item->aptemplate_id = $aptemplate->id;
            }
        });

        $clientaps->each(function ($item, $key) {
            $clientap = Clientap::find($item->id);

            $activity = new Activity();
            $activity->description = $clientap->client->user->username . " | Action Plan Template Attached";
            $activity->user_id = Auth::id();
            $activity->save();

            $clientap->aptemplate_id = $item->aptemplate_id;
            $clientap->save();
        });
    }
}
