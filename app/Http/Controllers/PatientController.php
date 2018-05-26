<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CanUploadFiles;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\StorePatient;
use App\Http\Requests\UpdateTopicSubscriptionRequest;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\FcmToken;
use App\Models\Message;
use App\Models\NotificationSent;
use App\Models\NotificationTopic;
use App\Models\Patient;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PatientController extends _Controller
{
    use CanUploadFiles;

    const STORAGE_PATH = '/patients';
    const STORAGE_DISC = 'public';

    function __construct()
    {
        $this->transformer = Patient::transformer();
    }

    /**
     * Show patient (me)
     *
     * Shows logged patient's info
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function me()
    {
        /** @var Patient $patient */
        $patient = Auth::user();

        $patient->load('subscriptions.topic');

        $topics = NotificationTopic::where(['defaultSubscribed' => 1])
            ->whereNotIn('id', $patient->subscriptions->pluck('notification_topic_id'))
            ->get();

        $patient_formated = $this->prepareResponse($patient);
        $patient_formated['data']['clinicIds'] = $patient->clinics()->pluck('clinics.id');

        $subscriptions = collect($patient_formated['data']['subscriptions']->toArray());
        $subscriptions_inherited = $topics->map(function ($topic) {
            return [
                "subscribed" => true,
                "topic"      => NotificationTopic::transformer()->transform($topic)
            ];
        });
        $patient_formated['data']['subscriptions'] = $subscriptions->merge($subscriptions_inherited);


        return response()->json($patient_formated, 200);
    }

    /**
     * Show patient
     *
     * Shows a patient info specified by id
     *
     * @param Patient $patient
     * @return \Illuminate\Http\JsonResponse
     */
    function show(Patient $patient)
    {
        return $this->responseAsJson($patient);
    }

    /**
     * Creates patient
     *
     * Creates a new patient
     *
     * @param StorePatient $request
     * @return \Illuminate\Http\JsonResponse
     */
    function store(StorePatient $request)
    {
        $patient = Patient::create($request->all());

        return $this->responseAsJson($patient, 201);
    }

    /**
     * Updates patient (me)
     *
     * Updates the information of the patient logged
     *
     * @param StorePatient $request
     * @return \Illuminate\Http\JsonResponse
     */
    function updateMe(StorePatient $request)
    {
        return $this->update(Auth::user(), $request);
    }

    function updateMeTopics(UpdateTopicSubscriptionRequest $request)
    {
        return $this->updateTopicSubscriptions(Auth::user(), $request);
    }

    /**
     * Updates patient
     *
     * Updates a patient's info specified by id
     *
     * @param Patient $patient
     * @param StorePatient $request
     * @return \Illuminate\Http\JsonResponse
     */
    function update(Patient $patient, StorePatient $request)
    {
        $patient->fill(array_merge($request->except(['document', 'phones', 'tags', 'photo', 'subscriptions']), [
            'phones' => implode(';', $request->get('phones', [])),
            'tags'   => implode(';', $request->get('tags', [])),
        ]));

        if ($document = $request->get('document', false)) {
            $patient->document_type = $document['type'];
            $patient->document = $document['number'];
        }

        if ($base64_avatar = $request->get('photo', false)) {
            $avatar = base64_decode($base64_avatar, true);

            if ($avatar !== false) {
                $disk = Storage::disk(self::STORAGE_DISC);
                if ($patient->photo && $disk->exists($patient->photo)) {
                    $disk->delete($patient->photo);
                }

                $filename = $patient->id . '-' . time() . '.jpg';

                $patient->photo = $this->saveFile($filename, $avatar);
            }
        }

        if ($subscriptions = $request->get('subscriptions', false)) {
            $patient->subscriptions()->delete();

            $subscriptions = collect($subscriptions)->map(function ($subscription) {
                $subscription['notification_topic_id'] = $subscription['topic']['id'];

                return $subscription;
            })->toArray();

            $patient->subscriptions()->createMany($subscriptions);
        }

        $patient->update();

        $patient->load('subscriptions.topic');

        $patient_formated = $this->prepareResponse($patient);
        $patient_formated['data']['clinicIds'] = $patient->clinics()->pluck('clinics.id');

        $topics = NotificationTopic::whereNotIn('id', $patient->subscriptions->pluck('notification_topic_id'))->get();

        $subscriptions = collect($patient_formated['data']['subscriptions']->toArray());
        $subscriptions_inherited = $topics->map(function ($topic) {
            return [
                "subscribed" => $topic->defaultSubscribed == 1,
                "topic"      => NotificationTopic::transformer()->transform($topic)
            ];
        });
        $patient_formated['data']['subscriptions'] = $subscriptions->merge($subscriptions_inherited);


        return response()->json($patient_formated, 200);
    }

    function updateTopicSubscriptions(Patient $patient, UpdateTopicSubscriptionRequest $request)
    {
        $patient->load('subscriptions.topic');


        return $this->responseAsJson($patient->subscriptions, 200, NotificationSent::transformer());
    }

    function photoMe()
    {
        return $this->photo(Auth::user());
    }

    function photo(Patient $patient)
    {
        if (!$patient->photo) {
            abort(404);
        }

        return response()->download(storage_path() . '/app/' . $patient->photo, null, [], null);
    }

    function clinicsMe()
    {
        return $this->clinics(Auth::user());
    }

    function clinics(Patient $patient)
    {
        return $this->responseAsJson($patient->clinics, 200, Clinic::transformer());
    }

    function clinicMe(Clinic $clinic)
    {
        /** @var Patient $patient */
        $patient = Auth::user();

        if (!$patient->clinics->contains($clinic->id)) {
            return $this->responseAsJson(['message' => 'You can\'t access to the information of this clinic'], 403);
        }

        $clinic->last_visit = $patient->lastVisitInClinic($clinic)->with('dentist')->first();

        return $this->responseAsJson($clinic, 200, Clinic::transformer());
    }

    function information(Request $request)
    {
        /** @var Patient $patient */
        $patient = Auth::user();

        $patient->informations()->create(['information' => $request->get('information')]);

        return $this->responseAsJson([], 201);
    }

    function notifications()
    {
        /** @var Patient $patient */
        $patient = Auth::user();

        $notifications_unanswered = $patient->notificationsSent()
            ->with('scheduled')
            ->whereNull('answered_at')
            ->orderBy('sent_at', 'desc')
            ->get();

        $notifications_answered = $patient->notificationsSent()
            ->with('scheduled')
            ->whereNotNull('answered_at')
            ->orderBy('sent_at', 'desc')
            ->get();

        $unanswered = $this->prepareResponse($notifications_unanswered, NotificationSent::transformer());

        $answered = $this->prepareResponse($notifications_answered, NotificationSent::transformer());

        return response()->json([
            'data' => [
                'unanswered' => $unanswered['data'],
                'answered'   => $answered['data'],
            ]
        ], 200);
    }

    function updateNotification(NotificationSent $notificationSent, Request $request)
    {
        $action = $request->get('action');

        if ($action == 'read') {
            $notificationSent->read_at = new Carbon;
        }

        if ($action == 'answer') {
            $notificationSent->answered_at = new Carbon;
            $notificationSent->answer = $request->get('value');
        }

        $notificationSent->save();

        return $this->responseAsJson($notificationSent, 200, NotificationSent::transformer());
    }

    function nextAppointments()
    {
        /** @var Patient $patient */
        $patient = Auth::user();

        $next_appointments = $patient->appointments()
            ->with(['clinic', 'dentist'])
            ->whereDate('datetime', '>=', Carbon::now())
            ->get();

        return $this->responseAsJson($next_appointments, 200, Appointment::transformer());
    }

    function cancelAppointment(Appointment $appointment)
    {
        $this->authorize('cancel', $appointment);

        if ($appointment->datetime->diffInHours(Carbon::now()) <= 12) {
            return $this->responseAsJson(['message' => 'CANT_CANCEL_APPOINTMENT_IS_TO_SOON'], 403);
        }

        $appointment->delete();

        return $this->response204();
    }

    function messages()
    {
        /** @var Patient $patient */
        $patient = Auth::user();

        $messages = $patient->messages()->get();

        return $this->responseAsJson($messages, 200, Message::transformer());
    }

    function message($id)
    {
        /** @var Patient $patient */
        $patient = Auth::user();

        $message = $patient->messages()->where('messages.id', $id)->first();

        return $this->responseAsJson($message, 200, Message::transformer());
    }

    function messagesForClinic(Clinic $clinic)
    {
        /** @var Patient $patient */
        $patient = Auth::user();

        $message = $patient->messages()->where('clinic_id', $clinic->id)->get();

        return $this->responseAsJson($message, 200, Message::transformer());
    }

    function addFCMToken(Request $request)
    {
        $this->authorize('addFCMToken', Patient::class);

        $this->validate($request, ["token" => "required"]);

        /** @var Patient $patient */
        $patient = Auth::user();

        $fcmToken = new FcmToken();
        $fcmToken->fill(['fcm_token' => $request->get('token')]);

        $patient->fcmTokens()->delete();

        $patient->fcmTokens()->save($fcmToken);

        return $this->response204();
    }

    function visits()
    {
        $patient = Auth::user();

        $visits = $patient->visits()
            ->with([
                'clinic',
                'dentist',
                'treatments.buccal_zone',
                'treatments.treatment',
                'diagnosis.derivation',
                'parent',
            ])
            ->get();

        return $this->responseAsJson($visits, 200, Visit::transformer());
    }

    function revokeAccessToClinic(Clinic $clinic)
    {
        /** @var Patient $patient */
        $patient = Auth::user();

        $patient->clinics()->detach($clinic->id);

//        DB::table('clinic_patient')
//            ->where('patient_id', $patient->id)
//            ->where('clinic_id', $clinic->id)
//            ->update(['deleted_at' => DB::raw('NOW()')]);

        return $this->response204();
    }

    function createForClinic(Clinic $clinic, CreatePatientRequest $request)
    {
        $this->authorize('createForClinic', [Patient::class, $clinic]);

        //ver si existe un paciente
        //crear pacientClinic

        $patient = '';

        return $this->responseAsJson($patient, 201);
    }
}
