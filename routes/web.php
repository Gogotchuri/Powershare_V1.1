<?php

//Sends every request to spa except ones starting with api
Route::get('/{any}', 'General\SPAController@index')->where('any', '^(?!api).*');


