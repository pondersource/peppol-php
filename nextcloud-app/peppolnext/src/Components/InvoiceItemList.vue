<template>
	<div>
		<div class="header">
			<div class="amount-header">Amount</div>
			<div class="vat-header">Vat</div>
			<div class="total-header">Total</div>

		</div>
		<div id="item-container" v-for="(obj, index) in rows" v-bind:key="index">
			<InvoiceItem
				v-bind:item="obj"
				v-bind:row-number="index+1"
				@row-data-changed="rowDataChanged"
				@row-removed="rowRemoved">
			</InvoiceItem>
		</div>
		<div class="footer">
			<div class="btn-plus">
				<button type="button" id="btn-add" @click="addItem">+</button>
			</div>
			<div class="gap">
			</div>

			<div class="total-cap">
				<p class="text-total">
					<b>Total amount:</b>
				</p>
			</div>
			<div class="total-amount">
				<p class="text-total"><b> {{ sumOfItems }} </b></p>
			</div>
		</div>

	</div>
</template>

<script>
import InvoiceItem from './InvoiceItem'
export default {
	name: 'InvoiceItemList',
	components: {
		InvoiceItem
	},
	data() {
		return {
			rows: [{
				amount: 0,
				vat: 0,
				totalPrice: 0,
			}],
			sumOfItems: 0,
		}
	},
	mounted: function() {
		this.$watch('rows', function() {
			this.sumOfItems = this.calculateSum()
		}, { deep: true })
	},
	methods: {
		addItem: function() {
			this.rows.push({
				amount: 0,
				vat: 0,
				totalPrice: 0,
			})
		},
		calculateSum: function() {
			return this.rows.reduce((n, item) => n + item.totalPrice, 0)
		},
		rowDataChanged: function(param) {
			this.sumOfItems = this.calculateSum()
			this.rows[param.index] = param.data
			this.emitResult()
		},
		rowRemoved: function(rowIndex) {
			if (this.rows.length > 1) {
				this.rows.splice(rowIndex, 1)
				this.sumOfItems = this.calculateSum()
				this.emitResult()
			}
		},
		emitResult: function() {
			const result = {
				items: this.rows,
				total: this.sumOfItems,
			}
			this.$emit('input', result)
		},
	},
}
</script>

<style scoped>
	.header{
		display: flex;
	}
	.amount-header {
		flex: 0.2;
		text-align: center;
	}
	.vat-header {
		flex: 0.1;
		text-align: center;
	}
	.total-header {
		flex: 0.1;
		text-align: center;
	}
	.footer{
		display: flex;
		margin-top: 1%;
	}
	.btn-plus{
		flex: 0.1;
	}
	.gap{
		flex: .4;
	}
	.total-cap{
		flex: .3;
		text-align: center;
		background-color: lightgray;
	}
	.total-amount{
		flex: .3;
		text-align: center;
	}

	.text-total{
		padding-top: 4% ;
	}
</style>
