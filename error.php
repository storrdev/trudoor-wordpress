<?php
/**
 * @deprecated
 */

// Main WIGUM Include
require($_SERVER['DOCUMENT_ROOT'] . "/library/core.php");

Wigum\Core\Logger::error("error.php hit from $_SERVER[HTTP_REFERER]");

// Set the page title
Wigum\Core\Page::init()->title .= "Error Occurred";

Wigum\Core\Page::header(); ?>

<div class="container clearfix">

    <h2>Error Occurred</h2>

    <p>Oops! There was an error.</p>

</div> <!-- .container -->

<?php
Wigum\Core\Page::footer();