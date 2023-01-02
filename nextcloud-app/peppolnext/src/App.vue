<template>
	<div id="content">
		<AppNavigation>
			<AppNavigationItem icon="icon-add" title="Create New Invoice" to="/message/new" />
			<template #list>
				<!-- <AppNavigationItem title="Invoices" :allow-collapse="true" :open="true"> -->
					<template>
						<AppNavigationItem icon="icon-download" title="Bills" to="/message/list/Inbox">
							<template #counter>
								<CounterBubble v-if="notification.messages > 0" type="outlined">{{notification.messages}}</CounterBubble>
							</template>
						</AppNavigationItem>
						<AppNavigationItem icon="icon-public" title="Connection Requests" to="/connection/list">
							<template #counter>
								<CounterBubble v-if="notification.connection_requests > 0" type="outlined">{{notification.connection_requests}}</CounterBubble>
							</template>
						</AppNavigationItem>
						<AppNavigationItem icon="icon-upload" title="Invoices" to="/message/list/Outbox" />
						<AppNavigationItem icon="icon-group" title="Customers" to="/contact/list/customers" />
						<AppNavigationItem icon="icon-group" title="Suppliers" to="/contact/list/suppliers" />
						<AppNavigationItem icon="icon-delete" title="Trash" to="/message/list/Trash" />
					</template>
				<!-- </AppNavigationItem> -->
			</template>
			<template #footer>
				<AppNavigationSettings>
					<h4>Let's Peppol</h4>
					<div class="row">
						<div class="col-5">
							<input type="text" placeholder="Scheme" v-model="letspeppol.scheme" />
						</div>
						<div class="col-5">
							<input type="text" placeholder="Id" v-model="letspeppol.id" />
						</div>
					</div>
					<div class="row">
						<button id="newLetsPeppol" @click="newLetsPeppol">Get Let's Peppol ID</button>
					</div>
					<h4>AS4 Direct</h4>
					<div class="row">
						<div class="col-5">
							<input type="text" placeholder="Scheme" v-model="as4direct.scheme" />
						</div>
						<div class="col-5">
							<input type="text" placeholder="Id" v-model="as4direct.id" />
						</div>
					</div>
					<div class="row">
						<input type="text" placeholder="Endpoint" v-model="as4direct.endpoint" />
					</div>
					<div class="row">
						<input type="text" placeholder="Certificate" v-model="as4direct.certificate" />
					</div>
					<div class="row">
						<button id="newAS4Direct" @click="newAS4Direct">Generate AS4 direct identity</button>
					</div>
					<!-- <div class="row">
						<div class="col-5">
							<input type="text" placeholder="Fullname" v-model="setting.fullname" />
						</div>
						<div class="col-5">
							<input type="email" placeholder="Email" v-model="setting.email" />
						</div>
					</div>
					<div class="row">
						<div class="col-5">
							<input type="text" placeholder="Peppol scheme" v-model="setting.peppolScheme" />
						</div>
						<div class="col-5">
							<input type="text" placeholder="Peppol Id" v-model="setting.peppolId" />
						</div>
					</div>
					<div class="row">
						<div class="col-5">
							<input type="tel" placeholder="Phone no" v-model="setting.phoneNo" />
						</div>
						<div class="col-5">
							<input type="tel" placeholder="Fax no" v-model="setting.faxNo" />
						</div>
					</div>
					<div>
						<p>Address:</p>
						<div class="row">
							<div class="col-5">
								<input placeholder="Country (ISO)" v-model="setting.country" />
							</div>
							<div class="col-5">
								<input placeholder="City" v-model="setting.city" />
							</div>
						</div>
						<div class="row">
							<div class="col-10">
								<input placeholder="Street address" v-model="setting.street" />
							</div>
						</div>
						<div class="row">
							<div class="col-10">
								<input placeholder="Extended street address" v-model="setting.additionStreet" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<input placeholder="Postal zone" v-model="setting.postalZone" />
						</div>
						<div class="col-4">
							<input placeholder="Building no" v-model="setting.buildingNo" />
						</div>
					</div>
					<div class="row">
						<button id="submit" @click="updateSettings">Submit</button>
					</div>-->

				</AppNavigationSettings>
			</template>
		</AppNavigation>
		<AppContent>
			<router-view></router-view>
		</AppContent>
	</div>
</template>

<script>
import AppNavigation from '@nextcloud/vue/dist/Components/AppNavigation'
import AppNavigationItem from '@nextcloud/vue/dist/Components/AppNavigationItem'
import AppNavigationNew from '@nextcloud/vue/dist/Components/AppNavigationNew'
import AppContent from '@nextcloud/vue/dist/Components/AppContent'
import AppNavigationSettings from '@nextcloud/vue/dist/Components/AppNavigationSettings'
import axios from '@nextcloud/axios'
import CounterBubble from '@nextcloud/vue/dist/Components/CounterBubble'

export default {
	name: 'App',
	components: {
		AppNavigation,
		AppNavigationItem,
		AppNavigationNew,
		AppContent,
		AppNavigationSettings,
		CounterBubble,
	},
	mounted: function() {
		this.loadAllSettings(this)
		this.getNotifications(this)
	},
	data: () => {
		return {
			letspeppol: {

			},
			as4direct: {

			},
			notification: {
				messages: 0,
				connection_requests: 0
			}
		}
	},
	methods: {
		loadAllSettings(vm) {
			axios.get('/index.php/apps/peppolnext/api/v1/setting')
				.then(function(response) {
					vm.letspeppol = response.data.letspeppol
					vm.as4direct = response.data.as4direct
				})
				.catch(function(error) {})
		},
		newLetsPeppol:function() {
			let vm1 = this;
			const payload = { body: {} }
			axios.post('/index.php/apps/peppolnext/api/v1/letspeppol', payload)
				.then(function(response) {
					vm1.letspeppol = response.data
				}).catch(function(error) {})
		},
		newAS4Direct(vm) {
			let vm2 = this;
			const payload = { body: {} }
			axios.post('/index.php/apps/peppolnext/api/v1/as4direct', payload)
				.then(function(response) {
					vm2.as4direct = response.data
				}).catch(function(error) {})
		},
		updateSettings(vm) {
			const payload = { body: this.setting }
			axios.post('/index.php/apps/peppolnext/api/v1/setting', payload)
				.then(function(response) {}).catch(function(error) {})
		},
		getNotifications(vm) {
			axios.get('/index.php/apps/peppolnext/api/v1/message/notifications')
				.then(function(response) {
					vm.notification.messages = response.data.messages
					vm.notification.connection_requests = response.data.connection_requests
				})
				.catch(function(error) {})
		}
	}
}
</script>
<style scoped>
	p{
		font-weight: bolder;
	}
</style>
