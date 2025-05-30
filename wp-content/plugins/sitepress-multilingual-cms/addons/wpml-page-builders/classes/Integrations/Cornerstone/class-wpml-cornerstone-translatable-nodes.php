<?php
/**
 * WPML_Cornerstone_Translatable_Nodes class file.
 *
 * @package wpml-page-builders-cornerstone
 */

use WPML\PB\Cornerstone\Modules\ModuleWithItemsFromConfig;
use WPML\FP\Obj;

/**
 * Class WPML_Cornerstone_Translatable_Nodes
 */
class WPML_Cornerstone_Translatable_Nodes implements IWPML_Page_Builders_Translatable_Nodes {

	const SETTINGS_FIELD = '_modules';

	/**
	 * Nodes to translate.
	 *
	 * @var array
	 */
	protected $nodes_to_translate;

	/**
	 * Get translatable node.
	 *
	 * @param string|int $node_id  Node id.
	 * @param array      $settings Node settings.
	 *
	 * @return WPML_PB_String[]
	 */
	public function get( $node_id, $settings ) {

		if ( ! $this->nodes_to_translate ) {
			$this->initialize_nodes_to_translate();
		}

		$strings = array();

		foreach ( $this->nodes_to_translate as $node_type => $node_data ) {
			if ( $this->conditions_ok( $node_data, $settings ) ) {
				foreach ( $node_data['fields'] as $field ) {
					$field_key = $field['field'];
					if ( isset( $settings[ $field_key ] ) && trim( $settings[ $field_key ] ) ) {

						$string = new WPML_PB_String(
							$settings[ $field_key ],
							$this->get_string_name( $node_id, $field, $settings ),
							$field['type'],
							$field['editor_type'],
							$this->get_wrap_tag( $settings )
						);

						$strings[] = $string;
					}
				}

				foreach ( $this->get_integration_instances( $node_data ) as $node ) {
					$strings = $node->get( $node_id, $settings, $strings );
				}
			}
		}

		return $strings;
	}

	/**
	 * Update translatable node.
	 *
	 * @param string         $node_id  Node id.
	 * @param array          $settings Node settings.
	 * @param WPML_PB_String $string   String object.
	 *
	 * @return array
	 */
	public function update( $node_id, $settings, WPML_PB_String $string ) {

		if ( ! $this->nodes_to_translate ) {
			$this->initialize_nodes_to_translate();
		}

		foreach ( $this->nodes_to_translate as $node_type => $node_data ) {
			if ( $this->conditions_ok( $node_data, $settings ) ) {
				foreach ( $node_data['fields'] as $field ) {
					$field_key = $field['field'];
					if ( $this->get_string_name( $node_id, $field, $settings ) === $string->get_name() ) {
						$settings[ $field_key ] = $string->get_value();
					}
				}

				foreach ( $this->get_integration_instances( $node_data ) as $node ) {
					$settings = $node->update( $node_id, $settings, $string );
				}
			}
		}

		return $settings;
	}

	/**
	 * @param array $node_data
	 *
	 * @return WPML_Cornerstone_Module_With_Items[]
	 */
	private function get_integration_instances( $node_data ) {
		$instances = [];

		if ( isset( $node_data['integration-class'] ) ) {
			try {
				$instances[] = new $node_data['integration-class']();
			} catch ( Exception $e ) {}
		}

		if ( isset( $node_data['fields_in_item'] ) ) {
			foreach ( $node_data['fields_in_item'] as $config ) {
				$instances[] = new ModuleWithItemsFromConfig( $config );
			}
		}

		return $instances;
	}

	/**
	 * Get string name.
	 *
	 * @param string $node_id  Node id.
	 * @param array  $field    Page builder field.
	 * @param array  $settings Node settings.
	 *
	 * @return string
	 */
	public function get_string_name( $node_id, $field, $settings ) {
		return $field['field'] . '-' . $settings['_type'] . '-' . $node_id;
	}

