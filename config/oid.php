<?php

$MONODONID = '123456789';
$OIDUYPrefix = '2.16.858';

return [
    'MONODONID'    => $MONODONID,
    'MONODON'      => "{$OIDUYPrefix}.0.{$MONODONID}",
    'ObjectPrefix' => "{$OIDUYPrefix}.2",

    'DNI' => [
        'UY' => "{$OIDUYPrefix}.1.858.68909.", //o 2.16.858.2.1000675.68909 ????
    ],

];

