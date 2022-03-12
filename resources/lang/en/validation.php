<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'Request :attribute must be in the future',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'uuid' => 'The :attribute must be a valid UUID.',

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

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'password' => [
            'regex' => 'missing uppercase letter, number or special character',
            'min'=> 'password must be at least 6 characters',
            'required'=> 'password required'
        ],

        'referral_email' => [
            'unique' => 'An invitation has been sent to this email',
            'email'=> 'Invalid email address',
            'required'=> 'You must place an email'
        ],

        'email' => [
            'unique' => 'account found, try logging in instead',
            'email'=> 'Invalid email address'
        ],

        'name' => [
            'required' => 'first name required',
        ],
        'last_name' => [
            'required' => 'last name required',
        ],
		
		'password_confirmation' => [
			'same' => 'Passwords must match',
            'required' => 'Confirm password required'
		],
		
        'number' => [
            'numeric' => 'stop, numbers only',
            'required' => 'mobile required',
            'regex' => 'invalid mobile number',
            'unique'=> 'account found, try logging in',
        ],
        
        'profile.tagline' => [
            'required' => 'Tagline must be between 20 and 50 character',
            'max' => 'Tagline may not be greater than 50 characters.',
            'min' => 'Tagline must be at least 20 characters.',
            'regex' => 'Tagline may only contain letters and numbers.',
        ],
        
        'profile.elevator_pitch' => [
            'required' => 'Elevator Pitch must be between 100 and 160 character',
            'max' => 'Elevator Pitch  may not be greater than 160 characters.',
            'min' => 'Elevator Pitch  must be at least 100 characters.',
            'regex' => 'Elevator Pitch  may only contain letters and numbers.',
            
        ],

        'profile.years_experience' => [
            'required' => 'The years experience is required.',
            'integer' => 'The years experience must be an integer.',
        ],

        'profile.last_name' => [
            'required' => 'The last name is required.',
        ],

        'display_name' => [
            'required' => 'display name required',
            'regex' => '46 characters max, no special characters',
        ],
        'profile.display_name' => [
            'required' => 'Display Name is required.',
            'regex' => '46 characters max, no special characters',
        /*    'regex' => 'Profile URL must only contain letters, numbers or dashes',*/
        ],
        'phone_numbers.*.number' => [
            'required' => 'The mobile number is required.',
            'regex' => 'The mobile number format is invalid.',
        ],
        'phone_numbers.*.code2' => [
            'required' => 'The country code is required.',

        ],
        'code2' => [
            'required' => 'The country code is required.',

        ],
        'profile.birth_date' => [
            'required' => 'Date of birth is required.',
            'date_format' => 'Please enter a valid date',
            'required' => 'Please enter a valid date'
        ],

        'profile.description' => [
            'required' => 'The description is required.',
            'max' => 'The description may not be greater than 400 characters.',
            'regex' => 'description may only contain letters and numbers.'
        ],
        // Scheduled privates Rate
        'user_services.0.rate' => [
            'required' => 'Scheduled privates rate is required.',
            'min' => 'Scheduled privates rate must be at least $2.00',
            
        ],
        // Livestream Rate
        'user_services.1.rate' => [
            'required' => 'Livestream rate is required.',
            'min' => 'Livestream rate must be at least $2.00',
            
        ],
        // Video Rate
        'user_services.2.rate' => [
            'required' => 'Service rate is required.',
            'required_if' => 'Service rate is required.',
            'min' => 'Video rate must be at least $3.75',
            
        ],
        'user_services.*.min_duration' => [
            'required' => 'Min. duration is required.',
            'required_if' => 'Min. duration is required.',
            'min' => 'Min. duration must be at least 5 minutes.',
        ],



        'user_schedule.*.from' => [
            'required' => 'From time is required.',
            'required_if' => 'From time is required.'
        ],
        'user_schedule.*.till' => [
            'required' => 'Till time is required.',
            'required_if' => 'Till time is required.',
            'after_or_equal' => 'Till time must be greater than from'
        ],
        'start' => [
            'required' => 'The start time is required.',
            'regex' => 'Invalid time format. e.g. 10:00 AM',
        ],
        'end' => [
            'required' => 'The end time is required.',
            'regex' => 'Invalid time format. e.g. 03:15 PM',
        ],
        'category.id' => [
            'required' => 'Reading Type Required.'
        ],

        'categories' => [
            'required' => 'Select one.',
            'min' => 'Select one.',
            'max' => 'Select up to 4'
        ],

        'tools' => [
            'required' => 'Select one.',
            'min' => 'Select one.',
            'max' => 'Select up to 3'
        ],
        'specialties' => [
            'required' => 'Select one.',
            'min' => 'Select one.',
            'max' => 'Select up to 4'
        ],

        'styles' => [
            'required' => 'Select one.',
            'min' => 'Select one.',
            'max' => 'Select up to 1'
        ],



        'credentials.*.institution_name' => [
            'required' => 'Institution Name is required.',
        ],

        'languages.*.languages_id' => [
            'required' => 'Languages Name is required.',
            'distinct' => 'You must select this language only once.',
        ],
        'works.*.position' => [
            'required' => 'Position Name is required.',
        ],
        'duration' => [
            'min' => " set their minimum duration to :min minutes."
        ],
        'profile.birth_date' => [
            'before' => "You must be 18+ to use Respectfully™",
            'date_format' => 'Please enter a valid date',
            'required' => 'Please enter a valid date'
        ],
        'age' => [
            'accepted' => "You must agree to terms and conditions"
        ],

        'cc_exp' => [
            'regex' => 'Invalid. Ex: 01/25',           
        ],
        'cc_number' => [
            'numeric' => 'Only numbers',
            'digits_between' => 'Between 14 and 20 digits',
            'not_regex'=> 'American Express not accepted'
        ],
        'cc_zip' => [
            'numeric' => 'Only numbers', 
            'min' => 'Between 5 and 10 characters',
            'max' => 'Between 5 and 10 characters',
             
                
        ],
        'cc_cvv' => [
            'numeric' => 'Only numbers',
            'digits_between' => '3 or 4 digits',
           
        ],
		
    ],

/*
|--------------------------------------------------------------------------
| Custom Validation Attributes
|--------------------------------------------------------------------------
|
| The following language lines are used to swap our attribute placeholder
| with something more reader friendly such as "E-Mail Address" instead
| of "email". This simply helps us make our message more expressive.
|
*/

    'attributes' => [],

];
