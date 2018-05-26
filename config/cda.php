<?php

$MONODONID = '123456789';
$OIDUYPrefix = '2.16.858';

return [
    'LOINCNotes' => [
        'consultation'            => '34756-7',
        'dischargeSummarization'  => '29761-4',
        'evaluationAndManagement' => '34757-5',
        'initialEvaluation'       => '28572-6',
        'procedure'               => '28577-5',
        'subsequentEvaluation'    => '28617-9',
        'surgicalOperation'       => '28583-3',
        'visit'                   => '28618-7',
    ],

    'OID' => [
        'MONODONID'    => $MONODONID,
        'MONODON'      => "{$OIDUYPrefix}.0.{$MONODONID}",
        'CIPrefix'     => "{$OIDUYPrefix}.1.858.68909.",
        'ObjectPrefix' => "{$OIDUYPrefix}.2"
    ]

];

