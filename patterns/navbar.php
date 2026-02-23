<?php
/**
 * Title: Predefined Navbar
 * Slug: wirmachenwien/navbar
 * Categories: header
 * Block Types: core/template-part/header
 * Inserter: yes
 */
?>
<!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull">
  <!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between"}} -->
  <div class="wp-block-group alignwide is-layout-flex" style="justify-content:space-between;">
    <!-- wp:image {"width":150,"height":112,"sizeSlug":"full"} -->
    <figure class="wp-block-image size-full is-resized"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/WMW_Logo_digital_RGB.svg" alt="wirmachen.wien" width="150" height="112"/></figure>
    <!-- /wp:image -->
    <!-- wp:group {"layout":{"type":"flex","justifyContent":"right"}} -->
    <div class="wp-block-group is-layout-flex" style="justify-content:right;">
      <!-- wp:navigation {"orientation":"horizontal","itemsJustification":"right","overlayMenu":"always","overlayBackgroundColor":"base","overlayTextColor":"contrast","ariaLabel":"Menu"} -->
      <nav aria-label="Menu" class="wp-block-navigation items-justified-right is-responsive">
        <!-- wp:navigation-link {"label":"Über uns","url":"/sample-page/"} /-->
        <!-- wp:navigation-link {"label":"Kalender","url":"/sample-page/"} /-->
        <!-- wp:navigation-link {"label":"News","url":"/sample-page/"} /-->
        <!-- wp:navigation-link {"label":"How Tos","url":"/sample-page/"} /-->
      </nav>
      <!-- /wp:navigation -->
      <!-- wp:buttons -->
      <div class="wp-block-buttons">
        <!-- wp:button -->
        <div class="wp-block-button"><a class="wp-block-button__link">Newsletter</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->
    </div>
    <!-- /wp:group -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->
