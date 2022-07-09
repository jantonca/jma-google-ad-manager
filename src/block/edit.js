
const { Component } = wp.element;
const {
	InspectorControls,
	BlockControls,
	AlignmentToolbar,
	RichText,
} = wp.blockEditor;
const {
	PanelBody,
	PanelRow,
	SelectControl,
	Toolbar,
} = wp.components;
const { __ } = wp.i18n; // Import __() from wp.i18n
/**
 * External dependencies
 */
import classNames from 'classnames';
class Edit extends Component {
	render() {
		/**
		 * Constants
		*/
		const {
			className,
			attributes,
			setAttributes,
		} = this.props;
		const {
			adType,
			adTag,
			labelAlignment,
			classNamesContainer,
			adLabel,
			adPosition,
		} = attributes;
		const blockControls = [
			{
				icon: 'editor-alignleft',
				title: __( 'Ad on left', 'intermedia-blocks' ),
				onClick: () => setAttributes( { adPosition: 'ad-is-left' } ),
				isActive: adPosition === 'ad-is-left',
			},
			{
				icon: 'editor-aligncenter',
				title: __( 'Ad centered', 'intermedia-blocks' ),
				onClick: () => setAttributes( { adPosition: 'ad-is-centered' } ),
				isActive: adPosition === 'ad-is-centered',
			},
			{
				icon: 'editor-alignright',
				title: __( 'Ad on right', 'intermedia-blocks' ),
				onClick: () => setAttributes( { adPosition: 'ad-is-right' } ),
				isActive: adPosition === 'ad-is-right',
			},
		];
		let tagNumber = '';
		if ( adTag ) {
			tagNumber = adTag;
		}
		const images = {
			mrec: {
				url: 'https://via.placeholder.com/300x250/e1f4ee.png?text=' + tagNumber,
				alt: 'MREC image',
			},
			leaderboard: {
				url: 'https://via.placeholder.com/970x250/e1f4ee.png?text=Leaderboard+' + tagNumber,
				alt: 'leaderboard image',
			},
			halfPage: {
				url: 'https://via.placeholder.com/300x600/e1f4ee.png?text=Half-Page+' + tagNumber,
				alt: 'half-page image',
			},
		};
		let alt = 'Default image';
		let src = 'https://via.placeholder.com/400x300/f2c7ba.png?text=Select+the+ad+type';
		if ( adType === 'show_mrec' ) {
			alt = images.mrec.alt;
			src = images.mrec.url;
		}
		if ( adType === 'show_leaderboard' ) {
			alt = images.leaderboard.alt;
			src = images.leaderboard.url + ' 1';
		}
		if ( adType === 'show_half_page' ) {
			alt = images.halfPage.alt;
			src = images.halfPage.url;
		}
		const classes = classNames( className, {
			[ adType ]: true,
			[ adPosition ]: true,
			[ `is-${ labelAlignment }` ]: true,
		} );
		setAttributes( { classNamesContainer: classes } );
		return (
			[
				<InspectorControls key="inspector" >
					<PanelBody title="Ad Settings">
						<PanelRow>
							<SelectControl
								label="Types"
								help="Example: MREC"
								value={ adType }
								options={ window.igamGlobalObject.ads_type_options.map( type => {
									return { value: type.value, label: type.label };
								} ) }
								onChange={ ( value ) => setAttributes( { adType: value, adTag: '' } ) }
							/>
						</PanelRow>
						<PanelRow>
							{ adType === 'show_mrec' && (
								<SelectControl
									label="Tags"
									help="Example: MREC 1"
									value={ adTag }
									options={ window.igamGlobalObject.ads_tags_options.mrec.map( type => {
										return { value: type.value, label: type.label };
									} ) }
									onChange={ ( value ) => setAttributes( { adTag: value } ) }
								/>
							) }
							{ adType === 'show_leaderboard' && (
								<SelectControl
									label="Tags"
									help="Example: Leaderboard 1"
									value={ adTag }
									options={ window.igamGlobalObject.ads_tags_options.leaderboard.map( type => {
										return { value: type.value, label: type.label };
									} ) }
									onChange={ ( value ) => setAttributes( { adTag: value } ) }
								/>
							) }
							{ adType === 'show_half_page' && (
								<SelectControl
									label="Tags"
									help="Example: Half-Page 1"
									value={ adTag }
									options={ window.igamGlobalObject.ads_tags_options.halfpage.map( type => {
										return { value: type.value, label: type.label };
									} ) }
									onChange={ ( value ) => setAttributes( { adTag: value } ) }
								/>
							) }
						</PanelRow>
					</PanelBody>
				</InspectorControls>,
				<BlockControls key="controls">
					<Toolbar controls={ blockControls } ></Toolbar>,
					<AlignmentToolbar
						value={ labelAlignment }
						onChange={ ( newalign ) => setAttributes( { labelAlignment: newalign } ) }
					/>
				</BlockControls>,
				<div className={ classNamesContainer } key="ad">
					<div>
						<img src={ src } alt={ alt } />
						<RichText
							onChange={ value => setAttributes( { adLabel: value } ) }
							placeholder={ __( 'Write the label here…', 'block-post' ) }
							value={ adLabel }
							tagName="span"
							className="ad-label"
							formattingControls={ [ 'bold', 'link', 'color' ] }
						/>
					</div>
				</div>,
			]

		);
	}
}
export default Edit;
