<?php

namespace App\Http\Controllers\Clinics;

use App\Http\Controllers\_Controller;
use App\Http\Requests;
use App\Models\Clinic;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends _Controller
{
    public function __construct()
    {
        $this->transformer = Message::transformer();
    }

    public function listof(Clinic $clinic)
    {
        //$this->authorize('listForClinic', [Message::class, $clinic]);

        $messages = $clinic->messages()->with('employee')->with('dentist')->get();

        return $this->responseAsJson($messages, 200);
    }

    public function show(Clinic $clinic, Message $message)
    {
        //$this->authorize('showForClinic', [$message]);

        $message->load('patients');

        return $this->responseAsJson($message, 200);
    }

    public function create(Clinic $clinic, Request $request)
    {
        //$this->authorize('createForClinic', [Message::class, $clinic]);

        $this->validate($request, [
            'title'        => ['required'],
            'message'      => ['required'],
            'is_broadcast' => ['required', 'boolean'],
            'patients'     => ['required_if:is_broadcast,false', 'array'],
            'patients.*'   => ['integer', 'exists:patients,id'],
            'topic'        => ['string', 'exists:notification_topics,code']
        ]);

        $message = new Message($request->only(['title', 'message', 'is_broadcast', 'topic']));
        if ($message->topic) {
            $message->is_broadcast = true;
        }

        $message->employee_id = $request->user()->id;

        /** @var Message $message */
        $message = $clinic->messages()->save($message);

        if (!$message->is_broadcast) {
            $message->patients()->attach($request->get('patients'));
        }

        $message->send();

        return $this->responseAsJson($message, 201);
    }
}
