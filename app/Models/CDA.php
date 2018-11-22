<?php

namespace App\Models;

use App\Http\Requests\DatesRangeRequest;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use PHPHealth\CDA\ClinicalDocument;
use PHPHealth\CDA\DataType\TextAndMultimedia\CharacterString;
use PHPHealth\CDA\DataType\Identifier\InstanceIdentifier;
use PHPHealth\CDA\DataType\Code\LoincCode;
use PHPHealth\CDA\Elements\ConfidentialityCode;
use PHPHealth\CDA\DataType\Code\ConfidentialityCode as ConfidentialityCodeType;
use PHPHealth\CDA\Elements\Title;
use PHPHealth\CDA\Elements\EffectiveTime;
use PHPHealth\CDA\DataType\Quantity\DateAndTime\TimeStamp;
use PHPHealth\CDA\Elements\Id;
use PHPHealth\CDA\Elements\Code;
use PHPHealth\CDA\DataType\Name\PersonName;
use PHPHealth\CDA\DataType\Code\CodedValue;
use PHPHealth\CDA\RIM\Role\PatientRole;
use PHPHealth\CDA\DataType\Collection\Set;
use PHPHealth\CDA\RIM\Entity\Patient as CDAPAtient;
use PHPHealth\CDA\RIM\Participation\RecordTarget;
use PHPHealth\CDA\RIM\Participation\Author;
use PHPHealth\CDA\RIM\Role\AssignedAuthor;
use PHPHealth\CDA\RIM\Entity\AssignedPerson;
use PHPHealth\CDA\RIM\Entity\RepresentedCustodianOrganization;
use PHPHealth\CDA\RIM\Role\AssignedCustodian;
use PHPHealth\CDA\RIM\Participation\Custodian;
use PHPHealth\CDA\DataType\Name\EntityName;

class CDA extends _Model
{
    /** @var ClinicalDocument $clinicalDocument */
    private $clinicalDocument;

