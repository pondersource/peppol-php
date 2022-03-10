<template>
	<div>
		<h1> {{ $route.params.category }} page</h1>
		<div class="row">
			<div class="col-1" />
			<div class="col-8">
				<table id="table" class="data-list">
					<thead>
						<td>#</td>
						<td class="col-1">
							Order Reference
						</td>
						<td class="col-1">
							Sender
						</td>
						<td class="col-1">
							Amount
						</td>
						<td class="col-1">
							File
						</td>
						<td class="col-2">
							Note
						</td>
						<td class="col-1">
							Rec. Date
						</td>
						<td> Operations</td>
					</thead>
					<tbody>
						<tr v-for="(item, key) in messages" :key="key">
							<td>{{ key+1 }}</td>
							<td>{{ item.orderId }}</td>
							<td>{{ item.sender }}</td>
							<td>{{ item.amount }}</td>
							<td>{{ item.fileName }}</td>
							<td>{{ item.note }}</td>
							<td>{{ item.creationTime }}</td>
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
export default {
	name: 'ConnectionList',
	components: {
		Actions,
		ActionButton,
	},
	data: () => {
		return {
			messages: [],
		}
	},
	mounted() {
		this.getAllNewInvoices(this)
	},
	methods: {
		getAllNewInvoices(vm) {
			axios.get('/index.php/apps/peppolnext/api/v1/message/new/1')
				.then(function(response) {
					vm.messages = response.data
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
}
</script>

<style scoped>

</style>
