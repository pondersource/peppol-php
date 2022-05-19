<template>
	<div class="item-body">
		<div class="row-number">{{rowNumber}}</div>
		<div class="amount">
			<input
				@change="notifyDataChange"
				placeholder="Amount"
				v-model="invoiceItem.amount">
		</div>
		<div class="vat">
			<input
				@change="notifyDataChange"
				type="number"
				step="0.01"
				placeholder="Vat"
				v-model="invoiceItem.vat">
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
				amount: 0,
				vat: 0,
			}
		}
	},
	computed: {
		price: function() {
			return this.invoiceItem.amount + ((this.invoiceItem.vat/100) * this.invoiceItem.amount)
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
