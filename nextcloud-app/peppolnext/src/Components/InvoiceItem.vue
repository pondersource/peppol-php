<template>
	<div class="item-body">
		<div class="row-number">{{rowNumber}}</div>
		<div class="title">
			<input
				@change="notifyDataChange"
				placeholder="Title"
				v-model="invoiceItem.title">
		</div>
		<div class="fee">
			<input
				@change="notifyDataChange"
				type="number"
				step="0.01"
				placeholder="Fee"
				v-model="invoiceItem.fee">
		</div>
		<div class="quantity">
			<input
				@change="notifyDataChange"
				type="number"
				placeholder="Quantity"
				v-model="invoiceItem.quantity">
		</div>
		<div class="total">
			<input
				type="number"
				step="0.001"
				@change="notifyDataChange"
				readonly="true"
				placeholder="Total"
				v-model="price">
		</div>
		<div class="description">
			<input
				@change="notifyDataChange"
				placeholder="description"
				v-model="invoiceItem.description">
		</div>
		<div>
			<button type="button" @click="notifyRowDeleted">-</button>
		</div>
	</div>
</template>

<script>
export default {
	name: 'InvoiceItem',
	props: {
		rowNumber: {
			type: Number,
			required: true
		},
	},
	data() {
		return {
			invoiceItem: {
				title: '',
				quantity: 0,
				description: '',
				totalPrice: 0,
				fee: 0
			}
		}
	},
	computed: {
		price: function() {
			return this.invoiceItem.quantity * this.invoiceItem.fee
		}
	},
	methods: {
		notifyDataChange: function() {
			this.invoiceItem.totalPrice = this.price
			this.$emit('row-data-changed', {
				index: this.rowNumber-1,
				data: this.invoiceItem
			})
		},
		notifyRowDeleted: function() {
			this.$emit('row-removed', this.rowNumber-1)
		}
	}
}
</script>

<style scoped>
	input {
		width: 80%;
		margin: 0 10% 0 10%;
	}
	.item-body{
		display: flex;
	}
	.row-number{
		text-align: center;
	}
	.title{
		flex: 0.2;
	}
	.fee{
		flex: 0.1;
	}
	.quantity{
		flex: 0.1;
	}
	.total{
		flex: 0.1;
	}
	.description{
		flex: 0.4;
	}
</style>
