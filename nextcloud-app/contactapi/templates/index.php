<?php
script('contactapi', 'script');
style('contactapi', 'style');
?>

<div id="app">
	<div id="app-navigation">
		<?php print_unescaped($this->inc('navigation/index')); ?>
		<?php print_unescaped($this->inc('settings/index')); ?>
	</div>

	<div id="app-content">
		<div id="app-content-wrapper">
			<?php
				if(isset($_["page"]) && $_["page"])
				{
					print_unescaped($this->inc('content/'.$_['page']));
				}
				else {
					print_unescaped($this->inc('content/index'));
				}
			?>
		</div>
	</div>
</div>

