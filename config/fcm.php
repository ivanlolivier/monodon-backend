<?php

return [
	'driver'      => env('FCM_PROTOCOL', 'http'),
	'log_enabled' => true,

	'http' => [
//		'server_key'       => env('FCM_SERVER_KEY', 'AIzaSyAwoyipl63pRO75tmrfv-6g1MByUbO_NvM'),
//		'sender_id'        => env('FCM_SENDER_ID', '778264821728'),
        'server_key'       => env('FCM_SERVER_KEY', 'AAAAtTQyv-A:APA91bGg-3sxpKZdN9vQWOJV4bFHjRk-aDjFLS9E2k0gLUIKe2_IN0l1CelGxqZpHdcMeHHDjL0rckVs_RIeEaGaW9Ed91CPO1ieHnVDeFdKA526LIG9w7wU7DIvsQJh2yhkTQiIZ0IWpsBbKLk0joCQEnCd5184TA'),
		'sender_id'        => env('FCM_SENDER_ID', '778264821728'),

		'server_send_url'  => 'https://fcm.googleapis.com/fcm/send',
		'server_group_url' => 'https://android.googleapis.com/gcm/notification',
		'timeout'          => 30.0, // in second
	]


//    apiKey: "AIzaSyDjU-G7mwyFuNtvKi77NKRhfREhvuZvKcE",
//    authDomain: "monodon-app.firebaseapp.com",
//    databaseURL: "https://monodon-app.firebaseio.com",
//    storageBucket: "monodon-app.appspot.com",
//    messagingSenderId: "778264821728"
];
