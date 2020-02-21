<?php
/**
 *	Search Page
 *
 *	@since 1.0
 */
$that = cloudfw();
$layout = $that->page_settings(
	'blog_search_page', 
	array(
		'layout' 		 => 'page_layout',
		'sidebar' 		 => 'page_sidebar',
		'titlebar_style' => 'page_titlebar_style',
		'skin' 			 => 'page_skin',
	), 
	'layout'
);
$that->set('blog_options', $that->blog_settings( 'blog_search_page' ));

$title = $that->get_meta('titlebar_title');
if ( empty($title) ) {			
	$that->set_meta('titlebar_title', sprintf( cloudfw_translate('search_titles'), get_search_query()) );
}



$that->set('content', "<script>
(function() {
var cx = '004348851079181866222:6fqqjoxqj8q';
var gcse = document.createElement('script');
gcse.type = 'text/javascript';
gcse.async = true;
gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
'//www.google.com/cse/cse.js?cx=' + cx;
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(gcse, s);
})();
</script>
<gcse:search linktarget=\"_parent\" queryParameterName=\"s\"></gcse:search>");

if ( empty($layout) )
	$layout = $that->blog_page_layout();

$that->return_layout( $layout );