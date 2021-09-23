
/* block.js */
var el = wp.element.createElement;
var $ = jQuery

var presetColors = [
	{
		name: 'Black',
		slug: 'black',
		color: '#000'
	},
	{
		name: 'white',
		slug: 'fca-white',
		color: '#fff'
	},
	{
		name: 'Purple',
		slug: 'fca-purple',
		color: '#6236ff'
	},
	{
		name: 'Red',
		slug: 'fca-red',
		color: '#EA2027'
	},
	{
		name: 'Grey',
		slug: 'fca-grey',
		color: '#f2f2f2'
	},

]

var defaultSettings = [
	{
		'columnPopular': 'none',
		'planText': 'Starter',
		'planSubText': 'For getting started',
		'priceText': '$29',
		'pricePeriod': 'per month',
		'priceBilling': 'billed annually',
		'featuresText': '<li>Feature 1</li><li>Feature 2</li><li>Feature 3</li><li>Feature 4</li>',
		'buttonText': 'Add to Cart',
		'buttonURL': 'https://www.fatcatapps.com'
	},
	{
		'columnPopular': 'none',
		'planText': 'Pro',
		'planSubText': 'Best for most users',
		'priceText': '$39',
		'pricePeriod': 'per month',
		'priceBilling': 'billed annually',
		'featuresText': '<li>Feature 1</li><li>Feature 2</li><li>Feature 3</li><li>Feature 4</li>',
		'buttonText': 'Add to Cart',
		'buttonURL': 'https://www.fatcatapps.com'
	},
	{
		'columnPopular': 'none',
		'planText': 'Elite',
		'planSubText': 'For enterprises',
		'priceText': '$49',
		'pricePeriod': 'per month',
		'priceBilling': 'billed annually',
		'featuresText': '<li>Feature 1</li><li>Feature 2</li><li>Feature 3</li><li>Feature 4</li>',
		'buttonText': 'Add to Cart',
		'buttonURL': 'https://www.fatcatapps.com'
	},
]

var fca_ept_attributes = ( {

		type: { type: 'string', default: 'default' }, 
		content: { type: 'array', source: 'children', selector: 'p' },
		target: { type: 'string', default: '' }, 
		align: { type: 'string', default: 'wide' },

		// COLORS
		layoutBGColor: { type: 'string', default: '#f2f2f2' }, 
		layoutFontColor: { type: 'string', default: '#000' },
		buttonColor: { type: 'string', default: '#6236ff' },
		buttonFontColor: { type: 'string', default: '#fff' },
		accentColor: { type: 'string', default: '#6236ff' },

		// DYNAMIC COLUMN SETTINGS
		columnSettings: { type: 'array', default: defaultSettings },
		selectedCol: { type: 'int', default: 0 }, 
		selectedLayout: { type: 'string', default: 'layout2' },
		selectedSection: { type: 'string', default: 'plan' },
		showFontSizePickers: { type: 'string', default: 'none' },

		// FONT SETTINGS
		popularFontSize: { type: 'string', default: '12px' }, 
		planFontSize: { type: 'string', default: '48px' }, 
		planSubtextFontSize: { type: 'string', default: '16px' }, 
		priceFontSize: { type: 'string', default: '64px' }, 
		pricePeriodFontSize: { type: 'string', default: '16px' }, 
		priceBillingFontSize: { type: 'string', default: '13px' }, 
		featuresFontSize: { type: 'string', default: '20px' }, 
		buttonFontSize: { type: 'string', default: '24px' }, 

		// EXTRA SETTINGS
		columnHeight: { type: 'string', default: 'auto' },
		columnHeightToggle: { type: 'boolean', default: true }, 
		columnHeightTooltip: { type: 'string', default: 'none' },
		showPlanSubtext: { type: 'string', default: 'block' }, 
		showPlanSubtextToggle: { type: 'boolean', default: true },
		popularText: { type: 'string', default: 'Most Popular' },
		popularToolbarIcon: { type: 'string', default: 'star-empty' }, 
		showButtons: { type: 'string', default: 'grid' }, 
		showButtonsToggle: { type: 'boolean', default: true },
		urlTarget: { type: 'string', default: '_self' },
		urlTargetToggle: { type: 'boolean', default: false }, 
		showURLPopover: { type: 'string', value: 'none' },

	}
)

