const { registerBlockType } = wp.blocks;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, ToggleControl, TextControl } = wp.components;

registerBlockType('wpchill/car-block', {
    title: 'Car Block',
    icon: 'car',
    category: 'common',
    attributes: {
        showFilter: {
            type: 'boolean',
            default: true,
        },
        manufacturer: {
            type: 'string',
            default: '',
        },
        model: {
            type: 'string',
            default: '',
        },
        fuelType: {
            type: 'string',
            default: '',
        },
        color: {
            type: 'string',
            default: '',
        },
    },
    edit: function (props) {
        const { attributes, setAttributes } = props;
        const { showFilter, manufacturer, model, fuelType, color } = attributes;

        return (
            <div>
                <InspectorControls>
                    <PanelBody title="Car Settings">
                        <ToggleControl
                            label="Show Filter"
                            checked={showFilter}
                            onChange={(value) => setAttributes({ showFilter: value })}
                        />
                        <TextControl
                            label="Manufacturer"
                            value={manufacturer}
                            onChange={(value) => setAttributes({ manufacturer: value })}
                        />
                        <TextControl
                            label="Model"
                            value={model}
                            onChange={(value) => setAttributes({ model: value })}
                        />
                        <TextControl
                            label="Fuel Type"
                            value={fuelType}
                            onChange={(value) => setAttributes({ fuelType: value })}
                        />
                        <TextControl
                            label="Color"
                            value={color}
                            onChange={(value) => setAttributes({ color: value })}
                        />
                    </PanelBody>
                </InspectorControls>
            </div>
        );
    },
    save: function (props) {
        const { attributes } = props;
        const { showFilter, manufacturer, model, fuelType, color } = attributes;

        return (
            <div>
                {showFilter && (
                    <div>
                        <p>Manufacturer: {manufacturer}</p>
                        <p>Model: {model}</p>
                        <p>Fuel Type: {fuelType}</p>
                        <p>Color: {color}</p>
                    </div>
                )}
            </div>
        );
    },
});
