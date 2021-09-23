<?php
/**
 * Header controls addon.
 *
 * @package Hestia
 */

/**
 * Class Hestia_Header_Controls_Addon
 */
class Hestia_Header_Controls_Addon extends Hestia_Header_Controls {

	/**
	 * Add customizer controls.
	 */
	public function add_controls() {
		parent::add_controls();

		$this->add_top_bar_options();
		$this->add_navigation_options();
	}

	/**
	 * Add customizer controls for the top bar area.
	 */
	public function add_top_bar_options() {
		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_very_top_bar_tabs',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'section'  => 'hestia_top_bar',
					'priority' => 1,
					'tabs'     => array(
						'general'    => array(
							'label' => esc_html__( 'General Settings', 'hestia-pro' ),
						),
						'appearance' => array(
							'label' => esc_html__( 'Appearance Settings', 'hestia-pro' ),
						),
					),
					'controls' => array(
						'general'    => array(
							'hestia_top_bar_hide'        => array(),
							'hestia_top_bar_alignment'   => array(),
							'hestia_link_to_top_menu'    => array(),
							'hestia_link_to_top_widgets' => array(),
						),
						'appearance' => array(
							'hestia_top_bar_text_color' => array(),
							'hestia_top_bar_link_color' => array(),
							'hestia_top_bar_link_color_hover' => array(),
							'hestia_top_bar_background_color' => array(),
						),
					),
				),
				'Hestia_Customize_Control_Tabs'
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_top_bar_alignment',
				array(
					'default'           => apply_filters( 'hestia_top_bar_alignment_default', 'right' ),
					'sanitize_callback' => 'hestia_sanitize_alignment_options',
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'    => esc_html__( 'Layout', 'hestia-pro' ),
					'priority' => 25,
					'section'  => 'hestia_top_bar',
					'choices'  => array(
						'left'  => array(
							'url'   => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqCAMAAABpj1iyAAAAM1BMVEX///8Ahbojjr5mqMzU5O/f6/Pq8vf1+fs9l8NToMiGuNWjyN681ueVwNp3sNGwz+LI3evMEc51AAABPUlEQVR4Ae3RuYojSxhE4Ti5L1nL+z/tVdISNFwYY5hWy4jPCPjLOlTKzMzMzMzMzMzMzMzMzP61WvSJAllbjvETsxLof464fvUR8ysr6ylVSZGph5L1B3z3F/dL41KFuSdD0mq0A6QjECJR9QSOfba4Socwfz5r0rXYQxOkDDRAN7QAUZ12wvzKGpzjHVkFygmUwRSkSSgaoMEpBWKGlQZdkandeJX681nqXCGMx1AEaRClBF8VkXizvT7cAcJ6Q9YicN4Eup5/q+oATVq+IWa4UrqSIkPKZXX6G7IqsBT2CFKG0AHlwBbVCbFx64C2Qhsn4w1ZOqFq7BEkrQAdpHzEIzJUI3BWlQZzAL3oDUrKz1FKVVKuNSXpPNIFSw9J2nJ5zi+62XrVh0kzjktmZmZmZmZmZmZmZmZm9s1/51AJDRsfaTQAAAAASUVORK5CYII=',
							'label' => esc_html__( 'Left Sidebar', 'hestia-pro' ),
						),
						'right' => array(
							'url'   => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqCAMAAABpj1iyAAAAM1BMVEX///8Ahbojjr5mqMzU5O/f6/Pq8vf1+fs9l8NToMiGuNWjyN681ueVwNp3sNGwz+LI3evMEc51AAABO0lEQVR4Ae3RuWodQRhE4Tq9Lz3L+z+tb6MrMFZm0EhBfUHBP9FhWmZmZmZmZmZmZmZmZmb2Uot+o0DWlmP8jVkJ9MUR148+Yv7MynpLVVJk6qVkPaBxqcLckyFpNdoB0hEIkah6Asc+W1ylQ5j6B3/7j/urSddiD02QMtAA3dACRHXaCfMja3COJ7IKlBMogylIk1A0QINTCsQMKw26IlO78Sr1+7PUuUIYr6EI0iBKCT4qIvFm+/xwBwjrgaxF4LwJdL3/VtUBmrR8Q8xwpXQlRYaUy+r0B7IqsBT2CFKG0AHlwBbVCbFx64C2Qhsn44EsnVA19giSVoAOUj7iERmqETirSoM5gF6eyCopv0cpVUm51pSk80gXLL0kacvlPT/oZutVv0yacVwyMzMzMzMzMzMzMzMzs+/yB9eOCQ0dpl58AAAAAElFTkSuQmCC',
							'label' => esc_html__( 'Right Sidebar', 'hestia-pro' ),
						),
					),
				),
				'Hestia_Customize_Control_Radio_Image',
				array(
					'selector'        => '.hestia-top-bar',
					'settings'        => array( 'hestia_top_bar_alignment' ),
					'render_callback' => array( $this, 'top_bar_callback' ),
				)
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_top_bar_background_color',
				array(
					'transport'         => 'postMessage',
					'sanitize_callback' => 'hestia_sanitize_colors',
					'default'           => '#363537',
				),
				array(
					'label'        => esc_html__( 'Background color', 'hestia-pro' ),
					'section'      => 'hestia_top_bar',
					'show_opacity' => true,
					'palette'      => false,
					'priority'     => 5,
				),
				'Hestia_Customize_Alpha_Color_Control'
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_top_bar_text_color',
				array(
					'transport'         => 'postMessage',
					'sanitize_callback' => 'hestia_sanitize_colors',
					'default'           => '#ffffff',
				),
				array(
					'label'    => esc_html__( 'Text', 'hestia-pro' ) . ' ' . esc_html__( 'Color', 'hestia-pro' ),
					'section'  => 'hestia_top_bar',
					'priority' => 10,
				),
				'WP_Customize_Color_Control'
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_top_bar_link_color',
				array(
					'transport'         => 'postMessage',
					'sanitize_callback' => 'hestia_sanitize_colors',
					'default'           => '#ffffff',
				),
				array(
					'label'    => esc_html__( 'Link', 'hestia-pro' ) . ' ' . esc_html__( 'Color', 'hestia-pro' ),
					'section'  => 'hestia_top_bar',
					'priority' => 15,
				),
				'WP_Customize_Color_Control'
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_top_bar_link_color_hover',
				array(
					'transport'         => 'postMessage',
					'sanitize_callback' => 'hestia_sanitize_colors',
					'default'           => '#eeeeee',
				),
				array(
					'label'    => esc_html__( 'Link color on hover', 'hestia-pro' ),
					'section'  => 'hestia_top_bar',
					'priority' => 20,
				),
				'WP_Customize_Color_Control'
			)
		);
	}

	/**
	 * Add navigation options.
	 */
	private function add_navigation_options() {

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_full_screen_menu',
				array(
					'sanitize_callback' => 'hestia_sanitize_checkbox',
					'default'           => false,
				),
				array(
					'type'     => 'checkbox',
					'label'    => esc_html__( 'Enable full screen menu', 'hestia-pro' ),
					'section'  => 'hestia_navigation',
					'priority' => 10,
				)
			)
		);
	}

	/**
	 * The top bar callback for selective refresh.
	 */
	public function top_bar_callback() {
		$header_manager = new Hestia_Top_Bar();
		$top_bar        = $header_manager->header_top_bar();

		return $top_bar;
	}
}