wp.blocks.registerBlockType('fatcatapps/pricing-table-blocks', {

	title: 'Pricing Table',

	icon: el("svg", {
			role: "img",
			focusable: "false",
			viewBox: "0 0 24 24",
			width: "24",
			height: "24",
			fill: '#111111',
			}, 
			el("path", {
				d: "M12 2C6.475 2 2 6.475 2 12C2 17.525 6.475 22 12 22C17.525 22 22 17.525 22 12C22 6.475 17.525 2 12 2ZM13.415 18.09V20H10.75V18.07C9.045 17.705 7.585 16.61 7.48 14.665H9.435C9.535 15.715 10.255 16.53 12.085 16.53C14.05 16.53 14.485 15.55 14.485 14.94C14.485 14.115 14.04 13.33 11.82 12.8C9.34 12.205 7.64 11.18 7.64 9.13C7.64 7.415 9.025 6.295 10.75 5.92V4H13.415V5.945C15.275 6.4 16.205 7.805 16.27 9.33H14.3C14.245 8.22 13.66 7.465 12.08 7.465C10.58 7.465 9.68 8.14 9.68 9.11C9.68 9.955 10.33 10.495 12.345 11.02C14.365 11.545 16.525 12.405 16.525 14.93C16.525 16.755 15.145 17.76 13.415 18.09Z"
			})
		),

	category: 'common',

	attributes: fca_ept_attributes,

	supports: { align: true },

	edit: fca_ept_block_edit,

	save: fca_ept_block_save

})


