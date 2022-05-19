<template>
	<div>
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
					</thead>
					<tbody>
					<tr v-for="(item, key) in items" :key="key">
						<td>{{ key+1 }}</td>
						<td>{{ item.orderId }}</td>
						<td>{{ item.sender }}</td>
						<td>{{ item.amount }}</td>
						<td>{{ item.fileName }}</td>
						<td>{{ item.note }}</td>
						<td>{{ item.creationTime }}</td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="col-2" />
		</div>
		<!--b-pagination
			v-model="currentPage"
			:total-rows="totalCount"
			:per-page="10"
			aria-controls="table"
			@change="pageChanged">
		</b-pagination-->
	</div>
</template>

<script>
export default {
	name: 'MessageList',
	beforeRouteUpdate(to, from, next) {
		this.category = to.params.category
		this.loadData(to.params.category, this)
		next()
	},
	data() {
		return {
			category: '',
			items: [],
			currentPage: 1,
			totalCount: 0,

		}
	},

	methods: {
		loadData: _.debounce((category, vm) => {
			fetch(`/index.php/apps/peppolnext/api/v1/message/${vm.currentPage}?type=${category}`)
				.then(res => {
					res.json().then(json => {
						vm.items = json.items
						vm.totalCount = json.totalCount
					})
				})
		}, 350),
	    pageChanged(page) {
			this.currentPage = page
			this.loadData(this.category, this)
		},
	},
}
</script>

<style scoped>

</style>
