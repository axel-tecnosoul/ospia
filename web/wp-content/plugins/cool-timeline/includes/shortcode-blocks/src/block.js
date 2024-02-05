/**
 * Block dependencies
 */
import CtlIcon from './icons';
import CtlLayoutType from './layout-type'
import PreviewImage from './images/timeline.png'

/**
 * Internal block libraries
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const baseURL=ctlUrl;
const LayoutImgPath=baseURL+'/includes/shortcode-blocks/layout-images';
const { apiFetch } = wp;
const {
	RichText,
	InspectorControls,
	BlockControls,
} = wp.blockEditor;
const { Fragment,useEffect } = wp.element
const { 
	PanelBody,
	PanelRow,
	TextareaControl,
	TextControl,
	Dashicon,
	Toolbar,
	ButtonGroup,
	Button,
	SelectControl,
	Tooltip,
	RangeControl,
	TabPanel,
	Card,
	CardBody,
	Panel
} = wp.components;


/**
 * Register block

 */
export default registerBlockType( 'cool-timleine/shortcode-block', {
		// Block Title
		title: __( 'Cool Timeline Shortcode' ),
		// Block Description
		description: __( 'Cool Timeline Shortcode Generator.' ),
		// Block Category
		category: 'layout',
		// Block Icon
		icon:CtlIcon,
		// Block Keywords
		keywords: [
			__( 'cool timeline' ),
			__( 'timeline shortcode' ),
			__( 'cool timeline block' )
		],
	attributes: {
		layout: {
			type: 'string',
			default: 'default'
		},
		skin: {
			type: 'string',
			default: 'default'
		},
		postperpage: {
            type: 'string',
            default:10
        },
		slideToShow: {
            type: 'string',
            default:''
        },
		dateformat: {
			type: 'string',
			default:  'F j',
		},
		icons: {
			type: 'string',
			default:  'NO',
		},
		animation: {
			type: 'string',
			default:  'none',
		},
		storycontent:{
			type: 'string',
			default:  'short'
		},
		order:{
			type: 'string',
			default:'DESC'
		},
		isPreview:{
			type: 'boolean',
			default: false
		},
	},
	// Defining the edit interface
	edit: props => {

		useEffect(()=>{
			'' === props.attributes.slideToShow && props.setAttributes({slideToShow:'4'});
		},[]);

		const skinOptions = [
            { value: 'default', label: __( 'Default' ) },
			{ value: 'clean', label: __( 'Clean' ) }
		];
		// const iconOptions = [
        //     { value: 'NO', label: __( 'NO' ) },
        //     { value: 'YES', label: __( 'YES' ) }
		// ];
		const DfromatOptions = [
		 {value:"F j",label:"F j"},
		 {value:"F j Y",label:"F j Y"},
		 {value:"Y-m-d",label:"Y-m-d"},
		 {value:"m/d/Y",label:"m/d/Y"},
		 {value:"d/m/Y",label:"d/m/Y"},
		 {value:"F j Y g:i A",label:"F j Y g:i A"},
		 {value:"Y",label:"Y"}
  		];
		const layoutOptions = [
            { value: 'default', label: __( 'Vertical' ) },
			{ value: 'horizontal', label: __( 'Horizontal' ) },
			{ value: 'one-side', label: __( 'One Side Layout' ) },
			{ value: 'simple', label: __( 'Simple Layout' ) },
			{ value: 'compact', label: __( 'Compact Layout' ) }
		];
		const animationOptions = [
            { value: 'none', label: __( 'None' ) },
            { value: 'fade-up', label: __( 'fadeInUp' ) }
		];
		const contentSettings=[{label:"Summary",value:"short"},
			{label:"Full Text",value:"full"}
			];
		const general_settings=
			<Panel className="ctl_shortcode_setting_panel">
				<PanelBody title={ __( 'Timeline General Settings' ) } >
					<SelectControl
						label={ __( 'Select Layout' ) }
						description={ __( 'Vertical/Horizontal' ) }
						options={ layoutOptions }
						value={ props.attributes.layout }
						onChange={ ( value ) =>props.setAttributes( { layout: value } ) }
						__nextHasNoMarginBottom
					/>
					{props.attributes.layout != "horizontal" && 
						<Fragment>
						<div className="ctl_shortcode-button-group_label">{__("Skin")}</div>
						<ButtonGroup className="ctl_shortcode-button-group">
							<Button onClick={(e) => {props.setAttributes({skin: 'default'})}} className={props.attributes.skin == 'default' ? 'active': ''} isSmall={true}>Default</Button>
							<Button onClick={(e) => {props.setAttributes({skin: 'clean'})}} className={props.attributes.skin == 'clean' ? 'active': ''} isSmall={true}>Clean</Button>
						</ButtonGroup>
						<p>Create Light, Dark or Colorful Timeline</p>
						</Fragment>
					}
					<PanelRow className="ctl_shortcode_setting_row">
						<SelectControl
							label={ __( 'Stories Description?' ) }
							options={ contentSettings }
							value={ props.attributes.storycontent }
							onChange={ ( value ) =>props.setAttributes( { storycontent: value } ) }
						/>	
					</PanelRow>
					{props.attributes.storycontent == 'short' ? 
						<p><strong>Summary</strong>:- Short description</p>
						:<p><strong>Full</strong>:- All content with formated text.</p>
					}					
					<RangeControl
						label={__( 'Display Pers Page?' )}
						value={ parseInt(props.attributes.postperpage) }
						onChange={ ( value ) => props.setAttributes( { postperpage: value.toString() } ) }
						min={ 1 }
						max={ 50}
						step={ 1 }
					/>
					{'horizontal' === props.attributes.layout &&
						<RangeControl
						label={__( 'Slide To Show?' )}
						value={ parseInt(props.attributes.slideToShow) }
						onChange={ ( value ) => props.setAttributes( { slideToShow: value.toString() } ) }
						min={ 1 }
						max={ 10}
						step={ 1 }
						/>
					}
				</PanelBody>
			</Panel>;		
		const advanced_settings=
		<PanelBody title={ __( 'Timeline Advanced Settings' ) } >
			<div className="ctl_shortcode-button-group_label">{__("Stories Order?")}</div>
			<ButtonGroup className="ctl_shortcode-button-group">
				<Button onClick={(e) => {props.setAttributes({order: 'ASC'})}} className={props.attributes.order == 'ASC' ? 'active': ''} isSmall={true}>ASC</Button>
				<Button onClick={(e) => {props.setAttributes({order: 'DESC'})}} className={props.attributes.order == 'DESC' ? 'active': ''} isSmall={true}>DESC</Button>
			</ButtonGroup>
			<p>For Ex :- {props.attributes.order=='DESC' ? 'DESC(2017-1900)' : 'ASC(1900-2017)'}</p>
			<SelectControl
                label={ __( 'Date Formats' ) }
                description={ __( 'yes/no' ) }
                options={ DfromatOptions }
                value={ props.attributes.dateformat }
				onChange={ ( value ) =>props.setAttributes( { dateformat: value } ) }
            />
			<div className="ctl_shortcode-button-group_label">{__("Display Icons (By default Is Dot)")}</div>
			<ButtonGroup className="ctl_shortcode-button-group">
				<Button onClick={(e) => {props.setAttributes({icons: 'YES'})}} className={props.attributes.icons == 'YES' ? 'active': ''} isSmall={true}>Icons</Button>
				<Button onClick={(e) => {props.setAttributes({icons: 'NO'})}} className={props.attributes.icons == 'NO' ? 'active': ''} isSmall={true}>Dot</Button>

			</ButtonGroup>
			{ props.attributes.layout!="horizontal" &&
				<SelectControl
                label={ __( 'Animation' ) }
                description={ __( 'yes/no' ) }
                options={ animationOptions }
                value={ props.attributes.animation }
				onChange={ ( value ) =>props.setAttributes( { animation: value } ) }
            	/>
			}
		</PanelBody>;
		return [
			
			!! props.isSelected && (
				<InspectorControls key="inspector">
					<TabPanel
					className="ctl_shortcode-tab-settings"
					activeClass="active-tab"
					tabs={ [
						{
							name: 'general_settings',
							title: 'General',
							className: 'ctl-settings_tab-one',
							content: general_settings
						},
						{
							name: 'advanced_settings',
							title: 'Advanced',
							className: 'ctl-settings_tab-two',
							content: advanced_settings
						},
					] }
					>
						{ ( tab ) => <Card>{tab.content}</Card> }
					</TabPanel>
					<PanelBody title={__("View Timeline Demos","timeline-block")} initialOpen={false}>
					<CardBody className="ctl-shortcode-block-demo-button">
						<a target="_blank" className="button button-primary" href="https://cooltimeline.com/demo/?utm_source=ctl_plugin&utm_medium=inside&utm_campaign=demo&utm_content=ctl_shortcode">View Demos</a>
						<a target="_blank" className="button button-primary" href="https://cooltimeline.com/buy-cool-timeline-pro/?utm_source=ctl_plugin&utm_medium=inside&utm_campaign=get_pro&utm_content=ctl_shortcode">Buy Pro</a>
					</CardBody>
				</PanelBody>
				</InspectorControls>
			),
			props.attributes.isPreview ? <img src={PreviewImage}></img> :
			<div className={ props.className } key={props.clientId}>
				<CtlLayoutType  LayoutImgPath={LayoutImgPath} attributes={props.attributes} />
				<div className="ctl-block-shortcode">
					{props.attributes.layout === 'horizontal'
					?<>
					[cool-timeline 
						layout="{props.attributes.layout}"
						show-posts="{props.attributes.postperpage}"
						items="{props.attributes.slideToShow}"
						date-format="{ props.attributes.dateformat}"
						icons="{props.attributes.icons}"
						story-content="{props.attributes.storycontent}"
						order="{props.attributes.order}"
					]
					</>:
					<>
					[cool-timeline 
						layout="{props.attributes.layout}" 
						skin="{props.attributes.skin}"
						show-posts="{props.attributes.postperpage}"
						date-format="{ props.attributes.dateformat}"
						icons="{props.attributes.icons}"
						animation="{ props.attributes.animation}"
						story-content="{props.attributes.storycontent}"
						order="{props.attributes.order}"
					]
					</>
					}
				</div>
			</div>
		];
	},
	// Defining the front-end interface
	save() {
		// Rendering in PHP
		return null;
	},
	example: {
		attributes: {
			isPreview: true,
		},
	},
});