	/**
	 * Get wrap tag for string.
	 * Used for SEO, can contain (h1...h6, etc.)
	 *
	 * @param array $settings Field settings.
	 *
	 * @return string
	 */
	private function get_wrap_tag( $settings ) {
		if ( isset( $settings['_type'] ) && 'headline' === $settings['_type'] ) {
			return Obj::propOr( 'h1', 'text_tag', $settings );
		}

		return '';
	}

	/**
	 * Check if node condition is ok.
	 *
	 * @param array $node_data Node data.
	 * @param array $settings  Node settings.
	 *
	 * @return bool
	 */
	private function conditions_ok( $node_data, $settings ) {
		$conditions_meet = true;
		foreach ( $node_data['conditions'] as $field_key => $field_value ) {
			if ( ! isset( $settings[ $field_key ] ) || $settings[ $field_key ] !== $field_value ) {
				$conditions_meet = false;
				break;
			}
		}

		return $conditions_meet;
	}

	/**
	 * @return array[]
	 */
	public static function get_nodes_to_translate() {
		return [
			'card'                    => [
				'conditions' => [ '_type' => 'card' ],
				'fields'     => [
					[
						'field'       => 'card_front_text_content',
						'type'        => __( 'Card: Front Text Content', 'sitepress' ),
						'editor_type' => 'VISUAL',
					],
					[
						'field'       => 'card_back_text_content',
						'type'        => __( 'Card: Back Text Content', 'sitepress' ),
						'editor_type' => 'VISUAL',
					],
					[
						'field'       => 'anchor_text_primary_content',
						'type'        => __( 'Card: Anchor Text Primary Content', 'sitepress' ),
						'editor_type' => 'VISUAL',
					],
					[
						'field'       => 'anchor_text_secondary_content',
						'type'        => __( 'Card: Anchor Text Secondary Content', 'sitepress' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'anchor_href',
						'type'        => __( 'Card: Anchor Link', 'sitepress' ),
						'editor_type' => 'LINK',
					],
				],
			],
			'alert'                   => [
				'conditions' => [ '_type' => 'alert' ],
				'fields'     => [
					[
						'field'       => 'alert_content',
						'type'        => __( 'Alert Content: Alert', 'sitepress' ),
						'editor_type' => 'VISUAL',
					],
				],
			],
			'text'                    => [
				'conditions' => [ '_type' => 'text' ],
				'fields'     => [
					[
						'field'       => 'text_content',
						'type'        => __( 'Text Content: Text', 'sitepress' ),
						'editor_type' => 'VISUAL',
					],
				],
			],
			'quote'                   => [
				'conditions' => [ '_type' => 'quote' ],
				'fields'     => [
					[
						'field'       => 'quote_content',
						'type'        => __( 'Quote: Quote Content', 'sitepress' ),
						'editor_type' => 'VISUAL',
					],
					[
						'field'       => 'quote_cite_content',
						'type'        => __( 'Quote: Quote Cite', 'sitepress' ),
						'editor_type' => 'LINE',
					],
				],
			],
			'counter'                 => [
				'conditions' => [ '_type' => 'counter' ],
				'fields'     => [
					[
						'field'       => 'counter_number_prefix_content',
						'type'        => __( 'Counter: Number Prefix', 'sitepress' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'counter_number_suffix_content',
						'type'        => __( 'Counter: Number Suffix', 'sitepress' ),
						'editor_type' => 'LINE',
					],
				],
			],
			'content-area'            => [
				'conditions' => [ '_type' => 'content-area' ],
				'fields'     => [
					[
						'field'       => 'content',
						'type'        => __( 'Content Area: Content', 'sitepress' ),
						'editor_type' => 'AREA',
					],
				],
			],
			'breadcrumbs'             => [
				'conditions' => [ '_type' => 'breadcrumbs' ],
				'fields'     => [
					[
						'field'       => 'breadcrumbs_home_label_text',
						'type'        => __( 'Breadcrumbs: Home Label Text', 'sitepress' ),
						'editor_type' => 'LINE',
					],
				],
			],
			'audio'                   => [
				'conditions' => [ '_type' => 'audio' ],
				'fields'     => [
					[
						'field'       => 'audio_embed_code',
						'type'        => __( 'Audio: Embed Code', 'sitepress' ),
						'editor_type' => 'VISUAL',
					],
				],
			],
			'headline'                => [
				'conditions' => [ '_type' => 'headline' ],
				'fields'     => [
					[
						'field'       => 'text_content',
						'type'        => __( 'Headline Content: Headline', 'sitepress' ),
						'editor_type' => 'VISUAL',
					],
				],
			],
			'content-area-off-canvas' => [
				'conditions' => [ '_type' => 'content-area-off-canvas' ],
				'fields'     => [
					[
						'field'       => 'off_canvas_content',
						'type'        => __( 'Canvas Content: Canvas', 'sitepress' ),
						'editor_type' => 'VISUAL',
					],
				],
			],
			'content-area-modal'      => [
				'conditions' => [ '_type' => 'content-area-modal' ],
				'fields'     => [
					[
						'field'       => 'modal_content',
						'type'        => __( 'Modal Content: Modal', 'sitepress' ),
						'editor_type' => 'VISUAL',
					],
				],
			],
			'content-area-dropdown'   => [
				'conditions' => [ '_type' => 'content-area-dropdown' ],
				'fields'     => [
					[
						'field'       => 'dropdown_content',
						'type'        => __( 'Dropdown Content: Dropdown', 'sitepress' ),
						'editor_type' => 'VISUAL',
					],
				],
			],
			'button'                  => [
				'conditions' => [ '_type' => 'button' ],
				'fields'     => [
					[
						'field'       => 'anchor_text_primary_content',
						'type'        => __( 'Anchor Text: Primary Content', 'sitepress' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'anchor_text_secondary_content',
						'type'        => __( 'Anchor Text: Secondary Content', 'sitepress' ),
						'editor_type' => 'LINE',
					],
				],
			],
			'video'                   => [
				'conditions' => [ '_type' => 'video' ],
				'fields'     => [
					[
						'field'       => 'video_embed_code',
						'type'        => __( 'Video: Embed Code', 'sitepress' ),
						'editor_type' => 'LINE',
					],
				],
			],
			'search-inline'           => [
				'conditions' => [ '_type' => 'search-inline' ],
				'fields'     => [
					[
						'field'       => 'search_placeholder',
						'type'        => __( 'Search Inline: Placeholder', 'sitepress' ),
						'editor_type' => 'LINE',
					],
				],
			],
			'search-modal'            => [
				'conditions' => [ '_type' => 'search-modal' ],
				'fields'     => [
					[
						'field'       => 'search_placeholder',
						'type'        => __( 'Search Modal: Placeholder', 'sitepress' ),
						'editor_type' => 'LINE',
					],
				],
			],
			'search-dropdown'         => [
				'conditions' => [ '_type' => 'search-dropdown' ],
				'fields'     => [
					[
						'field'       => 'search_placeholder',
						'type'        => __( 'Search Dropdown: Placeholder', 'sitepress' ),
						'editor_type' => 'LINE',
					],
				],
			],
			'accordion'               => [
				'conditions'        => [ '_type' => 'accordion' ],
				'fields'            => [],
				'integration-class' => 'WPML_Cornerstone_Accordion',
			],
			'tabs'                    => [
				'conditions'        => [ '_type' => 'tabs' ],
				'fields'            => [],
				'integration-class' => 'WPML_Cornerstone_Tabs',
			],
		];
	}

	/**
	 * Initialize translatable nodes.
	 */
	public function initialize_nodes_to_translate() {
		$this->nodes_to_translate = apply_filters( 'wpml_cornerstone_modules_to_translate', self::get_nodes_to_translate() );
	}
}
