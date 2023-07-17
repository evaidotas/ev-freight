<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$freightLimit = 5;

if (isset($attributes['numberSelection'])) {
	$freightLimit = $attributes['numberSelection'];
}

?>

<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php
	$url = 'https://api.spotos.eu/v1/public/freights?per_page=' . $freightLimit;

	$response = wp_remote_get($url);

	if (is_wp_error($response)) {
		_e('Error retrieving data from API', 'ev-freight');
		return;
	}

	$body = wp_remote_retrieve_body($response);
	$data = json_decode($body, true);

	if ($data === null || !isset($data['records'])) {
		_e('Error parsing JSON', 'ev-freight');
		return;
	}
	?>

	<div class="freight-grid">

		<?php
		$flagUrl = 'https://spotos.eu/wp-content/themes/spotos/assets/images/country_flags/';

		foreach ($data['records'] as $item) { ?>
			<div class="freight-grid_item">
				<?php
				if (isset($item['locations'])) {
					foreach ($item['locations'] as $location) { ?>
						<div class="flex flex-row justify-start align-start">
							<img
									class="flag mr-1"
									title="<?php echo esc_attr($location[0]['country_name']); ?>"
									src="<?php echo esc_url($flagUrl . $location[0]['country_code'] . '.svg'); ?>"
							>
							<div class="delivery-info">
								<div class="country">
									<?php echo esc_html($location[0]['country_name']) . ', ' . esc_html($location[0]['country_code']) . ' ' . esc_html($location[0]['postcode']); ?>
								</div>
								<div class="date">
									<?php
									$arrivalFrom = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', $location[0]['arrival_from']);
									$formattedArrivalFrom = $arrivalFrom ? $arrivalFrom->format('Y.m.d') : '';

									$arrivalTo = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', $location[0]['arrival_to']);
									$formattedArrivalTo = $arrivalTo ? $arrivalTo->format('Y.m.d') : '';
									?>

									<?php echo esc_html($formattedArrivalFrom) . ' - ' . esc_html($formattedArrivalTo); ?>
								</div>
							</div>
						</div>
					<?php
					}
				}
				?>
				<div class="shipping_info flex flex-column">
					<div class="flex flex-row justify-start align-center">
						<img
								class="mr-1"
								title="<?php echo esc_attr($item['shipping_type']['title']); ?>"
								src="https://spotos.eu/wp-content/themes/spotos/assets/images/icons/load.svg"
						>
						<div class="vehicle_type">
							<?php echo esc_html($item['shipping_type']['title']) . ', ' . esc_html($item['weight']) . ' t'; ?>

						</div>
					</div>
					<div class="flex flex-row justify-start align-center">
						<img
								class="mr-1"
								title="<?php echo esc_attr($item['vehicle_types'][0]['title']); ?>"
								src="https://spotos.eu/wp-content/themes/spotos/assets/images/icons/truck.svg"
						>
						<div class="vehicle_type">
							<?php echo esc_html($item['vehicle_types'][0]['title']); ?>
						</div>
					</div>
				</div>
				<div class="flex flex-row justify-start align-center">
					<img
							class="mr-1"
							title="<?php echo esc_attr__('Price', 'ev-freight'); ?>"
							src="https://spotos.eu/wp-content/themes/spotos/assets/images/icons/rate.svg"
					>
					<div class="item_price">
						<?php echo esc_html(number_format($item['price'] / 100, 2, ',', '.')); ?>
					</div>
				</div>
				<?php if(isset($item['status'])) { ?>
				<div class="cta">
					<?php
					$cta_text = '';
					$cta_href = false;
					$cta_class = 'btn green-btn';

					if ($item['status'] === 'available') {
						$cta_text = __('Book', 'ev-freight');
						$cta_href = 'https://id.spotos.eu/register?company_type=carrier';
					}

					if ($item['status'] === 'delivered') {
						$cta_text = __('Delivered', 'ev-freight');
						$cta_class .= ' disabled';
					}
					?>
					<a
							class="<?php echo esc_attr($cta_class); ?>"
							<?php if ($cta_href) { ?>
								target="_blank"
								href="<?php echo esc_url($cta_href); ?>"
							<?php } ?>
					>
						<?php echo esc_html($cta_text); ?>
					</a>
				</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</div>
