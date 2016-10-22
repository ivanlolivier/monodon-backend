<?php

return [
	'driver'      => env('FCM_PROTOCOL', 'http'),
	'log_enabled' => true,

	'http' => [
		'server_key'       => env('FCM_SERVER_KEY', 'AIzaSyDjU-G7mwyFuNtvKi77NKRhfREhvuZvKcE'),
		'sender_id'        => env('FCM_SENDER_ID', '1:778264821728:android:56a73bde299b4799'),
		'server_send_url'  => 'https://fcm.googleapis.com/fcm/send',
		'server_group_url' => 'https://android.googleapis.com/gcm/notification',
		'timeout'          => 30.0, // in second
	]
];
