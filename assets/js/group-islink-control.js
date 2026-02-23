wp.domReady(() => {
  const { addFilter } = wp.hooks;
  const { createHigherOrderComponent } = wp.compose;
  const { Fragment } = wp.element;
  const { InspectorControls } = wp.blockEditor || wp.editor;
  const { PanelBody, ToggleControl } = wp.components;

  // Add control only to core/group
  const withIsLinkControl = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      if (props.name !== "core/group") {
        return <BlockEdit {...props} />;
      }

      const { attributes, setAttributes } = props;
      const { isLink } = attributes;

      return (
        <Fragment>
          <BlockEdit {...props} />
          <InspectorControls>
            <PanelBody title="Link settings">
              <ToggleControl
                label="Link to post"
                checked={!!isLink}
                onChange={(value) => setAttributes({ isLink: value })}
              />
            </PanelBody>
          </InspectorControls>
        </Fragment>
      );
    };
  }, "withIsLinkControl");

  addFilter(
    "editor.BlockEdit",
    "mytheme/group-islink-control",
    withIsLinkControl
  );
});
