<div class="row form-group">
	<label for="text" class="col-md-4"><?php  esc_html_e('Package Name','ivdirectories');?></label>
	<div class="col-md-8">
		<?php
			$recurring_text='';
			$api_currency= get_option( 'woocommerce_currency' );
			if($api_currency==''){$api_currency= 'USD';}
			if( $package_name==""){
				$iv_directories_pack='iv_directories_pack';
				$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type =%s  and post_status='draft' ", $iv_directories_pack);
				$membership_pack = $wpdb->get_results($sql);
				$total_package = count($membership_pack);
				if(sizeof($membership_pack)>0){
					$i=0;
					echo'<select name="package_sel" id ="package_sel" class=" form-control">';
					foreach ( $membership_pack as $row )
					{
						$srecurring= get_post_meta($row->ID, 'iv_directories_package_recurring', true);
						if($srecurring == 'on'){
							$spackage_amount=' | '.get_post_meta($row->ID, 'iv_directories_package_recurring_cost_initial', true).' '.$api_currency.'/'.get_post_meta($row->ID, 'iv_directories_package_recurring_cycle_count', true).' '.get_post_meta($row->ID, 'iv_directories_package_recurring_cycle_type', true);
							}else{
							$spackage_amount=' | '.(get_post_meta($row->ID, 'iv_directories_package_cost',true)=='' || get_post_meta($row->ID, 'iv_directories_package_cost',true)==0 ?'0':get_post_meta($row->ID, 'iv_directories_package_cost',true) ).' '.$api_currency;
						}
						echo '<option value="'. $row->ID.'" >'. $row->post_title.''.$spackage_amount.'</option>';
						if($i==0){$package_id=$row->ID;}
						$i++;
					}
					echo '</select>';
					$package_id= $membership_pack[0]->ID;
					$recurring= get_post_meta($package_id, 'iv_directories_package_recurring', true);
					if($recurring == 'on'){
						$package_amount=get_post_meta($package_id, 'iv_directories_package_recurring_cost_initial', true).' '.$api_currency.'/'.get_post_meta($package_id, 'iv_directories_package_recurring_cycle_count', true).' '.get_post_meta($package_id, 'iv_directories_package_recurring_cycle_type', true);
						}else{
						$package_amount=get_post_meta($package_id, 'iv_directories_package_cost',true).' '.$api_currency;
					}
				?>
				<?php
				}
				}else{
				echo '<label class=""> '.$package_name.'</label>';
				$recurring= get_post_meta($package_id, 'iv_directories_package_recurring', true);
				if($recurring == 'on'){
					$package_amount=get_post_meta($package_id, 'iv_directories_package_recurring_cost_initial', true).' '.$api_currency.'/'.get_post_meta($package_id, 'iv_directories_package_recurring_cycle_count', true).' '.get_post_meta($package_id, 'iv_directories_package_recurring_cycle_type', true);
					}else{
					$package_amount=get_post_meta($package_id, 'iv_directories_package_cost',true).' '.$api_currency;
				}
			}
		?>
	</div>
</div>
<div class="row form-group">
	<label for="text" class="col-md-4"><?php  esc_html_e('Amount','ivdirectories');?></label>
	<div class="col-md-8" id="p_amount"> <label class="control-label"><?php echo esc_html($package_amount) ; ?> </label>
	</div>
</div>
<input type="hidden" name="reg_error" id="reg_error" value="yes">
<input type="hidden" name="package_id" id="package_id" value="<?php echo esc_html($package_id); ?>">
<?php
	$iv_directories_payment_terms=get_option('iv_directories_payment_terms');
	$term_text='I have read & accept the Terms & Conditions';
	if( get_option( 'iv_directories_payment_terms_text' ) ) {
		$term_text= get_option('iv_directories_payment_terms_text');
	}
	if($iv_directories_payment_terms=='yes'){
	?>
	<div class="row">
		<div class="col-md-4 ">
		</div>
		<div class="col-md-8 ">
			<label>
				<input type="checkbox" data-validation="required"
				data-validation-error-msg="You have to agree to our terms "  name="check_terms" id="check_terms"> <?php echo $term_text; ?>
			</label>
		</div>
	</div>
	<?php
	}
?>
<div class="row">
	<div class="col-md-4">
	</div>
	<div class="col-md-8 ">
		<div id="errormessage" class="alert alert-danger mt-2 displaynone" role="alert"></div>
		<div id="paypal-button" class="margin-top-20">
		<div id="loading-3" style="display: none;"><img src='<?php echo wp_iv_directories_URLPATH. 'admin/files/images/loader.gif'; ?>' /></div>
			<?php
				if($eprecaptcha_api==''){
				?>											
				<button  id="submit_iv_directories_payment" name="submit_iv_directories_payment"  type="submit" class="btn btn-secondary"  >
					<?php  esc_html_e('Submit','ivdirectories');?>
				</button>
				<?php
					}else{
				?>
				<button  id="submit_iv_directories_payment" name="submit_iv_directories_payment"  class="btn btn-secondary g-recaptcha" data-sitekey="<?php echo esc_html($eprecaptcha_api); ?>"  data-callback='epluginrecaptchaSubmit' data-action='submit' >
					<?php  esc_html_e('Submit','ivdirectories');?>
				</button>
				<?php
				}
			?>								
		</div>
	</div>
</div>