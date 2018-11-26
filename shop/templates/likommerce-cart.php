<?php
// IF TRY TO GET DIRECTLY BY URL
if(
	!isset ( $_POST['parentid'] ) &&
	! wp_verify_nonce( $_POST['lk24_nonce'], 'lk24_selecting_label')
){
	$location = get_site_url();
	wp_redirect( $location, 301 );
	exit;
}

$cookie_id = (!isset($_COOKIE['lk24_cart_cookie'])) ?
	$cookie_id = lk24_create_cookie() :
	$cookie_id = $_COOKIE['lk24_cart_cookie'];

// CREATE ORDER
lk24_create_order($cookie_id, $_POST);

// ADD ITEM TO ORDER
lk24_add_item_to_order($cookie_id, $_POST);

// GET ORDER AND ITEMS
$cart = lk24_order_exists($cookie_id);
$items = lk24_get_order_items($cookie_id);

get_header();

if ($cart){
	foreach($cart as $order){
		if($items){

?>
<div id="cart-<?= $order->id ?>" class="lk24-cart-list-placeholder cart-<?= $order->id ?>">
	<div class="lk24-cart-header">
		<h1><?= _e('Shopping Cart', 'likommerce')?></h1>
		<a class="lk24-goto-checkout-link" href="<?= home_url('likommerce-checkout')?>/"><?= _e('Go to checkout', 'likommerce') ?></a>
	</div>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
		<thead>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2"><?= _e('Label', 'likommerce') ?></td>
				<td align="center"><?= _e('Label Price', 'likommerce') ?></td>
				<td><?= _e('Licor', 'likommerce') ?></td>
				<td align="center"><?= _e('Licor Price', 'likommerce') ?></td>
				<td align="center"><?= _e('Boxes', 'likommerce') ?></td>
				<td align="center"><?= _e('Total', 'likommerce') ?></td>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach($items as $item){
				$item = lk24_reorder_item_info($item);
		?>
			<tr>
				<td><span class="cart-row-remove-sign">x</span></td>
				<td><img src="<?= $item['label_thumb_url'] ?>" alt="<?= $item['label_name'] ?>" title="<?= $item['label_name'] ?>" width="40"></td>
				<td><?= $item['label_name'] ?></td>
				<td align="center">&euro;<?= $item['label_price'] ?></td>
				<td><?= $item['licor_name'] ?></td>
				<td align="center">&euro;<?= $item['licor_price'] ?></td>
				<td align="center"><?= $item['qty'] ?></td>
				<td align="center">&euro;<?= $item['qty'] * $item['licor_price'] + $item['label_price'] ?></td>
			</tr>
		<?php } // END FOREACH ITEM ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6">
					<strong><?= _e('Order Hash') ?>: <?= $order->cookie_sesion ?></strong>
				</td>
				<td colspan="2" align="right"><a class="lk24-goto-checkout-link" href="<?= home_url('likommerce-checkout')?>/"><?= _e('Go to checkout', 'likommerce') ?></a></td>
			</tr>
		</tfoot>
	</table>
	<div class="lk24-cart-footer">
		<h2><?= _e('Cart totals', 'likommerce')?></h2>
		<a class="lk24-goto-checkout-link" href="<?= home_url('likommerce-checkout')?>/"><?= _e('Go to checkout', 'likommerce') ?></a>
	</div>
</div>
<?php
		}else{
			echo '<p>' . esc_html_e('There are no items in the shopping cart yet.', 'likommerce') . '</p>';
		} // END IF ITEMS
	} // END FOREACH ORDER
} // END IF ORDER
//mostrar($_POST);
//mostrar($_COOKIE);
//mostrar(lk24_order_exists($cookie_id) );
get_footer();
