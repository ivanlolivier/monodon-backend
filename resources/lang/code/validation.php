<?php

return [
    'accepted'             => 'ACCEPTED',
    'active_url'           => 'INVALID_URL',
    'after'                => 'DATE_AFTER[:date]',
    'alpha'                => 'ONLY_LETTERS',
    'alpha_dash'           => 'ONLY_LETTERS_NUMBERS_DASHES',
    'alpha_num'            => 'ONLY_LETTERS_NUMBERS',
    'array'                => 'ARRAY',
    'before'               => 'DATE_BEFORE[:date]',
    'email'                => 'INVALID',
    'not_in'               => 'INVALID',
    'numeric'              => 'NUMERIC',
    'present'              => 'PRESENT',
    'regex'                => 'INVALID',
    'required'             => 'REQUIRED',
    'same'                 => 'MATCH[:other]',
    'string'               => 'STRING',
    'timezone'             => 'TIMEZONE',
    'unique'               => 'ALREADY_TAKEN',
    'url'                  => 'INVALID_FORMAT',
    'between'              => [
        'numeric' => 'NUMERIC_BETWEEN[:min][:max]',
        'file'    => 'FILE_BETWEEN_KB[:min][:max]',
        'string'  => 'STRING_BETWEEN_CHAR[:min][:max]',
        'array'   => 'ARRAY_BETWEEN_ITEMS[:min][:max]',
    ],
    'boolean'              => 'TRUE_OR_FALSE',
    'confirmed'            => 'DOES_NOT_MATCH',
    'date'                 => 'INVALID_DATE',
    'date_format'          => 'FORMAT[:format]',
    'different'            => 'DIFFERENT_TO[:other]',
    'digits'               => 'DIGITS_LENGTH[:digits]',
    'digits_between'       => 'DIGITS_LENGTH_BETWEEN[:min][:max]',
    'dimensions'           => 'INVALID_DIMENSIONS',
    'distinct'             => 'DUPLICATED',
    'exists'               => 'INVALID',
    'file'                 => 'FILE',
    'filled'               => 'REQUIRED',
    'image'                => 'IMAGE',
    'in'                   => 'INVALID',
    'in_array'             => 'IN_ARRAY[:other]',
    'integer'              => 'INTEGER',
    'ip'                   => 'IP',
    'json'                 => 'JSON',
    'mimes'                => 'INVALID_MIME[:values]',
    'max'                  => [
        'numeric' => 'NUMERIC_MAX[:max]',
        'file'    => 'FILE_MAX_KB[:max]',
        'string'  => 'STRING_MAX_CHARS[:max]',
        'array'   => 'ARRAY_MAX_ITEMS[:max]',
    ],
    'min'                  => [
        'numeric' => 'NUMERIC_MIN[:min]',
        'file'    => 'FILE_MIN_KB[:min]',
        'string'  => 'STRING_MIN_CHARS[:min]',
        'array'   => 'ARRAY_MIN_ITEMS[:min]',
    ],
    'required_if'          => 'REQUIRED_IF[:other][:value]',
    'required_unless'      => 'REQUIRED_UNLESS[:other][:values]',
    'required_with'        => 'REQUIRED_WITH[:values]',
    'required_with_all'    => 'REQUIRED_WITH_ALL[:values]',
    'required_without'     => 'REQUIRED_WITHOUT[:values]',
    'required_without_all' => 'REQUIRED_WITHOUT_ALL[:values]',
    'size'                 => [
        'numeric' => 'NUMERIC_SIZE[:size]',
        'file'    => 'FILE_KB[:size',
        'string'  => 'STRING_CHARS[:size]',
        'array'   => 'ARRAY_ITEMS[:size]',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    
    'custom' => [],
    
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */
    
    'attributes' => [],

];
