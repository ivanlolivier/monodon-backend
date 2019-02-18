<?php

namespace App\Http\Controllers;

use App\Models\PredefinedDiagnosis;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class DiagnosisTypesController extends _Controller
{
    public function index()
    {
        $diagnosis_types = PredefinedDiagnosis::all();

        return $this->responseAsJson($diagnosis_types, 200, PredefinedDiagnosis::transformer());
    }

    public function inustest()
    {
        $now = new Carbon();

        $client = new \SoapClient("http://monodon-backend.test/agestionpacientes_services.xml", [
            'soap_version' => SOAP_1_2,
            'exceptions'   => true,
            'trace'        => 1,
            'cache_wsdl'   => WSDL_CACHE_NONE,
            'encoding'     => 'UTF-8'
        ]);

        $environment = [
            'PRODUCTION' => 'P',
            'SANDBOX'    => 'F',
            'DEBUG'      => 'D'
        ];

        $HL7Message = '
            <ADT_A01 xmlns="urn:hl7-org:v2xml">
                <MSH.1>
                    <MSH.1>|</MSH.1>
                    <MSH.2>^~\&</MSH.2> 
                    <MSH.3>
                        <HD.1>Monodon</HD.1>
                    </MSH.3>
                    <MSH.4><HD.1>NOMBRE_ORGANIZACION_ENVIA</HD.1></MSH.4>
                    <MSH.5><HD.1>APP_RECIBE</HD.1></MSH.5>
                    <MSH.6><HD.1>NOMBRE_ORGANIZACION_RECIBE</HD.1></MSH.6>
                    <MSH.7><TS.1>' . $now->format('YmdHis') . '</TS.1></MSH.7>
                    <MSH.9>
                        <MSG.1>ADT</MSG.1>
                        <MSG.2>A01</MSG.2>
                        <MSG.3>ADT_A04</MSG.3>
                    </MSH.9>
                    <MSH.10>1234567</MSH.10> // <-- Identificador de este mensaje
                    <MSH.11><PT.1>' . $environment['SANDBOX'] . '</PT.1></MSH.11>
                    <MSH.12><VID.1>2.5</VID.1></MSH.12>
                </MSH>
                <EVN>
                    <EVN.2><TS.1>' . $now->format('YmdHis') . '</TS.1></EVN.2>
                </EVN>
                <PV1>
                    <PV1.2>U</PV1.2>
                </PV1>
                <PID>
                    <PID-3>
                        <CX.1>29223869</CX.1>
                        <CX.4>
                            <HD.1>AA_ASSE</HD.1>
                            <HD.2>2.16.858.2.10001442.72768.1</HD.2>
                            <HD.3>ISO</HD.3>
                        </CX.4>
                    </PID-3>
                    <PID-3>
                        <CX.1>29223869</CX.1>
                        <CX.4>
                            <HD.1>AA_ASSE</HD.1>
                            <HD.2>' . Config::get('oid.DNI.UY') . '</HD.2>
                            <HD.3>ISO</HD.3>
                        </CX.4>
                    </PID-3>
                    <PID.5>
                        <XPN.1>
                            <FN.1>LASTNAME</FN.1>
                        </XPN.1>
                        <XPN.2>FIRSTNAME</XPN.2>
                    </PID.5>
                    <PID.7>
                        <TS.1>DATE/TIME OF BIRTH</TS.1>
                    </PID.7>
                    <PID.8>SEX</PID.8>
                    <PID.13>TELEPHONE</PID.13>
                </PID>
            </ADT_A01>
        ';

        /*
        $HL7Message = [
            "MSH" => [
                "MSH.1"  => '|',
                "MSH.2"  => "^~\&",
                "MSH.3"  => ["HD.1" => 'Monodon'],
                "MSH.4"  => ["HD.1" => 'NOMBRE_ORGANIZACION_ENVIA'],
                "MSH.5"  => ["HD.1" => "APP_RECIBE"],
                "MSH.6"  => ["HD.1" => "NOMBRE_ORGANIZACION_RECIBE"],
                "MSH.7"  => ["TS.1" => $now->format('YmdHis')],
                "MSH.9"  => [
                    "MSG.1" => "ADT",
                    "MSG.2" => "A01",
                    "MSG.3" => "ADT_A04"
                ],
                "MSH.10" => "1234567", // <-- Identificador de este mensaje
                "MSH.11" => ["PT.1" => $environment['SANDBOX']],
                "MSH.12" => ["VID.1" => "2.5"]
            ],
            "EVN" => [
                "EVN.2" => ["TS.1" => $now->format('YmdHis')]
            ],
            "PV1" => ["PV1.2" => "U"],
            "PID" => [
                "PID-3" => [
                    "CX.1" => "29223869",
                    "CX.4" => [
                        "HD.1" => "AA_ASSE",
                        "HD.2" => "2.16.858.2.10001442.72768.1",
                        "HD.3" => "ISO",
                    ]
                ],
                "PID-3" => [
                    "CX.1" => "29223869",
                    "CX.4" => [
                        "HD.1" => "AA_ASSE",
                        "HD.2" => Config::get('oid.DNI.UY'),
                        "HD.3" => "ISO",
                    ]
                ]
            ]
        ];
        */

        try {
            dd($client->__getFunctions());
            $result = $client->__soapCall("crearPaciente", [new \SoapVar($HL7Message, XSD_ANYXML)]);
            $result = $client->__soapCall("crearPaciente", [new \SoapVar($HL7Message, XSD_ANYXML)]);
        } catch (\Exception $e) {
//            dd($e);
        }

        echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
    }
}
