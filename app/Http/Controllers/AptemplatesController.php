<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Aptemplate;
use Purifier;
use App\Referral;
use App\Rules\UniqueNoc;
use Illuminate\Support\Arr;
class AptemplatesController extends Controller
{

    public function index()
    {
      $aptemplates = Aptemplate::with('updatedBy')->orderBy('id', 'DESC')->paginate(10);
      foreach ($aptemplates as $aptemplate) {
        $aptemplate->noc = unserialize($aptemplate->noc);
        $aptemplate->prevNoc = unserialize($aptemplate->prevNoc);
      }

      return $aptemplates;
    }
    public function find($noc){
      return Aptemplate::where("noc",$noc)->first();
    }

    public function search(Request $request)
    {
        $Arr=array();
        $toSearch= $request->input('string');
        $resultAptemplates = Aptemplate::where('noc','LIKE','a:2:{s:4:"code";s:4:"'.$request->input('string').'%')
    
            ->paginate(10);


        foreach ($resultAptemplates as $template) {
            $template->noc = unserialize($template->noc);

                 }

        return $resultAptemplates;

    }

    public function store(Request $request)
    {
        $request->noc = serialize($request->noc);

        $validatedData = $request->validate(
            [
            'noc' => ['required', new UniqueNoc],
            // 'prevNoc' => ['required', new UniqueNoc],
            ]
        );

      $aptemplate = Aptemplate::create([
        //   'noc' => serialize($request->noc),
          'noc' => $request->noc,
          'prevNoc' => '',
          'notes' => $request->notes,
          'user_id' => Auth::user()->id,
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
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'certificationLicensing']);
        }
        foreach ((array) $request->credAssessmentReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'credentialAssessment']);
        }
        foreach ((array) $request->docTranslationReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'documentTranslation']);
        }
        foreach ((array) $request->trainingReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'training']);
        }
        foreach ((array) $request->localExperienceReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'localExperience']);
        }
        foreach ((array) $request->altCareersReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'alternativeCareer']);
        }
        foreach ((array) $request->mentoringReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'mentoringNetworking']);
        }
        foreach ((array) $request->portfolioWorkshopReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'portfolioWorkshop']);
        }
        foreach ((array) $request->otherResourcesReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'otherResources']);
        }
        $aptemplate->noc = unserialize($aptemplate->noc);
      return $aptemplate;
    }

    public function show($id)
    {
        $aptemplate = Aptemplate::findorFail($id);

        $aptemplate->noc = unserialize($aptemplate->noc);
        if(!empty($aptemplate->prevNoc)){
            $data = unserialize($aptemplate->prevNoc);
            $aptemplate->prevNoc=$data['code'];

        }

        $aptemplate->credAssessment = Purifier::clean($aptemplate->credAssessment);

        return $aptemplate;
    }

    public function filter(Request $request, $id)
    {
        $categoriesPicked = $request->categoriesPicked;
        array_push($categoriesPicked, 'noc');
        array_push($categoriesPicked, 'id');

        $aptemplate = Aptemplate::find($id);

        $filteredTemplate = $aptemplate->only($categoriesPicked);
        $filteredTemplate['noc'] = unserialize($filteredTemplate['noc']);

        return $filteredTemplate;
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'noc' => 'required',
            'prevNoc' => 'required|max:4',
        ]);
            $searlizesPrevNoc=array();
            $searlizesPrevNoc['code']=$request->prevNoc;
            $searlizesPrevNoc['title']=$request->noc['title'];
            // return $searlizesPrevNoc;
        $aptemplate = Aptemplate::findorFail($id);
        $aptemplate->update([
            'noc' => serialize($request->noc),
            'prevNoc' => serialize($searlizesPrevNoc),
            'notes' => $request->notes,
            'user_id' => Auth::user()->id,
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

        $aptemplate->referrals()->detach();

        foreach ((array) $request->certLicenseReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'certificationLicensing']);
        }
        foreach ((array) $request->credAssessmentReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'credentialAssessment']);
        }
        foreach ((array) $request->docTranslationReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'documentTranslation']);
        }
        foreach ((array) $request->trainingReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'training']);
        }
        foreach ((array) $request->localExperienceReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'localExperience']);
        }
        foreach ((array) $request->altCareersReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'alternativeCareer']);
        }
        foreach ((array) $request->mentoringReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'mentoringNetworking']);
        }
        foreach ((array) $request->portfolioWorkshopReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'portfolioWorkshop']);
        }
        foreach ((array) $request->otherResourcesReferrals as $referral) {
            $aptemplate->referrals()->attach($referral['id'], ['category' => 'otherResources']);
        }

        $aptemplate->noc = unserialize($aptemplate->noc);
        $aptemplate->prevNoc = unserialize($aptemplate->prevNoc);

        return $aptemplate;

    }

    public function getReferrals($id, $category)
    {

        $aptemplate = Aptemplate::find($id);

        $referrals = $aptemplate->referrals()->where('category', $category)->get();

        return $referrals;
    }

    public function getAllReferrals($id)
    {
        $aptemplate = Aptemplate::find($id);

        $referrals = $aptemplate->referrals()->get();

        return $referrals;
    }

    public function destroy($id)
    {
      $aptemplate = Aptemplate::findorFail($id);
      $aptemplate->delete();

      return 204;
    }
}
