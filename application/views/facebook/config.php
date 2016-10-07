<?php
	$config_values = $_SESSION['fb_comment_variables'];
	$colorscheme_array = array(
		'dark' => 'Dark',
		'light' => 'Light'
	);
	$order_by_array = array(
		'social' => 'Social',
		'reverse_time' => 'Reverse Time',
		'time' => 'Time'
	);
?>

<div class="form-box">
	<form action="" method="POST">
		<div class="form-control">
			<label for="num_posts">Default number of comments</label>
			<input type="number" name="num_posts" value="<?php echo $config_values->num_posts; ?>">
		</div>
		<div class="form-control">
			<label for="colorscheme">Color scheme type</label>
			<select name="colorscheme">
				<?php foreach ( $colorscheme_array as $k => $v ) : ?>
					<option value="<?php echo $k; ?>" <?php echo ( $config_values->colorscheme == $k ) ? 'selected' : ''; ?>>&nbsp;<?php echo $v; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-control">
			<label for="order_by">Order comments by</label>
			<select name="order_by">
				<?php foreach ( $order_by_array as $k => $v ) : ?>
					<option value="<?php echo $k; ?>" <?php echo ( $config_values->order_by == $k ) ? 'selected' : ''; ?>>&nbsp;<?php echo $v; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-control">
			<label for="width">Width of comments area (px). Leave blank to full width</label>
			<input type="number" name="width" value="<?php echo @$config_values->width; ?>">
		</div>
		<div class="form-control">
			<input type="submit" name="fb_comment_update" id="update" class="button button-primary button-large" value="Update">
		</div>
	</form>
</div>

<?php unset( $_SESSION['fb_comment_variables'] ); ?>