function fca_ept_block_edit( props ) {

	var $ = jQuery
	var columnSettings = props.attributes.columnSettings
	var selectedLayout = props.attributes.selectedLayout
	var selectedCol = props.attributes.selectedCol

	return el( wp.element.Fragment, { },

		fca_ept_toolbar_controls( props ),
		fca_ept_sidebar_settings( props ),

		el( 'div', { 
			style: { 
				textDecoration: 'none',
				alignItems: props.attributes.columnHeight === 'auto' ? 'stretch' : 'flex-end',
			}, 
			className: 'fca-ept-' + selectedLayout },
			Array.from( props.attributes.columnSettings, function( x, i ) {
				return el( 'div', { 
					style: { 
						backgroundColor: props.attributes.layoutBGColor,
						paddingTop: columnSettings[i].columnPopular === 'none' ? '45px' : '30px',
						paddingBottom: props.attributes.showButtons === 'grid' ? '30px' : '0px',
						marginTop: columnSettings[i].columnPopular === 'none' ? '10px' : '-5px',
						border: columnSettings[i].columnPopular === 'none' ? '0px solid' : '2px solid ' + props.attributes.buttonColor,
					},
						className: columnSettings[i].columnPopular === 'block' ? 'fca-ept-column fca-ept-column-popular' : 'fca-ept-column',
						onClick: ( function() { 
							fca_ept_select_column( props, i )
						}),
					},

					el( 'div', { 
						style: { 
							display: columnSettings[i].columnPopular,

							borderColor: props.attributes.buttonColor,
						},
						className: 'fca-ept-popular-div',
						},

						el(wp.editor.RichText, { 
							style: { 
								fontSize: props.attributes.popularFontSize,
								color: props.attributes.buttonFontColor,
								backgroundColor: fca_ept_hexToRGB( props.attributes.buttonColor, 0.65, 0 ),
							},
							className: 'fca-ept-popular-text',
							placeholder: 'Most Popular', 
							type: "text", 
							tagName: 'span',
							value: props.attributes.popularText, 
							onClick: ( function() { 
								fca_ept_select_section( props, 'popular', i ) 
							} ),
							onChange: ( function( newValue ) { 
								props.setAttributes( { popularText: newValue } )
							} )
						}),
					),

					el( 'div', { 
						className: 'fca-ept-plan-div',
						},

						el(wp.editor.RichText, { 
							style: { 
								fontSize: props.attributes.planFontSize,
								color: props.attributes.accentColor,
							}, 
							className: 'fca-ept-plan', 
							placeholder: 'Plan name', 
							type: "text", 
							tagName: 'span',
							value: columnSettings[i].planText, 
							onClick: ( function() { 
								fca_ept_select_section( props, 'plan', i ) 
							} ),
							onChange: ( function( newValue ) { 
								columnSettings[i].planText = newValue
								props.setAttributes( { columnSettings: columnSettings } )
							} )
						}),

						el(wp.editor.RichText, { 
							style: { 
								display: props.attributes.showPlanSubtext,
								color: props.attributes.layoutFontColor,
								fontSize: props.attributes.planSubtextFontSize,
							}, 
							className: 'fca-ept-plan-subtext', 
							placeholder: 'To get started', 
							type: "text", 
							tagName: 'span',
							value: columnSettings[i].planSubText, 
							onClick: ( function() { fca_ept_select_section( props, 'planSubtext', i ) } ),
							onChange: ( function( newValue ) { 
								columnSettings[i].planSubText = newValue
								props.setAttributes( { columnSettings: columnSettings } )
							} )
						}),
					),

					el( 'div', { 
						className: 'fca-ept-price-div',
						},

						el( 'div', { 
							className: 'fca-ept-price-container',
							},

							el(wp.editor.RichText, { 
								className: 'fca-ept-price',
								style: { 
									fontSize: props.attributes.priceFontSize,
									color: props.attributes.layoutFontColor,
								}, 
								placeholder: '$29', 
								type: "text", 
								tagName: 'span',
								value: columnSettings[i].priceText, 
								onClick: ( function( section ) { 
									fca_ept_select_section( props, 'price', i )
								} ),
								onChange: ( function( newValue ) { 
									columnSettings[i].priceText = newValue
									props.setAttributes( { columnSettings: columnSettings } )
								} )
							}),

							el( 'div', { 
								className: 'fca-ept-price-subtext',
								},
								el ( 'svg', {
									className: 'fca-ept-price-svg',
									style: { 
										backgroundColor: props.attributes.buttonColor 
									},
								}),
								el(wp.editor.RichText, { 
									style: { 
										fontSize: props.attributes.pricePeriodFontSize,
										color: props.attributes.layoutFontColor,
									},
									className: 'fca-ept-price-period', 
									placeholder: 'per month', 
									type: "text", 
									tagName: 'span',
									value: columnSettings[i].pricePeriod, 
									onClick: ( function() { 
										fca_ept_select_section( props, 'pricePeriod', i ) 
									} ),
									onChange: ( function( newValue ) { 
										columnSettings[i].pricePeriod = newValue
										props.setAttributes( { columnSettings: columnSettings } )
									} )
								}),

								el(wp.editor.RichText, { 
									style: { 
										fontSize: props.attributes.priceBillingFontSize,
										color: props.attributes.layoutFontColor,
									},
									className: 'fca-ept-price-billing', 
									placeholder: 'billed annually', 
									type: "text", 
									tagName: 'span',
									value: columnSettings[i].priceBilling, 
									onChange: ( function( newValue ) { 
										columnSettings[i].priceBilling = newValue
										props.setAttributes( { columnSettings: columnSettings } )
									} )
								}),
							),
						),
					),

					el( 'div', { 
						className: 'fca-ept-features-div',
						},
						el(wp.editor.RichText, { 
							style: { 
								fontSize: props.attributes.featuresFontSize,
								color: props.attributes.layoutFontColor,
							}, 
							className: 'fca-ept-features', 
							tagName: 'ul', 
							multiline: 'li', 
							placeholder: 'features offered', 
							type: "text", 
							value: columnSettings[i].featuresText, 
							onClick: ( function() { 
								fca_ept_select_section( props, 'features', i )
							} ),
							onChange: ( function( newValue ) { 
								columnSettings[i].featuresText = newValue
								props.setAttributes( { columnSettings: columnSettings } )
							} )
						}),
					),

					el( 'a', { 
						style: {
							display: props.attributes.showButtons,
							fontSize: props.attributes.buttonFontSize,
							color: props.attributes.buttonFontColor,
							backgroundColor: props.attributes.buttonColor,
						}, 
						className: 'fca-ept-button', 
						onClick: ( function() { 
							fca_ept_select_section( props, 'button', i ) 
						} ),
						type: 'button', 
					},
						el(wp.editor.RichText, { 
							placeholder: 'Add to Cart', 
							type: "text", 
							tagName: 'span',
							value: columnSettings[i].buttonText, 
							onChange: ( function( newValue ) { 
								columnSettings[i].buttonText = newValue
								props.setAttributes( { columnSettings: columnSettings } )
							} ),
						}),
					),
				) // end column div
			}) // end array
		) // end main div
	) // end fragment
}

