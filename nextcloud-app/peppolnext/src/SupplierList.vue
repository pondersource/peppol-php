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
									<ActionButton icon="icon-checkmark" @click="setAsRead(item.fileName)">
										Mark as read
									</ActionButton>
									<ActionButton icon="icon-delete" @click="deleteFile(item.fileName)">
										Delete
									</ActionButton>
								</Actions>
							</td>
						</tr>
					</tbody>
					<td colspan="5"><Button @click="$router.push('/contact/new/supplier')" :wide="true">New Supplier</Button></td>
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
			axios.get('/index.php/apps/peppolnext/api/v1/contacts?relationship=2')
				.then(function(response) {
					vm.contacts = response.data
				})
				.catch()
		},
		setAsRead(filename) {
			const payload = { filename }
			const opt = this
			axios.put('/index.php/apps/peppolnext/api/v1/message', payload)
				.then(function(response) {
					opt.getAllNewInvoices(opt)
				})
				.catch(function(error) {})
		},
		deleteFile(filename) {
			const payload = { filename: filename }
			const opt = this
			axios.delete('/index.php/apps/peppolnext/api/v1/message', { data: payload })
				.then(function(response) {
					opt.getAllNewInvoices(opt)
				})
				.catch(function(error) { })
		},
	},
	watch: {
    // '$route.params.relationship': {
    //     handler(newValue) {
	// 		console.log('watcher watched: ' + newValue)
	// 		this.relationship = this.$route.params.relationship
    //         this.getAllContacts(this)
    //     },
    //     immediate: true,
    // }
}
}
</script>

<style scoped>

</style>
