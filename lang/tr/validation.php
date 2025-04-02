<?php

return [
    'email' => [
        'required' => 'E-posta geçerli değil!',
        'email' => 'Geçerli bir e-posta adresi girin!',
    ],
    'phone' => [
        'regex' => 'Geçerli bir telefon numarası girin!',
    ],
    'name' => [
        'required' => 'İsim gereklidir!',
        'min' => 'İsim en az :min karakter olmalıdır.',
    ],
    'lastName' => [
        'required' => 'Soyadı gereklidir!',
        'min' => 'Soyadı en az :min karakter olmalıdır.',
    ],
    'identity' => [
        'required' => 'Kimlik numarası gereklidir!',
        'min' => 'Kimlik numarası en az :min karakter olmalıdır.'
    ],
];
