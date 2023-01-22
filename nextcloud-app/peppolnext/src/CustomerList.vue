<template>
	<div>
		<div class="row">
			<div class="col-1" />
			<div class="col-8">
				<table id="table" class="data-list">
					<thead>
						<td class="col-1">
							Name
						</td>
						<td class="col-1">
							Peppol identifier
						</td>
						<td class="col-1">
							AS4 Direct Endpoint
						</td>
						<td class="col-1">
							AS4 Direct Public Key
						</td>
						<td> Operations</td>
					</thead>
					<tbody>
						<tr v-for="(item, key) in contacts" :key="key">
							<td>{{ item.title }}</td>
							<td>{{ item.peppolEndpoint }}</td>
							<td>{{ item.endpoint }}</td>
							<td>{{ item.public_key }}</td>
							<td>
								<Actions>
									<ActionButton icon="icon-delete" @click="deleteContact(item.uid)">
										Delete
									</ActionButton>
								</Actions>
							</td>
						</tr>
					</tbody>
					<td colspan="5"><Button @click="$router.push('/contact/new/customer')" :wide="true">New Customer</Button></td>
				</table>
			</div>
			<div class="col-1" />
		</div>
	</div>
</template>

<script>
import axios from '@nextcloud/axios'
import Actions from '@nextcloud/vue/dist/Components/Actions'
import ActionButton from '@nextcloud/vue/dist/Components/ActionButton'
import Button from '@nextcloud/vue/dist/Components/Button'
export default {
	name: 'ContactList',
	components: {
		Actions,
		ActionButton,
		Button
	},
	beforeRouteUpdate(to, from, next) {
		// console.log('from: ' + JSON.stringify(from.params))
		// console.log('to: ' + JSON.stringify(to.params))
		// this.relationship = to.params.relationship
		//this.getAllContacts(this)
	},
	data: () => {
		return {
			contacts: []
		}
	},
	mounted() {
		this.getAllContacts(this)
	},
	methods: {
		getAllContacts(vm) {
			//console.log('relationship is ' + vm.relationship)
			//console.log('relationship is ' + vm.$route.path.split("/").reverse()[0])
			// axios.get('/index.php/apps/peppolnext/api/v1/contacts?relationship='+relationship)
			axios.get('/index.php/apps/peppolnext/api/v1/contacts?relationship=1')
				.then(function(response) {
					vm.contacts = response.data
				})
				.catch()
		},
		deleteContact(uid) {
			const opt = this
			axios.delete('/index.php/apps/peppolnext/api/v1/contact/'+uid+'?relationship=1')
				.then(function(response) {
					opt.getAllNewInvoices(opt)
				})
				.catch(function(error) { })
		}
	}
}
</script>

<style scoped>

</style>
