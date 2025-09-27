<?php

Route::any('/broadcast/user-status', 'MessageController@userStatus')->name('broadcast.user-status');

Route::any('/broadcast/user-online', 'MessageController@userOnline')->name('broadcast.user-online');