function fca_ept_block_save( props ) {
	
	var columnSettings = props.attributes.columnSettings
	var selectedLayout = props.attributes.selectedLayout

	return el( 'div', { 
			style: { 
				textDecoration: 'none',
				alignItems: props.attributes.columnHeight === 'auto' ? 'stretch' : 'flex-end',
			}, 
			className: 'fca-ept-' + selectedLayout 
		},
		Array.from( props.attributes.columnSettings, function( x, i ) {
			return el( 'div', { 
				style: { 
					backgroundColor: props.attributes.layoutBGColor,
					paddingTop: columnSettings[i].columnPopular === 'none' ? '45px' : '30px',
					paddingBottom: props.attributes.showButtons === 'grid' ? '30px' : '0px',
					marginTop: columnSettings[i].columnPopular === 'none' ? '10px' : '-5px',
					border: columnSettings[i].columnPopular === 'none' ? '0px solid' : '2px solid ' + props.attributes.buttonColor,
				},
					className: columnSettings[i].columnPopular === 'block' ? 'fca-ept-column fca-ept-column-popular' : 'fca-ept-column',
				},

				el( 'div', { 
					style: { 
						boxShadow: '0px',
						display: columnSettings[i].columnPopular,
						borderColor: props.attributes.buttonColor,

					},
					className: 'fca-ept-popular-div',
				},

					el(wp.editor.RichText.Content, { 
						style: { 
							fontSize: props.attributes.popularFontSize,
							backgroundColor: fca_ept_hexToRGB( props.attributes.buttonColor, 0.8, 0 ),
							color: props.attributes.buttonFontColor,
						},
						className: 'fca-ept-popular-text',
						tagName: 'span', 
						value: props.attributes.popularText, 
					}),
				),

				el( 'div', { 
					className: 'fca-ept-plan-div',
					},

					el(wp.editor.RichText.Content, { 
						style: { 
							fontSize: props.attributes.planFontSize,
							color: props.attributes.accentColor,
						}, 
						className: 'fca-ept-plan', 
						tagName: 'span', 
						value: columnSettings[i].planText, 
					}),

					el(wp.editor.RichText.Content, { 
						style: { 
							display: props.attributes.showPlanSubtext,
							color: props.attributes.layoutFontColor,
							fontSize: props.attributes.planSubtextFontSize,
						}, 
						className: 'fca-ept-plan-subtext', 
						tagName: 'span', 
						value: columnSettings[i].planSubText, 
					}),

				),

				el( 'div', { 
					className: 'fca-ept-price-div',
					},

					el( 'div', { 
						className: 'fca-ept-price-container',
						},

						el(wp.editor.RichText.Content, { 
							style: { 
								fontSize: props.attributes.priceFontSize,
								color: props.attributes.layoutFontColor,
							}, 
							className: 'fca-ept-price', 
							tagName: 'span', 
							value: columnSettings[i].priceText, 
						}),

						el( 'div', {
								className: 'fca-ept-price-subtext',
							},
							el ( 'svg', {
								className: 'fca-ept-price-svg',
								style: { 
									backgroundColor: props.attributes.buttonColor },
							}),
							el(wp.editor.RichText.Content, { 
								style: { 
									fontSize: props.attributes.pricePeriodFontSize,
									color: props.attributes.layoutFontColor },
								className: 'fca-ept-price-period', 
								tagName: 'span', 
								value: columnSettings[i].pricePeriod, 
							}),

							el(wp.editor.RichText.Content, { 
								style: { 
									fontSize: props.attributes.priceBillingFontSize,
									color: props.attributes.layoutFontColor },
								className: 'fca-ept-price-billing', 
								tagName: 'span', 
								value: columnSettings[i].priceBilling, 
							}),
						),
					),
				),

				el( 'div', { 
					className: 'fca-ept-features-div',
				},
					el(wp.editor.RichText.Content, { 
						style: { 
							fontSize: props.attributes.featuresFontSize,
							color: props.attributes.layoutFontColor,
						}, 
						className: 'fca-ept-features', 
						tagName: 'ul', 
						multiline: 'li', 
						value: columnSettings[i].featuresText, 
					}),
				),

				el( 'a', { 
					style: { 
						display: props.attributes.showButtons,
						fontSize: props.attributes.buttonFontSize,
						color: props.attributes.buttonFontColor,
						backgroundColor: props.attributes.buttonColor,
					}, 
					className: 'fca-ept-button', 
					type: 'button', 
					href: columnSettings[i].buttonURL,
					target: props.attributes.urlTarget,
					rel: 'noopener noreferrer',
				},
					el(wp.editor.RichText.Content, { 
						className: 'fca-ept-button-text',
						tagName: 'span', 
						value: columnSettings[i].buttonText, 
					}),
				),
			) // end column div
		}) // end array
	) // end main div
}

