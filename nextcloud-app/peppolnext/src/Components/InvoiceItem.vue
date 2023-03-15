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
				placeholder="Price"
				v-model="invoiceItem.price">
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
				step="1"
				@change="notifyDataChange"
				placeholder="Tax %"
				v-model="invoiceItem.taxPercentage">
		</div>
		<div class="description">
			<v-select id="customer-address-country"
				class="input"
				@change="notifyDataChange"
				v-model="invoiceItem.vat_category"
				label="title"
				:options="vatCategories">
				<template slot="option" slot-scope="option">
					<div class="cmb-item-container">
						<div class="cmb-item-data">
							<div class="cmb-item-title">
								{{ option.title }}
							</div>
							<div class="cmb-item-hint">
								{{ option.description }}
							</div>
						</div>
					</div>
				</template>
			</v-select>
		</div>
		<div class="total">
			<input
				type="number"
				step="0.01"
				@change="notifyDataChange"
				readonly="true"
				placeholder="Total"
				v-model="totalPrice">
		</div>
		<div>
			<button type="button" @click="notifyRowDeleted">-</button>
		</div>
	</div>
</template>

<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
export default {
	name: 'InvoiceItem',
	components: {
		vSelect
	},
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
				taxPercentage: 0,
				vat_category: {},
				totalPrice: 0,
				price: 0
			},
			vatCategories: [
				{code:"AE",title:"Vat Reverse Charge",description:"Code specifying that the standard VAT rate is levied from the invoicee."},
				{code:"E",title:"Exempt from Tax",description:"Code specifying that taxes are not applicable."},
				{code:"S",title:"Standard rate",description:"Code specifying the standard rate."},
				{code:"Z",title:"Zero rated goods",description:"Code specifying that the goods are at a zero rate."},
				{code:"G",title:"Free export item, VAT not charged",description:"Code specifying that the item is free export and taxes are not charged."},
				{code:"O",title:"Services outside scope of tax",description:"Code specifying that taxes are not applicable to the services."},
				{code:"K",title:"VAT exempt for EEA intra-community supply of goods and services",description:"A tax category code indicating the item is VAT exempt due to an intra-community supply in the European Economic Area."},
				{code:"L",title:"Canary Islands general indirect tax",description:"Impuesto General Indirecto Canario (IGIC) is an indirect tax levied on goods and services supplied in the Canary Islands (Spain) by traders and professionals, as well as on import of goods."},
				{code:"M",title:"Tax for production, services and importation in Ceuta and Melilla",description:"Impuesto sobre la Producción, los Servicios y la Importación (IPSI) is an indirect municipal tax, levied on the production, processing and import of all kinds of movable tangible property, the supply of services and the transfer of immovable property located in the cities of Ceuta and Melilla."},
				{code:"B",title:"Transferred (VAT), In Italy",description:"VAT not to be paid to the issuer of the invoice but directly to relevant tax authority. This code is allowed in the EN 16931 for Italy only based on the Italian A-deviation."}
			]
		}
	},
	computed: {
		totalPrice: function() {
			return this.invoiceItem.quantity * this.invoiceItem.price
		}
	},
	methods: {
		notifyDataChange: function() {
			this.invoiceItem.totalPrice = this.totalPrice
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
		flex: 0.5;
	}

	.input {
		width: 95%;
		margin: 0 5% 0 0%;
	}
</style>
