<!--?php die('<pre>'. print_r($content, true) .'</pre>')?-->
<section class="lp-page__node lp-node">
	<h2 class="lp-node__title"><?php print $title ?> <?php print $test_var ?></h2>
	<div class="lp-node__body">
		<div class="lp-node__content"><?php print render($content) ?></div>
	</div>
	<div class="lp-node__footer"></div>
</section>