function fca_ept_toolbar_controls( props ){

	var columnSettings = props.attributes.columnSettings
	var IncreaseFontsizeIcon = ( el("svg", {
			role: "img",
			focusable: "false",
			viewBox: "0 0 24 24",
			width: "24",
			height: "24"
			}, 
			el("path", {
				d: "M2 4V7H7V19H10V7H15V4H2Z",
				fill: "#111111"
			}),
			el("rect",{
				x: "13",
				y: "12",
				width: "8",
				height: "2",
				fill: "#000"
			}),
			el("rect",{
				x: "18",
				y: "9",
				width: "8",
				height: "2",
				transform: "rotate(90 18 9)",
				fill: "#000"
			}),
		)
	)

	var DecreaseFontsizeIcon = ( el("svg", {
			role: "img",
			focusable: "false",
			viewBox: "0 0 24 24",
			width: "24",
			height: "24"
			}, 
			el("path", {
				d: "M4 4V7H9V19H12V7H17V4H4Z",
				fill: "#111111"
			}),
			el("rect",{
				x: "15",
				y: "12",
				width: "6",
				height: "2",
				fill: "#000"
			}),
		) 
	)

	var changeButtonURL = ( el("svg", {
			role: "img",
			focusable: "false",
			viewBox: "0 0 24 24",
			width: "24",
			height: "24"
			}, 
			el("path", {
				d: "M15.6 7.2H14v1.5h1.6c2 0 3.7 1.7 3.7 3.7s-1.7 3.7-3.7 3.7H14v1.5h1.6c2.8 0 5.2-2.3 5.2-5.2 0-2.9-2.3-5.2-5.2-5.2zM4.7 12.4c0-2 1.7-3.7 3.7-3.7H10V7.2H8.4c-2.9 0-5.2 2.3-5.2 5.2 0 2.9 2.3 5.2 5.2 5.2H10v-1.5H8.4c-2 0-3.7-1.7-3.7-3.7zm4.6.9h5.3v-1.5H9.3v1.5z",
			}),
		)
	)

	// TOOLBAR CONTROLS
	return( el( wp.editor.BlockControls, { key: 'controls' },

		el( wp.components.ToolbarButton, { icon: 'plus-alt', label: 'Add column', onClick: ( function(){ fca_ept_add_column( props ) } ) } ),
		el( wp.components.ToolbarButton, { icon: 'trash', label: 'Remove selected column', onClick: ( function(){ fca_ept_del_column( props ) } ) } ),
		el( wp.components.ToolbarButton, { icon: props.attributes.popularToolbarIcon, label: 'Set as most popular', onClick: ( function() { fca_ept_set_popular( props ) } ) } ),
		el( wp.components.ToolbarButton, { icon: 'arrow-left-alt', label: 'Move selected column to the left', onClick: ( function(){ fca_ept_move_column( props, 'left' ) } ) } ),
		el( wp.components.ToolbarButton, { icon: 'arrow-right-alt', label: 'Move selected column to the right', onClick: ( function(){ fca_ept_move_column( props, 'right' ) } ) } ),
		el( wp.components.Popover, {
			style: { 
				display: props.attributes.showURLPopover ? props.attributes.showURLPopover : 'none',
			},
			className: 'fca-ept-url-popover',
			onFocusOutside: ( function(){ 
				props.setAttributes( { showURLPopover: 'none' } )
			} ),
		},

			el( wp.components.TextControl, { 
				className: 'fca-ept-url-input',
				value: columnSettings[props.attributes.selectedCol].buttonURL,
				onChange: (                                                                                                                                 
					function( newValue ){ 

						var columnSettingsData = Array.from( props.attributes.columnSettings )
						columnSettingsData[props.attributes.selectedCol].buttonURL = newValue
						props.setAttributes( { [columnSettings]: columnSettingsData } ) 

					} 
				)
			}),
			el( wp.components.PanelHeader, { label: 'Open in new tab' },
				el( wp.components.ToggleControl, { 
					checked: props.attributes.urlTargetToggle,
					className: 'fca-ept-toggle',
					onChange: (
						function( newValue ){ 
							if ( newValue ){
								props.setAttributes( { urlTarget: '_blank' } )

							} else {
								props.setAttributes( { urlTarget: '_self' } )
							}
							props.setAttributes( { urlTargetToggle: newValue } )
						}
					),
				}),
			),
		),
		el( wp.components.ToolbarButton, { style: { display: props.attributes.showFontSizePickers }, className: 'fca-ept-increase-fontsize', icon: IncreaseFontsizeIcon, label: 'Increase font size', onClick: ( function(){ fca_ept_increase_fontsize( props, props.attributes.selectedSection ) } ) } ),
		el( wp.components.ToolbarButton, { style: { display: props.attributes.showFontSizePickers }, icon: DecreaseFontsizeIcon, label: 'Decrease font size', onClick: ( function(){ fca_ept_decrease_fontsize( props, props.attributes.selectedSection ) } ) } ),
	))
}

