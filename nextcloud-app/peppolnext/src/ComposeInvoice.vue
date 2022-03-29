<template>
	<b-container fluid>
		<b-row  class="my-1">
			<b-col sm="6">
				<b-row role="group">
					<label for="cmb-recipient">Recipient</label>
					<b-row>
						<b-col class="my-10">
						<v-select class="fullwidth"
							id="cmb-recipient"
							label="title"
							v-model="message.recipient"
							@search="fetchOptions"
							:options="options">
							<template slot="option" slot-scope="option">
								<div class="cmb-item-container">
									<div class="cmb-item-data">
										<div class="cmb-item-title">{{option.title}}</div>
										<div class="cmb-item-hint">{{option.peppolId}}</div>
									</div>
								</div>
							</template>
						</v-select>
						</b-col>
						<b-col v-if="showAddButton" class="my-2">
							<button @click="addContact">+</button>
						</b-col>
					</b-row>
				</b-row>

				<div role="group">
					<label for="txt-subject">Subject</label>
					<b-form-input
						id="txt-subject"
						v-model="message.subject">
					</b-form-input>
				</div>

				<div role="group">
					<label for="txt-message">Message</label>
					<b-form-textarea
						id="txt-message"
						v-model="message.body"
						placeholder="type your message"
						rows="1"
						max-rows="6">
					</b-form-textarea>
				</div>

				<div class="items">
					<InvoiceItemList v-model="invoiceLines" row-number="1"></InvoiceItemList>
				</div>

				<div role="group">
					<label for="file">Choose a XML file</label>
					<b-form-file
						id="file"
						v-model="message.file"
						:state="Boolean(message.file)"
						placeholder="Choose a file or drop it here...">
					</b-form-file>
				</div>
				<b-row>
					<b-col sm="6">
						<b-form-select
							id="cmb-type"
							v-model="message.sendingMedia"
							:options="mediaOptions"
							size="sm"
							class="mt-3">
							<template #first>
								<b-form-select-option :value="null" disabled>Select sending media</b-form-select-option>
							</template>
						</b-form-select>
					</b-col>
				</b-row>
				<div role="group">
					<b-button variant="primary" @click="submit">Submit</b-button>
				</div>
			</b-col>
			<b-col sm="5"></b-col>
		</b-row>
	</b-container>
</template>

<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import axios from '@nextcloud/axios'
import InvoiceItemList from './Components/InvoiceItemList'

export default {
	name: 'ComposeInvoice',
	components: {
		vSelect,
		InvoiceItemList
	},
	methods: {
		submit() {
			const payload = { body: this.message }
			axios.post('/index.php/apps/peppolnext/api/v1/message', payload)
				.then(function(response) {

				}).catch(function(error) {

				})
		},
		fetchOptions(search, loading, vm) {
			if(search.length > 3)
				this.search(loading, search, this)
		},
		search: _.debounce((loading, search, vm) => {
			fetch('/index.php/apps/peppolnext/api/v1/contact?needle=${escape(search)}`)
				.then(res => {
					res.json().then(json => vm.options = json)
					loading(false)
				})
		}, 350),
		addContact: function(){
			console.log(this.message.recipient)
			axios.post('/index.php/apps/peppolnext/api/v1/contact', this.message.recipient)
				.then(function(response) {

				}).catch(function(error) {

			})
		}
	},
	data: () => {
		return {
			invoiceLines: {},
			options: [],
			mediaOptions: [
				{
					text: 'AS4 direct',
					value: 'AS4Direct'
				},
				{
					text: 'Peppol classic',
					value: 'PeppolClassic'
				}
			],
			typeOptions: [
				{
					text: 'Simple message',
					value: 'SimpleMessage'
				},
				{
					text: 'Invoice',
					value: 'Invoice'
				},
				{
					text: 'Purchase order',
					value: 'PurchaseOrder'
				}
			],
			message: {
				recipient: '',
				subject: '',
				body: '',
				amount: 0,
				file: null,
				messageType: null,
				sendingMedia: null
			}
		}
	},
	computed: {
		showAddButton : function(){
			return this.message.recipient !== null
				&& this.message.recipient !== ""
				&& !this.message.recipient.isLocal
		}
	}
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
