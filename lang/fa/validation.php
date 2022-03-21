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

    'accepted'        => 'پذیرش :attribute الزامی است.',
    'accepted_if'     => 'وقتی :other مساوی :value باشد، پذیرش :attribute الزامی است.',
    'active_url'      => ':attribute یک URL معتبر نیست.',
    'after'           => 'تاریخ :attribute باید بعد از :date باشد.',
    'after_or_equal'  => 'تاریخ :attribute باید بعد یا مساوی :date باشد.',
    'alpha'           => ':attribute فقط می‌تواند شامل حروف انگلیسی باشد.',
    'alpha_dash'      => ':attribute فقط می‌تواند حروف و اعداد انگلیسی و خط فاصله داشته باشد.',
    'alpha_num'       => ':attribute فقط می‌تواند حروف و اعداد انگلیسی داشته باشد.',
    'array'           => ':attribute باید یک آرایه باشد.',
    'before'          => 'تاریخ :attribute باید قبل از :date باشد.',
    'before_or_equal' => 'تاریخ :attribute باید قبل یا مساوی :date باشد.',
    'between'         => [
        'array'   => ':attribute باید بین :min و :max آیتم داشته باشد.',
        'file'    => 'سایز :attribute باید بین :min و :max کیلوبایت باشد.',
        'numeric' => ':attribute باید بین :min و :max باشد.',
        'string'  => ':attribute باید بین :min و :max کاراکتر باشد.',
    ],
    'boolean'          => ':attribute باید true یا false باشد.',
    'confirmed'        => ':attribute یکسان نیست.',
    'current_password' => 'گذرواژه اشتباه است.',
    'date'             => ':attribute یک تاریخ معتبر نیست.',
    'date_equals'      => 'تاریخ :attribute باید مساوی با :date باشد.',
    'date_format'      => 'تاریخ :attribute باید دارای فرمت :format باشد.',
    'declined'         => 'باید با :attribute مخالفت شده باشد.',
    'declined_if'      => 'وقتی :other مساوی :value باشد، باید با :attribute مخالفت شده باشد.',
    'different'        => 'مقادیر :attribute و :other نمی‌تواند یکسان باشد.',
    'digits'           => ':attribute باید :digits حرفی باشد.',
    'digits_between'   => ':attribute باید بین :min و :max حرف باشد.',
    'dimensions'       => 'ابعاد عکس :attribute نامعتبر است.',
    'distinct'         => ':attribute دارای مقدار تکراری است.',
    'email'            => ':attribute باید آدرس ایمیل معتبر باشد.',
    'ends_with'        => ':attribute باید با یکی از این مقادیر تمام شود: :values.',
    'enum'             => ':attribute نامعتبر است.',
    'exists'           => ':attribute نامعتبر است.',
    'file'             => ':attribute باید یک فایل باشد.',
    'filled'           => ':attribute باید مقدار داشته باشد.',
    'gt'               => [
        'array'   => ':attribute باید بیشتر از :value آیتم داشته باشد.',
        'file'    => ':attribute باید بیشتر از :value کیلوبایت باشد.',
        'numeric' => ':attribute باید بیشتر از :value باشد.',
        'string'  => ':attribute باید بیشتر از :value کاراکتر باشد.',
    ],
    'gte' => [
        'array'   => ':attribute باید حداقل :value آیتم داشته باشد.',
        'file'    => ':attribute باید حداقل :value کیلوبایت باشد.',
        'numeric' => ':attribute باید حداقل :value باشد.',
        'string'  => ':attribute باید حداقل :value کاراکتر باشد.',
    ],
    'image'    => ':attribute باید یک عکس باشد.',
    'in'       => ':attribute نامعتبر است.',
    'in_array' => 'مقدار :attribute در :other یافت نشد.',
    'integer'  => ':attribute باید یک عدد صحیح باشد.',
    'ip'       => ':attribute باید یک آدرس IP معتبر باشد.',
    'ipv4'     => ':attribute باید یک آدرس IPv4 معتبر باشد.',
    'ipv6'     => ':attribute باید یک آدرس IPv6 معتبر باشد.',
    'json'     => ':attribute باید یک رشته JSON معتبر باشد.',
    'lt'       => [
        'array'   => ':attribute باید کمتر از :value آیتم داشته باشد.',
        'file'    => ':attribute باید کمتر از :value کیلوبایت باشد.',
        'numeric' => ':attribute باید کمتر از :value باشد.',
        'string'  => ':attribute باید کمتر از :value کاراکتر باشد.',
    ],
    'lte' => [
        'array'   => ':attribute باید کمتر یا مساوی با :value آیتم باشد.',
        'file'    => ':attribute باید کمتر یا مساوی با :value کیلوبایت باشد.',
        'numeric' => ':attribute باید کمتر یا مساوی با :value باشد.',
        'string'  => ':attribute باید کمتر یا مساوی با :value کاراکتر باشد.',
    ],
    'mac_address' => ':attribute باید یک MAC آدرس معتبر باشد.',
    'max'         => [
        'array'   => ':attribute نباید بیشتر از :max آیتم داشته باشد.',
        'file'    => ':attribute نباید بیشتر از :max کیلوبایت باشد.',
        'numeric' => ':attribute نباید بیشتر از :max باشد.',
        'string'  => ':attribute نباید بیشتر از :max کاراکتر باشد.',
    ],
    'mimes'     => 'قالب :attribute می‌تواند یکی از این موارد باشد: :values.',
    'mimetypes' => 'قالب :attribute می‌تواند یکی از این موارد باشد: :values.',
    'min'       => [
        'array'   => ':attribute باید حداقل :min آیتم داشته باشد.',
        'file'    => ':attribute باید حداقل :min کیلوبایت باشد.',
        'numeric' => ':attribute باید حداقل :min باشد.',
        'string'  => ':attribute باید حداقل :min کاراکتر باشد.',
    ],
    'multiple_of'          => ':attribute باید ضریبی از :value باشد.',
    'not_in'               => ':attribute نامعتبر است.',
    'not_regex'            => 'قالب :attribute نامعتبر است.',
    'numeric'              => ':attribute باید یک عدد باشد.',
    'password'             => 'گذرواژه نادرست است.',
    'present'              => ':attribute باید موجود باشد.',
    'prohibited'           => ':attribute ممنوع است.',
    'prohibited_if'        => 'وقتی :other مساوی :value باشد، :attribute ممنوع است.',
    'prohibited_unless'    => ':attribute ممنوع است، مگر این‌که :other مساوی :values باشد.',
    'prohibits'            => 'فیلد :attribute فیلد :other را ممنوع می‌کند.',
    'regex'                => 'قالب :attribute نامعتبر است.',
    'required'             => ':attribute ضروری است.',
    'required_array_keys'  => ':attribute باید این مقادیر را داشته باشد: :values.',
    'required_if'          => 'وقتی :other مساوی :value باشد، :attribute الزامی است.',
    'required_unless'      => ':attribute الزامی است، مگر این‌که :other مساوی :values باشد.',
    'required_with'        => 'پر کردن :attribute همراه با :values ضروری است.',
    'required_with_all'    => 'پر کردن :attribute همراه با :values ضروری است.',
    'required_without'     => 'باید یکی از :attribute یا :values مقداردهی شده باشد.',
    'required_without_all' => 'باید یکی از :attribute یا :values مقداردهی شده باشد.',
    'same'                 => 'مقادیر :attribute و :other باید یکسان باشد.',
    'size'                 => [
        'array'   => ':attribute باید :size آیتم داشته باشد.',
        'file'    => ':attribute باید :size کیلوبایت باشد.',
        'numeric' => ':attribute باید :size باشد.',
        'string'  => ':attribute باید :size کاراکتر باشد.',
    ],
    'starts_with' => ':attribute باید با یکی از این مقادیر شروع شود: :values.',
    'string'      => ':attribute باید متنی باشد.',
    'timezone'    => ':attribute باید یک موقعیت زمانی معتبر باشد.',
    'unique'      => ':attribute قبلا ثبت شده است.',
    'uploaded'    => 'آپلود :attribute ناموفق بود.',
    'url'         => ':attribute باید یک URL معتبر باشد.',
    'uuid'        => ':attribute باید یک UUID معتبر باشد.',

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
