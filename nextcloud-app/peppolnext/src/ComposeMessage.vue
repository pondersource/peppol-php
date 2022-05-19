<template>
	<div class="row">
		<div class="col-1" />
		<div class="col-6">
			<div class="row">
				<div class="col-5">
					<label for="txt-order-ref">Order Reference:</label>
					<input id="txt-order-ref" v-model="message.orderReference"> </input>
				</div>
				<div class="col-5">
					<label for="txt-due-date">InvoiceDate:</label>
					<input id="txt-due-date" v-model="message.dueDate" type="date"> </input>
				</div>
			</div>
			<div class="row">
				<div class="col-8">
					<label for="cmb-recipient">Peppol ID or WebID</label>
					<v-select id="cmb-recipient"
						v-model="message.recipient"
						class="fullwidth"
						label="title"
						:options="options"
						@search="fetchOptions">
						<template slot="option" slot-scope="option">
							<div class="cmb-item-container">
								<div class="cmb-item-data">
									<div class="cmb-item-title">
										{{ option.title }}
									</div>
									<div class="cmb-item-hint">
										{{ option.peppolEndpoint }}
									</div>
								</div>
							</div>
						</template>
					</v-select>
				</div>
				<div class="col-2">
					<div v-if="showAddButton">
						<button @click="addContact">
							+
						</button>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-10">
					<label for="txt-subject">Subject</label>
					<input id="txt-subject"
						v-model="message.subject"
						type="text"> input>
				</div>
			</div>
			<div class="row">
				<div class="col-10">
					<div class="items">
						<InvoiceItemList v-model="message.invoiceLines" row-number="1" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-10">
					<label for="file">Upload Invoice</label>
					<input id="file"
						type="file"
						placeholder="Choose a file or drop it here..."
						@chane="setFile" />
				</div>
			</div>
			<div class="row">
				<div class="col-5">
					<select
						id="cmb-media-type"
						v-model="message.mediaType"
						size="sm"
						class="mt-3">
						<option value="" disabled>
							Select sending media
						</option>
						<option v-for="item in mediaOptions" :key="item.value" :value="item.value">
							{{ item.text }}
						</option>
					</select>
				</div>
				<div class="col-5">
					<button @click="submit">
						Submit
					</button>
				</div>
			</div>

		</div>
		<div class="col-3"></div>
	</div>
</template>

<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import axios from '@nextcloud/axios'
import InvoiceItemList from './Components/InvoiceItemList'

export default {
	name: 'ComposeMessage',
	components: {
		vSelect,
		InvoiceItemList,
	},
	data: () => {
		return {
			invoiceLines: {},
			options: [],
			mediaOptions: [
				{
					text: 'AS4',
					value: 'AS4',
				},
				{
					text: 'Peppol',
					value: 'Peppol',
				},
			],
			message: {
				orderReference: '',
				dueDate: null,
				recipient: '',
				subject: '',
				body: '',
				amount: 0,
				file: null,
				mediaType: '',
				invoiceLines: {},
			},
		}
	},
	computed: {
		showAddButton: function () {
			return this.message.recipient !== null
				&& this.message.recipient !== ''
				&& !this.message.recipient.isLocal
		},
	},
	methods: {
		setFile(event) {
			this.message.file = event.target.filesp[0]
		},
		submit() {
			const payload = { body: this.message }
			axios.post('/index.php/apps/peppolnext/api/v1/message', payload)
				.then(function(response) {

				}).catch(function(error) {})
		},
		fetchOptions(search, loading, vm) {
			if (search.length > 3) {
				this.search(loading, search, this)
			}
		},
		search: _.debounce((loading, search, vm) => {
			fetch(`/index.php/apps/peppolnext/api/v1/contact?needle=${escape(search)}`)
				.then(res => {
					res.json().then(function(json) {
						vm.options = json
					})
					loading(false)
				})
		}, 350),
		addContact: function() {
			axios.post('/index.php/apps/peppolnext/api/v1/contact', this.message.recipient)
				.then(function(response) {

				}).catch(function(error) {})
		},
	},
}
</script>

<style scoped>

	div.body{
		padding: 2% 5% 2% 5%;
		width: 40%;
	}
	.fullwidth{
		width: 100%;
	}
	.items{
		padding-top: 2%;
		text-align: center;
	}
	.cmb-item-container{
		display: flex;
	}
	.cmb-item-data{
		flex: 1;
	}
	.cmb-item-title{
		font-size: small ;
	}
	.cmb-item-hint{
		font-size: smaller ;
		color: darkgray;
	}

</style>