    protected $table = 'cdas';

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }

    public function generateForVisit(Visit $visit)
    {
        $now = new Carbon();

        $this->setBaseData($visit, $now);
        $this->setTitle('CDA generated for specific visit with MONODON');
        $this->saveFile($this->getFileName($visit, $now));
    }

    public function generateForMasterVisit(Visit $visit)
    {
        $now = new Carbon();

        $treatments_assigned = TreatmentAssigned::where('visit_id', $visit->id)->get();

        $progress = Progress::where(
            'treatment_assigned_id',
            $treatments_assigned->map(function (TreatmentAssigned $t) {
                return $t->id;
            })
        )->get();

        $follow_up_visits = Visit::where('progress_id', $progress->map(function (Progress $p) {
            return $p->id;
        }))->get();

        $this->setBaseData($visit, $now);
        $this->setTitle('CDA generated for a master visit with MONODON');
        $this->saveFile($this->getFileName($visit, $now, true));
    }

    public function generateForDateRangeForPatient(Dentist $dentist, Patient $patient, DatesRangeRequest $request)
    {
        $now = new Carbon();

        $visits = Visit::where('patient_id', $patient->id)
            ->where('dentist_id', $dentist->id)
            ->whereBetween('created_at', [$request->get('from'), $request->get('to')])
            ->get();

        //TODO: delete this
        $visit = $visits[0];

        $this->setBaseData($visit, $now);
        $this->setTitle('CDA generated for a master visit with MONODON');
        $this->saveFile($this->getFileName($visit, $now, true));
    }

    public function saveFile($filename)
    {
        $disk = Storage::disk('local');
        $disk->put($filename, $this->clinicalDocument->toDOMDocument()->saveXML());
    }

    /*********************
     * PRIVATE FUNCTIONS *
     *********************/

    private function setBaseData($visit, $now)
    {
        $this->clinicalDocument = new ClinicalDocument();
        $this->setId($now, $visit->id);
        $this->setCode($visit->diagnosis);
        $this->setEffectiveTime($now);
        $this->setConfidentialityCode();
        $this->setPatient($visit->patient);
        $this->setDentist($visit->dentist);
        $this->setCustodian();
    }

    private function getFileName(Visit $visit, $now, $isMasterVisit = false)
    {
        $patient_id = $visit->patient->id;
        $dentist_id = $visit->dentist->id;
        $visit_id = $visit->id;
        $master = $isMasterVisit ? '(Master)' : '';

        return "/cdas/patient-{$patient_id}/dentist-{$dentist_id}_visit-{$visit_id}{$master}_{$now->format('YmdHis')}.xml";
    }

    private function setId($now, $id)
    {
        $OID_monodon = Config::get('cda.OID.MONODONID');
        $ObjectPrefix = Config::get('cda.OID.ObjectPrefix');

        $this->clinicalDocument->setId(new Id(new InstanceIdentifier("{$ObjectPrefix}.{$OID_monodon}.67430.{$now->format('YmdHis')}.{$id}.1")));
    }

    private function setCode(Diagnosis $diagnosis)
    {
        //Calculate LOINC code considering diagnosis

        $this->clinicalDocument->setCode(new Code((new LoincCode('42349-1', 'REASON FOR REFERRAL'))));
    }

    private function setEffectiveTime($now)
    {
        $this->clinicalDocument->setEffectiveTime(new EffectiveTime(new TimeStamp(\DateTime::createFromFormat(\DateTime::ISO8601,
            $now->format(DateTime::ISO8601)))));
    }

    private function setConfidentialityCode()
    {
        $this->clinicalDocument->setConfidentialityCode(new ConfidentialityCode(ConfidentialityCodeType::create(ConfidentialityCodeType::NORMAL_KEY,
            ConfidentialityCodeType::NORMAL)));
    }

    private function setPatient(Patient $patient)
    {

        $patientIds = new Set(InstanceIdentifier::class);
        $patientIds->add(new InstanceIdentifier(Config::get('oid.DNI.UY') . $patient->document));

        $names = new Set(PersonName::class);
        $names->add((new PersonName())->addPart(PersonName::FIRST_NAME, $patient->name)->addPart(PersonName::LAST_NAME,
            $patient->surname));
        $patient = new CDAPAtient($names,
            new TimeStamp(\DateTime::createFromFormat('Y-m-d', $patient->birthdate->toDateString())),
            new CodedValue('M', '', "2.16.858.2.10000675.69600", ''));

        $patientRecord = new PatientRole($patientIds, $patient);
        $recordTarget = new RecordTarget($patientRecord);

        $this->clinicalDocument->setRecordTarget($recordTarget);
    }

    private function setDentist(Dentist $dentist)
    {
        $names = new Set(PersonName::class);
        $names->add((new PersonName())->addPart(PersonName::FIRST_NAME, $dentist->name)->addPart(PersonName::LAST_NAME,
            $dentist->surname));

        $assignedAuthor = new AssignedAuthor(new AssignedPerson($names),
            (new Set(InstanceIdentifier::class))->add(new InstanceIdentifier("2.16.840.1.113883.19.5", "KP00017")));

        $this->clinicalDocument->setAuthor(new Author(new TimeStamp(\DateTime::createFromFormat('Y-m-d-H:i',
            "2017-04-07-14:00")), $assignedAuthor));
    }

    private function setCustodian()
    {
        $reprCustodian = new RepresentedCustodianOrganization((new Set(EntityName::class))->add(new EntityName('MONODON')),
            (new Set(InstanceIdentifier::class))->add(new InstanceIdentifier(Config::get('cda.OID.MONODON'))));
        $assignedCustodian = new AssignedCustodian($reprCustodian);
        $custodian = new Custodian($assignedCustodian);

        $this->clinicalDocument->setCustodian($custodian);
    }

    private function setTitle($title)
    {
        $this->clinicalDocument->setTitle(new Title(new CharacterString($title)));
    }
}
