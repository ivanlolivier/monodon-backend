<?php

return [
    'accepted'    => 'MUST_BE_ACCEPTED',
    'active_url'  => 'INVALID_URL',
    'after'       => 'MUST_BE_A_DATE_AFTER[:date]',
    'alpha'       => 'MAY_ONLY_CONTAIN_LETTERS',
    'alpha_dash'  => 'MAY_ONLY_CONTAIN_LETTERS_NUMBERS_DASHES',
    'alpha_num'   => 'MAY_ONLY_CONTAIN_LETTERS_NUMBERS',
    'array'       => 'MUST_BE_AN_ARRAY',
    'before'      => 'MUST_BE_A_DATE_BEFORE[:date]',
    'email'       => 'INVALID_EMAIL',
    'not_in'      => 'INVALID',
    'numeric'     => 'MUST_BE_A_NUMBER',
    'present'     => 'MUST_BE_PRESENT',
    'regex'       => 'INVALID',
    'required'    => 'IS_REQUIRED',
    'same'        => 'ATTRIBUTES_MUST_MATCH[:other]',
    'string'      => 'MUST_BE_A_STRING',
    'timezone'    => 'MUST_BE_A_TIMEZONE',
    'unique'      => 'ATTRIBUTE_ALREADY_TAKEN',
    'url'         => 'INVALID_FORMAT',
    'between'     => [
        'numeric' => 'MUST_BE_BETWEEN[:min][:max]',
        'file'    => 'MUST_BE_BETWEEN_KB[:min][:max]',
        'string'  => 'MUST_BE_BETWEEN_CHAR[:min][:max]',
        'array'   => 'MUST_BE_BETWEEN_ITEMS[:min][:max]',
    ],
    'boolean'     => 'MUST_BE_TRUE_OR_FALSE',
    'confirmed'   => 'CONFIRMATION_DOES_NOT_MATCH',
    'date'        => 'INVALID_DATE',
    'date_format' => 'DOES_NOT_MATCH_FORMAT[:format]',
    'different'   => 'MUST_BE_DIFFERENT_TO[:other]',
    
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'required_if'          => 'REQUIRED_IF[:other][:value]',
    'required_unless'      => 'REQUIRED_UNLESS[:other][:values]',
    'required_with'        => 'REQUIRED_WITH[:values]',
    'required_with_all'    => 'REQUIRED_WITH_ALL[:values]',
    'required_without'     => 'REQUIRED_WITHOUT[:values]',
    'required_without_all' => 'REQUIRED_WITHOUT_ALL[:values]',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
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
