<div id="app-navigation">
	<div class="app-navigation-new">
		<button type="button" class="icon-add">
			New invoice
		</button>
	</div>

<ul>
	<li>
		<a href="#">Invoices</a>
		<ul>
			<li class="app-navigation-entry">
				<a href="<?php p("invoice?income=true")?>">Received</a>
				<div class="app-navigation-entry-utils">
					<ul>
						<li class="app-navigation-entry-utils-counter highlighted"><span>100</span></li>
					</ul>

				</div>
			</li>
			<li class="app-navigation-entry">
				<a href="<?php p("invoice?income=false")?>">Sent</a>
				<div class="app-navigation-entry-utils">
					<ul>
						<li class="app-navigation-entry-utils-counter"><span>105</span></li>
					</ul>
				</div>
			</li>
		</ul>
	</li>
	<li>
		<a href="#">Network</a>
		<ul>
			<li class="app-navigation-entry">
				<a href="#">Received Requests</a>
				<div class="app-navigation-entry-utils">
					<ul>
						<li class="app-navigation-entry-utils-counter highlighted"><span>50</span></li>
					</ul>
				</div>
			</li>
			<li>
				<a href="#">Sent Requests</a>
				<div class="app-navigation-entry-utils">
					<ul >
						<li class="app-navigation-entry-utils-counter"><span>75</span></li>
					</ul>

				</div>
			</li>
			<li>
				<a href="#">My Network</a>
			</li>
			<li>
				<a href="#">Add Contact</a>
			</li>
		</ul>
	</li>
</ul>
</div>