function fca_ept_sidebar_settings( props ){

	var columnSettings = props.attributes.columnSettings
	return el( wp.editor.InspectorControls, { key: 'controls' },
					
		el( wp.editor.PanelColorSettings, {
			title: 'Background Color',
			className: 'fca-ept-colorpicker',
			initialOpen: false,
			colorSettings: [{
				colors: presetColors,
				label: 'Currently:',
				disableCustomColors: false,
				value: props.attributes.layoutBGColor,
				onChange: ( function( newValue ){ props.setAttributes( { layoutBGColor: newValue } ) } ),
			}]
		}),

		el( wp.editor.PanelColorSettings, {
			title: 'Font Color',
			className: 'fca-ept-colorpicker',
			initialOpen: false,
			colorSettings: [{
				colors: presetColors,
				label: 'Currently:',
				disableCustomColors: false,
				value: props.attributes.layoutFontColor,
				onChange: ( function( newValue ){ props.setAttributes( { layoutFontColor: newValue } ) } ),
			}]
		}),

		el( wp.editor.PanelColorSettings, {
			title: 'Button Color',
			className: 'fca-ept-colorpicker',
			initialOpen: false,
			colorSettings: [{
				colors: presetColors,
				label: 'Currently:',
				disableCustomColors: false,
				value: props.attributes.buttonColor,
				onChange: ( function( newValue ){ props.setAttributes( { buttonColor: newValue } ) } ),
			}]
		}),

		el( wp.editor.PanelColorSettings, {
			title: 'Button Font Color',
			className: 'fca-ept-colorpicker',
			initialOpen: false,
			colorSettings: [{
				colors: presetColors,
				label: 'Currently:',
				disableCustomColors: false,
				value: props.attributes.buttonFontColor,
				onChange: ( function( newValue ){ props.setAttributes( { buttonFontColor: newValue } ) } ),
			}]
		}),

		el( wp.editor.PanelColorSettings, {
			title: 'Accent Color',
			className: 'fca-ept-colorpicker',
			initialOpen: false,
			colorSettings: [{
				colors: presetColors,
				label: 'Currently:',
				disableCustomColors: false,
				value: props.attributes.accentColor,
				onChange: ( function( newValue ){ props.setAttributes( { accentColor: newValue } ) } ),
			}]
		}),

		el( wp.components.PanelHeader, { label: 'Show plan subtext' },
			el( wp.components.ToggleControl, { 
				checked: props.attributes.showPlanSubtextToggle,
				className: 'fca-ept-toggle',
				onChange: (
					function( newValue ){ 
						if ( newValue ){
							props.setAttributes( { showPlanSubtext: 'block' } )

						} else {
							props.setAttributes( { showPlanSubtext: 'none' } )
						}
						props.setAttributes( { showPlanSubtextToggle: newValue } )
					}
				),
			}),
		),

		el( wp.components.PanelHeader, { label: 'Match column height' },
			el( wp.components.Icon, {
				icon: 'editor-help',
				className: 'fca-ept-tooltip',
				onMouseOver: ( function(){
					props.setAttributes({ columnHeightTooltip: 'block' } )
				}),
				onMouseOut: ( function(){
					props.setAttributes({ columnHeightTooltip: 'none' } )
				})
			}),
			el( wp.components.Popover, {
				style: { 
					display: props.attributes.columnHeightTooltip,
				},
				className: 'fca-ept-tooltip-popover',
			},
				el( wp.editor.RichText, {
					type: 'text',
					value: 'Force all columns to be the same height. Useful if some columns have more features rows than others.',
				}),
			),
			el( wp.components.ToggleControl, { 
				checked: props.attributes.columnHeightToggle,
				className: 'fca-ept-toggle',
				onChange: (
					function( newValue ){ 
						if ( newValue ){
							props.setAttributes( { columnHeight: 'auto' } )
						} else {
							props.setAttributes( { columnHeight: 'fit-content' } )
						}
						props.setAttributes( { columnHeightToggle: newValue } )
					}
				),
			}),
		),

		el( wp.components.PanelHeader, { label: 'Show buttons' },
			el( wp.components.ToggleControl, { 
				checked: props.attributes.showButtonsToggle,
				className: 'fca-ept-toggle',
				onChange: (
					function( newValue ){ 
						if ( newValue ){
							props.setAttributes( { showButtons: 'grid' } )

						} else {
							props.setAttributes( { showButtons: 'none' } )
						}
						props.setAttributes( { showButtonsToggle: newValue } )
					}
				),
			}),
		),
	)
}


