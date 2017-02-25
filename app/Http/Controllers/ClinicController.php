<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CanUploadFiles;
use App\Http\Requests\StoreClinic;
use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Patient;
use Illuminate\Support\Facades\Storage;

class ClinicController extends _Controller
{
    use CanUploadFiles;

    const STORAGE_PATH = '/clinics';
    const STORAGE_DISC = 'local';

    public function __construct()
    {
        $this->transformer = Clinic::transformer();
    }

    /**
     * Shows clinic
     *
     * Shows the information of a clinic specified by id
     *
     * @param Clinic $clinic
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Clinic $clinic)
    {
        $this->authorize('show', $clinic);

        return $this->responseAsJson($clinic);
    }

    /**
     * Creates clinic
     *
     * Creates a new clinic
     *
     * @param StoreClinic $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreClinic $request)
    {
        $clinic = Clinic::create([
            'name'    => $request->name,
            'address' => $request->address,
            'phones'  => implode(';', $request->phones),
        ]);

        return $this->responseAsJson($clinic, 201);
    }

    /**
     * Updates a clinic
     *
     * Updates a clinic
     *
     * @param Clinic $clinic
     * @param StoreClinic $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Clinic $clinic, StoreClinic $request)
    {
        $this->authorize('update', $clinic);

        $clinic->fill([
            'name'    => $request->get('name', null),
            'address' => $request->get('address', null),
            'phones'  => implode(';', $request->get('phones', [])),
            'email'   => $request->get('email', null)
        ]);

        if ($base64_logo = $request->get('logo', false)) {
            $logo = base64_decode($base64_logo, true);

            if ($logo !== false) {
                $disk = Storage::disk(self::STORAGE_DISC);

                if ($clinic->logo && $disk->exists($clinic->logo)) {
                    $disk->delete($clinic->logo);
                }

                $filename = $clinic->id . '-' . time() . '.jpg';

                $clinic->logo = $this->saveFile($filename, $logo);
            }
        }

        $clinic->update();

        return $this->responseAsJson($clinic);
    }

    public function patients(Clinic $clinic)
    {
        $this->authorize('patients', $clinic);

        $patients = $clinic->patients()->get();

        return $this->responseAsJson($patients, 200, Patient::transformer());
    }

    public function dentists(Clinic $clinic)
    {
        $this->authorize('dentists', $clinic);

        $dentists = $clinic->dentists()->get();

        return $this->responseAsJson($dentists, 200, Dentist::transformer());
    }

}
