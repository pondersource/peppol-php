<template>
	<div>
		<div class="row">
			<div class="col-1" />
			<h1> {{ $route.params.category }} page</h1>
		</div>

		<div class="row">
			<div class="col-1" />
			<div class="col-9">
				<table id="table" class="data-list">
					<thead>
					<td>#</td>
					<td class="col-1" v-if="$route.params.category==='Outbox'">
						Customer
					</td>
					<td class="col-1" v-else>
						Supplier
					</td>
					<td class="col-1">
						Order Reference
					</td>
					<td class="col-1">
						Date
					</td>
					</thead>
					<tbody>
					<tr v-for="(item, key) in items" :key="key">
						<td>{{ key+1 }}</td>
						<td>{{ item.supplier }}</td>
						<td>{{ item.title }}</td>
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
		console.log('beforeRouteUpdate')
		this.category = to.params.category
		this.loadData(to.params.category, this)
		next()
	},
	mounted() {
		console.log('mounted')
		this.category = this.$route.params.category
		this.loadData(this.category, this)
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
		loadData(category, vm) {
			console.log('loadData: ' + `/index.php/apps/peppolnext/api/v1/message/${vm.currentPage}?type=${category}`)
			fetch(`/index.php/apps/peppolnext/api/v1/message/${vm.currentPage}?type=${category}`)
				.then(res => {
					res.json().then(json => {
						vm.items = json.items
						vm.totalCount = json.totalCount
					})
				})
		},
	    pageChanged(page) {
			this.currentPage = page
			this.loadData(this.category, this)
		},
	},
}
</script>

<style scoped>

</style>
