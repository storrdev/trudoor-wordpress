<?php

/**
 * Load WIGUM
 */

// Main WIGUM Include
require($_SERVER['DOCUMENT_ROOT'] . "/library/core.php");

/**
 * Page Variables
 */

// Set the page title
Wigum\Core\Page::init()->title .= "404 - Page Not Found";


/**
 * End PHP
 */

?>


<?php Wigum\Core\Page::header(); ?>

<div class="container clearfix">
    <?=$page->display_message?>

    <h2>404 - Page Not Found</h2>

</div> <!-- .container -->

<?php Wigum\Core\Page::footer(); ?>
