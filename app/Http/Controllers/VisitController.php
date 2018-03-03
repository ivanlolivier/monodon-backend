<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVisitRequest;
use App\Models\Clinic;
use App\Models\Derivation;
use App\Models\Diagnosis;
use App\Models\NotificationScheduled;
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

        if ($diagnosis->isPredefined()) {
            $diagnosis->predefined()->sync($diagnosis_request['predefined']);
            $diagnosis->load('predefined');
        }

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
        }

        $visit->diagnosis()->associate($diagnosis);
        $visit->save();

        if ($diagnosis->isPredefined()) {
            $assignments = $request->get('treatments');

            $treatments = collect($assignments)
                ->map(function ($assignment) use ($diagnosis, $patient) {
                    return (new TreatmentAssigned())->fill([
                        'patient_id'     => $patient->id,
                        'treatment_id'   => $assignment['treatment'],
                        'buccal_zone_id' => $assignment['buccal_zone'],
                        'is_finished'    => false,
                    ]);
                });

            $visit->treatments()->saveMany($treatments);
            $visit->load(['treatments.treatment', 'treatments.buccal_zone']);
        }

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

        // Indications
        Collect($request->get('indications'))->each(function ($notificationFields) use ($patient, $visit) {
            /** @var NotificationScheduled $notification */
            $notification = $visit->notificationsScheduled()->create([
                'patient_id'       => $patient->id,
                'title'            => $notificationFields['title'],
                'message'          => $notificationFields['message'],
                'possible_answers' => $notificationFields['possible_answers'],
                'type'             => $notificationFields['type'],
                'time_to_send'     => $notificationFields['time_to_send'],
                'start_sending'    => $notificationFields['start_sending'],
                'finish_sending'   => array_key_exists('finish_sending', $notificationFields) ? $notificationFields['finish_sending'] : null,
            ]);

            if (array_key_exists('periodicity', $notificationFields)) {
                Collect($notificationFields['periodicity'])->each(function ($period) use ($notification) {
                    $notification->periodicity()->create([
                        'value' => $period
                    ]);
                });
            }
        });
        $visit->load('notificationsScheduled.periodicity');

        return $this->responseAsJson($visit, 201);
    }
}
