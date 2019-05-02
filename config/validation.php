<?php
//validation rules
return [
    "email" => "email",
    "name" => "string|min:3|max:30",
    "password" => "string|min:8",
];