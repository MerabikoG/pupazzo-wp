<?php

namespace WPML\PB\SiteOrigin\Hooks;

use WPML\FP\Lst;
use WPML\LIB\WP\Hooks;
use WPML\PB\TranslationJob\Groups;

use function WPML\FP\spreadArgs;

class TranslationJobImages implements \IWPML_Frontend_Action, \IWPML_Backend_Action {

	public function add_hooks() {
		Hooks::onFilter( 'wpml_pb_image_module_patterns' )
			->then( spreadArgs( Lst::append( '/Image-(\d+)-\d+$/' ) ) );
	}
}
