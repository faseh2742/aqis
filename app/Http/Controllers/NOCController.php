<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;
use function GuzzleHttp\json_encode;

class NOCController extends Controller
{
    public function getNoc()
    {
        try {
            $soapclient = new SoapClient('https://cnp-noc.services.gc.ca/WebServices/Service.asmx?wsdl');

            $noclist = $soapclient->GetUnitGroup([
                'strUnitGroupNumber' => '*',
                'bytIsTitleRequired' => '1',
                'strTitle' => '',
                'bytTitleSearchType' => '0',
                'bytIsDescReq' => '0',
                'strDesc' => '',
                'bytDescSearchType' => '0',
                'bytIsAltRequired' => '0',
                'bytInAltOrRegular' => '0',
                'bytAndOr' => '0',
                'bytIsEffectDateReq' => '0',
                'strEffectDate' => '',
                'bytEffectDateRange' => '0',
                'bytIsRecordIDReq' => '0',
                'bytSortOrder' => '0',
                'bytSortField' => '0',
                'bytLangIn' => '0',
                'bytLangOut' => '0',
                'strToken' => 'NKpmmwHtYIFTXiaMPQIwLSspjlWHxqpFhhVQpeLzjutafGyAAdJocwhxvLtknxyFpbjMNmLzKBWqZqqjPfvZmXCdsPAcbKEZ',
                'strYear' => '2016',
            ]);

            // $noclist = var_dump($noclist);
            $xml = simplexml_load_string($noclist->GetUnitGroupResult);

            $json = json_encode($xml);
            $array = json_decode($json, true);

            // $array = json_decode(json_encode($noclist), true);
            // $array = array($noclist);

            // foreach ($array as $item) {
            //     // echo '<pre>';
            //     return $item;
            // }
            return $array;

            // print_r($array);

        } catch (\Throwable $th) {
            echo $th;
        }
    }
}
