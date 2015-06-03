<?php

return [

	#################################################
    # On/off switch.
    #################################################
    'is_active' => true,

	#################################################
	# How long to wait between re-caching pages
	#################################################
	'cooldown' => 5,

	#################################################
	# List of URIs to not cache (regex friendly!)
	#################################################
	'ignore' => [
		'login',
	],

];