function fca_ept_add_column( props ){
	
	var columnCount = props.attributes.columnSettings.length

	var planDefaults = [
		'Starter',
		'Pro',
		'Elite',
		'Custom',
	]

	var newList = Array.from( props.attributes.columnSettings )
	
	newList.push( {
		'columnPopular': 'none',
		'planText': planDefaults[ columnCount ],
		'planSubText': 'For custom requirements',
		'priceText': '$' + Number( 29 + ( ( columnCount ) * 10 ) ),
		'pricePeriod': 'per month',
		'priceBilling': 'billed annually',
		'featuresText': '<li>Feature 1</li><li>Feature 2</li><li>Feature 3</li><li>Feature 4</li>',
		'buttonText': 'Add to Cart',
		'buttonURL': 'https://www.fatcatapps.com'
	} )
	
	props.setAttributes( { columnSettings: newList } )

}

function fca_ept_del_column ( props ) {
	var columnSettings = props.attributes.columnSettings
	var selectedCol = props.attributes.selectedCol
	if ( columnSettings.length > 1 ){
		columnSettings.splice( selectedCol, 1 )
		props.setAttributes( { [columnSettings]: columnSettings } )
		props.setAttributes( { selectedCol: ( columnSettings.length -1 ) } )
	}
}

function fca_ept_select_column ( props, id ) {
	var columnSettings = props.attributes.columnSettings
	props.setAttributes ( { selectedCol: id } )

	$('.fca-ept-column').filter( function(i,column){
		column.classList.remove('fca-ept-selected-column')
	})
	$('.fca-ept-column')[id].classList.add('fca-ept-selected-column')

	if ( columnSettings[id].columnPopular === 'block' ){
		props.setAttributes ( { popularToolbarIcon: 'star-filled' } )
	} else {
		props.setAttributes ( { popularToolbarIcon: 'star-empty' } )
	}
}

