<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

get_header(); ?>
<div class="container">
<div class="wrap">
	<?php if ( is_home() && ! is_front_page() ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php single_post_title(); ?></h1>
		</header>
	<?php else : 
global $wpdb;
		?>
	<header class="page-header">
		<h2 class="page-title heads">КАЛЬКУЛЯТОР ОБМЕНА КРИПТОВАЛЮТ</h2>
	</header>
	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
						<form id="calculator" method="post">
							<div class="row">
							<div class="col-md-1">
								<input type="numeric" name="counts" class="form-control">
							</div>
							<div class="col-md-3">
								<select id="from"  name="from" class="form-control">
									<option value="BTC">BTC - Bitcoin</option>
									<option value="ETH">ETH - Ethereum</option>
									<option value="USDT">USDT - TETHER</option>
									<option value="XRP">XRP - Ripple</option>
								</select>
							</div>
							<div class="col-md-1 heads">
								&#187;&#187;&#187;&#187;
							</div>
							<div class="col-md-3">
								<select id="to"  name="to" class="form-control">
									<option value="BTC">BTC - Bitcoin</option>
									<option value="ETH">ETH - Ethereum</option>
									<option value="USDT">USDT - TETHER</option>
									<option value="XRP">XRP - Ripple</option>
								</select>
							</div>
							<div class="col-md-3">
								<input type="text" name="result" id="result" class="form-control">
							</div>
							<div class="col-md-1">
								<input type="button" name="ok" value="Go" onclick="calc();" class="btn btn-success">
							</div>
						</div>
						</form>
						<?php

$lasttens = get_last_ten();

					?>
					<table>
						<th>Из</th>
						<th>В</th>
						<th>Результат</th>
						<?php
							foreach ( $lasttens as $lastten ) {
								echo "<tr><td>".$lastten->froms."</td><td>".$lastten->tos."</td><td>".$lastten->result."</td></tr>";
							}
	
						?>
					</table>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->
</div>
<script type="text/javascript">
	function calc(){
	$.ajax({ 
                      url: '/wp-content/plugins/cryptocalc/cryptocalc.php',
                      type: 'post',
                 
                      data: $("#calculator").serialize(),
                      success: function (value) {
                    console.log(value);
                    $('#result').val(value);
                      }
                  });
}
</script>

