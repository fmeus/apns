<?php
/* Production settings */
$production = array( 'label' => 'Prodcution'
	               , 'ssl' => 'ssl://gateway.push.apple.com:2195'
	               , 'cert' => 'apns-prod.pem'
	               , 'passphrase' => ''
	               , 'token' => '<insert valid token for production device>' );

/* Development settings */
$development = array( 'label' => 'Development'
	                , 'ssl' => 'ssl://gateway.sandbox.push.apple.com:2195'
	                , 'cert' => 'apns-dev.pem'
	                , 'passphrase' => ''
	                , 'token' => '<insert valid token for sandbox/development device>' );

/* Send push notification */
function send_apns( $config ) {
	$ctx = stream_context_create();
	stream_context_set_option( $ctx, 'ssl', 'local_cert', $config['cert'] );
	if ( $config['passphrase'] != '' ) {
		stream_context_set_option( $ctx, 'ssl', 'passphrase', $config['passphrase'] );
	}

	/* Open a connection to the APNS server */
	$fp = stream_socket_client( $config['ssl'], $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx );

	if (!$fp) { exit( "Failed to connect: $err $errstr" . PHP_EOL ); }

	echo 'Connected to APNS ('.$config['label'].')'.PHP_EOL;

	/* Create the payload body */
	$body['aps'] = array( 'badge' => 1
		                , 'alert' => 'Test Push Notification ('.$config['label'].')'
		                , 'sound' => 'default' );

	/* Encode the payload as JSON */
	$payload = json_encode( $body );

	/* Build the binary notification */
	$msg = chr( 0 ).pack( 'n', 32 ).pack( 'H*', $config['token'] ).pack( 'n', strlen( $payload ) ).$payload;

	 /* Send it to the server */
	$result = fwrite( $fp, $msg, strlen( $msg ) );
	echo (!$result)? 'Message not delivered'.PHP_EOL : 'Message successfully delivered'.PHP_EOL;

	/* Close the connection to the server */
	fclose( $fp );
}

/* Send out push notification using development and production config */
send_apns( $development );
send_apns( $production );
?>