function fca_ept_move_column ( props, direction ) {

	var columnSettings = props.attributes.columnSettings
	var selectedCol = props.attributes.selectedCol

	if ( direction === 'left' && selectedCol !== 0 ){
		var fromPosition = selectedCol
		var toPosition = fromPosition -1
	}
	if ( direction === 'right' && selectedCol < ( columnSettings.length -1 ) ){
		var fromPosition = selectedCol
		var toPosition = fromPosition +1
	}

	if ( fromPosition || toPosition ){
		var columnData = columnSettings.splice(fromPosition, 1)[0];
		columnSettings.splice(toPosition, 0, columnData);
		props.setAttributes( { [columnSettings]: columnSettings } )
		fca_ept_select_column( props, toPosition )
	}
}

function fca_ept_set_popular ( props ) {

	var columnSettings = props.attributes.columnSettings
	var selectedCol = props.attributes.selectedCol
	
	columnSettings.filter(function (col, i){

		if ( i === selectedCol ){
			if ( col.columnPopular === 'none' ){
				col.columnPopular = 'block'
				props.setAttributes ( { popularToolbarIcon: 'star-filled' } )
			} else {
				col.columnPopular = 'none'
				props.setAttributes ( { popularToolbarIcon: 'star-empty' } )
			}
		} else {
			col.columnPopular = 'none'
		}

		var columnSettingsData = props.attributes.columnSettings
		props.setAttributes( { columnSettings: columnSettingsData } )
	})
}


function fca_ept_select_section ( props, section, id ) {

	props.setAttributes ( { selectedSection: section } )

	if ( section === 'button' ){ 
		props.setAttributes( { showURLPopover: 'block' } )
	} else {
		props.setAttributes( { showURLPopover: 'none' } )
	}

	if ( props.attributes.showFontSizePickers === 'none' ){
		props.setAttributes ( { showFontSizePickers: 'inline-flex' } )
	}
}

function fca_ept_increase_fontsize ( props, section ){

	var columnSettings = props.attributes.columnSettings
	var fontSizeStr = eval('props.attributes.' + section + 'FontSize').toString()
	var fontSizeAttr = section + 'FontSize'

	fontsize = ( parseInt( fontSizeStr.slice(0,-2) ) ) + 2
	props.setAttributes( { [fontSizeAttr]: fontsize + 'px' } )

}

function fca_ept_decrease_fontsize ( props, section ){

	var columnSettings = props.attributes.columnSettings
	var fontSizeStr = eval('props.attributes.' + section + 'FontSize').toString()
	var fontSizeAttr = section + 'FontSize'

	fontsize = ( parseInt( fontSizeStr.slice(0,-2) ) ) - 2
	props.setAttributes( { [fontSizeAttr]: fontsize + 'px' } )

}

function fca_ept_hexToRGB(hex, alpha, darken) {
	if ( hex ){
		if ( hex.length === 7 ){
			var r = parseInt(hex.slice(1, 3), 16),
				g = parseInt(hex.slice(3, 5), 16),
				b = parseInt(hex.slice(5, 7), 16)
		} 
		if ( hex.length === 4 ){
			var r = parseInt(hex.slice(1, 2) + hex.slice(1, 2), 16),
				g = parseInt(hex.slice(2, 3) + hex.slice(2, 3), 16),
				b = parseInt(hex.slice(3, 4) + hex.slice(3, 4), 16)
		}
		if (alpha) {
			return "rgba(" + r + "," + g + "," + b + "," + alpha + ")"
		} 
		if (darken) {
			if( ( r - darken ) > 0 ){ r -= darken } else { r = 0 }
			if( ( g - darken ) > 0 ){ g -= darken } else { g = 0 }
			if( ( b - darken ) > 0 ){ b -= darken } else { b = 0 }
			return "rgb(" + r + "," + g + "," + b + ")"
		}
	} else { return "rgb(255,255,255)" }
}