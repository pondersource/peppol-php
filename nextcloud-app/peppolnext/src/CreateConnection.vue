<template>
	<div>
		<h1>New Connection Request</h1>
		<b-container fluid>
			<b-row class="my-1">
				<b-col class="sm-6">
					<div role="group">
						<label for="cmb-recipient">Recipient</label>
						<v-select id="cmb-recipient"
							@search="fetchPeppolUsers"
							:options="users"></v-select>
					</div>
				</b-col>
			</b-row>
			<b-row>
				<b-col class="my-1">
					<InvoiceItemList row-number="1"></InvoiceItemList>
				</b-col>
			</b-row>
		</b-container>
	</div>
</template>

<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import InvoiceItemList from './Components/InvoiceItemList'

export default {
	name: 'CreateConnection',
	components: {
		vSelect,
		InvoiceItemList
	},
	data() {
		return {
			users: []
		}
	},
	methods: {
		fetchPeppolUsers: function(search, loading, vm) {

		}
	}
}
</script>

<style scoped>

</style>
