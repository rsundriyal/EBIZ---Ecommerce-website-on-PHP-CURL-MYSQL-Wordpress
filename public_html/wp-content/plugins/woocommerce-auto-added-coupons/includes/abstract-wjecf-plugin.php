<?php

class Abstract_WJECF_Plugin {
	/**
	 * Log a message (for debugging)
	 *
	 * @param string $message The message to log
	 *
	 */
	protected function log ( $message ) {
		WJECF()->log( $message, 1 );
	}
}