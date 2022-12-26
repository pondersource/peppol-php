<template>
	<div class="row">
		<div class="col-1" />
		<div class="col-6">
			<div class="row">
				<div class="col-10">
					<label for="txt-title">Name:</label>
					<input id="txt-title" v-model="contact.title"> </input>
				</div>
			</div>
			<div class="row">
				<div class="col-10">
					<label for="txt-id">Peppol Identifier</label>
					<input id="txt-id"
						v-model="contact.peppolEndpoint"
						type="text"> </input>
				</div>
			</div>
			<div class="row">
				<div class="col-10">
					<label for="txt-endpoint">AS4 Direct Endpoint</label>
					<input id="txt-endpoint"
						v-model="contact.endpoint"
						type="text"> </input>
				</div>
			</div>
			<div class="row">
				<div class="col-10">
					<label for="txt-certificate">AS4 Direct Certificate</label>
					<input id="txt-certificate"
						v-model="contact.certificate"
						type="text"> </input>
				</div>
			</div>
			<div class="row">
				<div class="col-10">
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
import axios from '@nextcloud/axios'

export default {
	name: 'NewSupplier',
	components: {
	},
	data: () => {
		return {
			contact: {
				title: '',
				peppolEndpoint: '',
				endpoint: '',
				certificate: '',
				relationship: 2
			},
		}
	},
	methods: {
		submit() {
			const payload = { body: this.contact }
			axios.post('/index.php/apps/peppolnext/api/v1/contact', payload)
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
