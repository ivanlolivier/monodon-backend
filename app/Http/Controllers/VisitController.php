<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVisitRequest;
use App\Models\Clinic;
use App\Models\Derivation;
use App\Models\Diagnosis;
use App\Models\Patient;
use App\Models\TreatmentAssigned;
use App\Models\Visit;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class VisitController extends _Controller
{
    public function __construct()
    {
        $this->transformer = Visit::transformer();
    }

    public function create(CreateVisitRequest $request, Patient $patient)
    {
        $this->authorize('create', Visit::class);

        $dentist = $request->user();
        $clinic = Clinic::find($request->get('clinic'));

        $visit = new Visit();
        $visit->patient()->associate($patient);
        $visit->dentist()->associate($dentist);
        $visit->clinic()->associate($clinic);

        $diagnosis_request = $request->get('diagnosis');
        if (array_key_exists('parent_diagnosis', $diagnosis_request)) {
            $diagnosis_request['parent_diagnosis_id'] = $diagnosis_request['parent_diagnosis'];
            unset($diagnosis_request['parent_diagnosis']);
        }
        $diagnosis = Diagnosis::create($diagnosis_request);

        if ($diagnosis->isDerivation()) {
            $derivation_contact = $diagnosis_request['contact'];
            $derivation = Derivation::create([
                'contact_name'  => $derivation_contact['name'],
                'contact_phone' => $derivation_contact['phone'],
                'contact_email' => $derivation_contact['email'],
                'reason'        => $diagnosis_request['derivation_reason']
            ]);
            $diagnosis->derivation()->save($derivation);
            $diagnosis->load('derivation');

        } elseif ($diagnosis->isTreatment()) {
            $assignments = $diagnosis_request['treatments'];

            $treatments = collect($assignments)
                ->map(function ($assignment) use ($diagnosis, $patient) {
                    return (new TreatmentAssigned())->fill([
                        'patient_id'     => $patient->id,
                        'treatment_id'   => $assignment['treatment'],
                        'buccal_zone_id' => $assignment['buccal_zone'],
                        'is_finished'    => false,
                    ]);
                });

            $diagnosis->treatments_assigned()->saveMany($treatments);

            $diagnosis->load(['treatments_assigned.treatment', 'treatments_assigned.buccal_zone']);
        }

        $visit->diagnosis()->associate($diagnosis);

        $visit->save();

        $visit->exploratory()->create(['mouth_photo' => $request->get('exploratory')]);
        $visit->load('exploratory');

        $interrogatory = Collect($request->get('interrogatory'))->map(function ($response) {
            return [
                'question_id' => $response['question'],
                'answer'      => $response['answer'],
            ];
        })->toArray();
        $visit->interrogatory()->createMany($interrogatory);
        $visit->load('interrogatory.question');

        return $this->responseAsJson($visit, 201);
    }
}
