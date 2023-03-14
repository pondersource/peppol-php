<template>
	<div class="row">
		<div class="col-1" />
		<div class="col-6">
			<div class="row">
				<div class="col-5">
					<label for="txt-order-ref">Order Reference:</label>
					<input id="txt-order-ref" v-model="message.orderReference"> </input>
				</div>
			</div>
			<div class="row">
				<label for="txt-invoice-type">Invoice Type:</label>
			</div>
			<div class="row">
				<v-select id="txt-invoice-type"
					v-model="message.type"
					class="fullwidth"
					label="title"
					:options="invoiceTypes">
					<template slot="option" slot-scope="option">
						<div class="cmb-item-container">
							<div class="cmb-item-data">
								<div class="cmb-item-title">
									{{ option.title }}
								</div>
								<div class="cmb-item-hint">
									{{ option.hint }}
								</div>
							</div>
						</div>
					</template>
				</v-select>
			</div>
			<div class="row">
				<label for="txt-invoice-currency">Invoice Currency:</label>
			</div>
			<div class="row">
				<v-select id="txt-invoice-currency"
					v-model="message.currency"
					class="fullwidth"
					label="name"
					:options="invoiceCurrencies">
					<template slot="option" slot-scope="option">
						<div class="cmb-item-container">
							<div class="cmb-item-data">
								<div class="cmb-item-title">
									{{ option.name }}
								</div>
								<div class="cmb-item-hint">
									{{ option.hint }}
								</div>
							</div>
						</div>
					</template>
				</v-select>
			</div>
			<div class="row">
				<div class="col-5">Supplier</div>
			</div>
			<div class="row">
				<div class="col-1"></div>
				<div class="col-9">
					<div class="row">
						<label for="supplier-name">Name:</label>
						<input id="supplier-name" v-model="message.supplier.name"> </input>
					</div>
					<div class="row">
						<label for="supplier-email">Email:</label>
						<input id="supplier-email" v-model="message.supplier.email"> </input>
					</div>
					<div class="row">
						<div class="col-5">Address</div>
					</div>
					<div class="row">
						<div class="col-1"></div>
						<div class="col-9">
							<div class="row">
								<label for="supplier-address-line1">Line1:</label>
								<input id="supplier-address-line1" v-model="message.supplier.address.line1"> </input>
							</div>
							<div class="row">
								<label for="supplier-address-line2">Line2:</label>
								<input id="supplier-address-line2" v-model="message.supplier.address.line2"> </input>
							</div>
							<div class="row">
								<label for="supplier-address-city">City:</label>
								<input id="supplier-address-city" v-model="message.supplier.address.city"> </input>
							</div>
							<div class="row">
								<label for="supplier-address-postcode">PostCode:</label>
								<input id="supplier-address-postcode" v-model="message.supplier.address.post_code"> </input>
							</div>
							<div class="row">
								<label for="supplier-address-state">State:</label>
								<input id="supplier-address-state" v-model="message.supplier.address.state"> </input>
							</div>
							<div class="row">
								<label for="supplier-address-country">Country:</label>
								<v-select id="supplier-address-country"
									v-model="message.supplier.address.country"
									class="fullwidth"
									label="name"
									:options="countries">
									<template slot="option" slot-scope="option">
										<div class="cmb-item-container">
											<div class="cmb-item-data">
												<div class="cmb-item-title">
													{{ option.name }}
												</div>
											</div>
										</div>
									</template>
								</v-select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-8">
					<label for="cmb-recipient">Recipient</label>
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
			</div>
			<div class="row">
				<div class="col-5">Customer</div>
			</div>
			<div class="row">
				<div class="col-1"></div>
				<div class="col-9">
					<div class="row">
						<label for="customer-name">Name:</label>
						<input id="customer-name" v-model="message.customer.name"> </input>
					</div>
					<div class="row">
						<label for="customer-email">Email:</label>
						<input id="customer-email" v-model="message.customer.email"> </input>
					</div>
					<div class="row">
						<div class="col-5">Address</div>
					</div>
					<div class="row">
						<div class="col-1"></div>
						<div class="col-9">
							<div class="row">
								<label for="customer-address-line1">Line1:</label>
								<input id="customer-address-line1" v-model="message.customer.address.line1"> </input>
							</div>
							<div class="row">
								<label for="customer-address-line2">Line2:</label>
								<input id="customer-address-line2" v-model="message.customer.address.line2"> </input>
							</div>
							<div class="row">
								<label for="customer-address-city">City:</label>
								<input id="customer-address-city" v-model="message.customer.address.city"> </input>
							</div>
							<div class="row">
								<label for="customer-address-postcode">PostCode:</label>
								<input id="customer-address-postcode" v-model="message.customer.address.post_code"> </input>
							</div>
							<div class="row">
								<label for="customer-address-state">State:</label>
								<input id="customer-address-state" v-model="message.customer.address.state"> </input>
							</div>
							<div class="row">
								<label for="customer-address-country">Country:</label>
								<v-select id="customer-address-country"
									v-model="message.customer.address.country"
									class="fullwidth"
									label="name"
									:options="countries">
									<template slot="option" slot-scope="option">
										<div class="cmb-item-container">
											<div class="cmb-item-data">
												<div class="cmb-item-title">
													{{ option.name }}
												</div>
											</div>
										</div>
									</template>
								</v-select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-5">
					<label for="txt-vat">VAT amount:</label>
					<input id="txt-vat" v-model="message.vat"> </input>
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
			invoiceTypes: [
				{id:71,title:"Request for payment",hint:"Document/message issued by a creditor to a debtor to request payment of one or more invoices past due."},
				{id:80,title:"Debit note related to goods or services",hint:"Debit information related to a transaction for goods or services to the relevant party."},
				{id:82,title:"Metered services invoice",hint:"Document/message claiming payment for the supply of metered services (e.g., gas, electricity, etc.) supplied to a fixed meter whose consumption is measured over a period of time."},
				{id:84,title:"Debit note related to financial adjustments",hint:"Document/message for providing debit information related to financial adjustments to the relevant party."},
				{id:102,title:"Tax notification",hint:"Used to specify that the message is a tax notification."},
				{id:218,title:"Final payment request based on completion of work",hint:"The final payment request of a series of payment requests submitted upon completion of all the work."},
				{id:219,title:"Payment request for completed units",hint:"A request for payment for completed units."},
				{id:331,title:"Commercial invoice which includes a packing list",hint:"Commercial transaction (invoice) will include a packing list."},
				{id:380,title:"Commercial invoice",hint:"(1334) Document/message claiming payment for goods or services supplied under conditions agreed between seller and buyer."},
				{id:382,title:"Commission note",hint:"Document/message in which a seller specifies the amount of commission, the percentage of the invoice amount, or some other basis for the calculation of the commission to which a sales agent is entitled."},
				{id:383,title:"Debit note",hint:"Document/message for providing debit information to the relevant party."},
				{id:386,title:"Prepayment invoice",hint:"An invoice to pay amounts for goods and services in advance; these amounts will be subtracted from the final invoice."},
				{id:388,title:"Tax invoice",hint:"An invoice for tax purposes."},
				{id:393,title:"Factored invoice",hint:"Invoice assigned to a third party for collection."},
				{id:395,title:"Consignment invoice",hint:"Commercial invoice that covers a transaction other than one involving a sale."},
				{id:553,title:"Forwarder's invoice discrepancy report",hint:"Document/message reporting invoice discrepancies indentified by the forwarder."},
				{id:575,title:"Insurer's invoice",hint:"Document/message issued by an insurer specifying the cost of an insurance which has been effected and claiming payment therefore."},
				{id:623,title:"Forwarder's invoice",hint:"Invoice issued by a freight forwarder specifying services rendered and costs incurred and claiming payment therefore."},
				{id:780,title:"Freight invoice",hint:"Document/message issued by a transport operation specifying freight costs and charges incurred for a transport operation and stating conditions of payment."},
				{id:817,title:"Claim notification",hint:"Document notifying a claim."},
				{id:870,title:"Consular invoice",hint:"Document/message to be prepared by an exporter in his country and presented to a diplomatic representation of the importing country for endorsement and subsequently to be presented by the importer in connection with the import of the goods described therein."},
				{id:875,title:"Partial construction invoice",hint:"Partial invoice in the context of a specific construction project."},
				{id:876,title:"Partial final construction invoice",hint:"Invoice concluding all previous partial construction invoices of a completed partial rendered service in the context of a specific construction project."},{id:877,title:"Final construction invoice",hint:"Invoice concluding all previous partial invoices and partial final construction invoices in the context of a specific construction project."}
			],
			invoiceCurrencies: [
				{name:"AED",hint:"UAE Dirham"},{name:"AFN",hint:"Afghani"},{name:"ALL",hint:"Lek"},
				{name:"AMD",hint:"Armenian Dram"},{name:"ANG",hint:"Netherlands Antillean Guilder"},{name:"AOA",hint:"Kwanza"},
				{name:"ARS",hint:"Argentine Peso"},{name:"AUD",hint:"Australian Dollar"},{name:"AWG",hint:"Aruban Florin"},
				{name:"AZN",hint:"Azerbaijan Manat"},{name:"BAM",hint:"Convertible Mark"},{name:"BBD",hint:"Barbados Dollar"},
				{name:"BDT",hint:"Taka"},{name:"BGN",hint:"Bulgarian Lev"},{name:"BHD",hint:"Bahraini Dinar"},
				{name:"BIF",hint:"Burundi Franc"},{name:"BMD",hint:"Bermudian Dollar"},{name:"BND",hint:"Brunei Dollar"},
				{name:"BOB",hint:"Boliviano"},{name:"BOV",hint:"Mvdol"},{name:"BRL",hint:"Brazilian Real"},
				{name:"BSD",hint:"Bahamian Dollar"},{name:"BTN",hint:"Ngultrum"},{name:"BWP",hint:"Pula"},
				{name:"BYN",hint:"Belarusian Ruble"},{name:"BZD",hint:"Belize Dollar"},{name:"CAD",hint:"Canadian Dollar"},
				{name:"CDF",hint:"Congolese Franc"},{name:"CHE",hint:"WIR Euro"},{name:"CHF",hint:"Swiss Franc"},
				{name:"CHW",hint:"WIR Franc"},{name:"CLF",hint:"Unidad de Fomento"},{name:"CLP",hint:"Chilean Peso"},
				{name:"CNY",hint:"Yuan Renminbi"},{name:"COP",hint:"Colombian Peso"},{name:"COU",hint:"Unidad de Valor Real"},
				{name:"CRC",hint:"Costa Rican Colon"},{name:"CUC",hint:"Peso Convertible"},{name:"CUP",hint:"Cuban Peso"},
				{name:"CVE",hint:"Cabo Verde Escudo"},{name:"CZK",hint:"Czech Koruna"},{name:"DJF",hint:"Djibouti Franc"},
				{name:"DKK",hint:"Danish Krone"},{name:"DOP",hint:"Dominican Peso"},{name:"DZD",hint:"Algerian Dinar"},
				{name:"EGP",hint:"Egyptian Pound"},{name:"ERN",hint:"Nakfa"},{name:"ETB",hint:"Ethiopian Birr"},
				{name:"EUR",hint:"Euro"},{name:"FJD",hint:"Fiji Dollar"},{name:"FKP",hint:"Falkland Islands Pound"},
				{name:"GBP",hint:"Pound Sterling"},{name:"GEL",hint:"Lari"},{name:"GHS",hint:"Ghana Cedi"},
				{name:"GIP",hint:"Gibraltar Pound"},{name:"GMD",hint:"Dalasi"},{name:"GNF",hint:"Guinean Franc"},
				{name:"GTQ",hint:"Quetzal"},{name:"GYD",hint:"Guyana Dollar"},{name:"HKD",hint:"Hong Kong Dollar"},
				{name:"HNL",hint:"Lempira"},{name:"HRK",hint:"Kuna"},{name:"HTG",hint:"Gourde"},
				{name:"HUF",hint:"Forint"},{name:"IDR",hint:"Rupiah"},
				{name:"INR",hint:"Indian Rupee"},{name:"IQD",hint:"Iraqi Dinar"},{name:"IRR",hint:"Iranian Rial"},
				{name:"ISK",hint:"Iceland Krona"},{name:"JMD",hint:"Jamaican Dollar"},{name:"JOD",hint:"Jordanian Dinar"},
				{name:"JPY",hint:"Yen"},{name:"KES",hint:"Kenyan Shilling"},{name:"KGS",hint:"Som"},
				{name:"KHR",hint:"Riel"},{name:"KMF",hint:"Comorian Franc"},{name:"KPW",hint:"North Korean Won"},
				{name:"KRW",hint:"Won"},{name:"KWD",hint:"Kuwaiti Dinar"},{name:"KYD",hint:"Cayman Islands Dollar"},
				{name:"KZT",hint:"Tenge"},{name:"LAK",hint:"Lao Kip"},{name:"LBP",hint:"Lebanese Pound"},
				{name:"LKR",hint:"Sri Lanka Rupee"},{name:"LRD",hint:"Liberian Dollar"},{name:"LSL",hint:"Loti"},
				{name:"LYD",hint:"Libyan Dinar"},{name:"MAD",hint:"Moroccan Dirham"},{name:"MDL",hint:"Moldovan Leu"},
				{name:"MGA",hint:"Malagasy Ariary"},{name:"MKD",hint:"Denar"},{name:"MMK",hint:"Kyat"},
				{name:"MNT",hint:"Tugrik"},{name:"MOP",hint:"Pataca"},{name:"MRU",hint:"Ouguiya"},
				{name:"MUR",hint:"Mauritius Rupee"},{name:"MVR",hint:"Rufiyaa"},{name:"MWK",hint:"Malawi Kwacha"},
				{name:"MXN",hint:"Mexican Peso"},{name:"MXV",hint:"Mexican Unidad de Inversion (UDI)"},{name:"MYR",hint:"Malaysian Ringgit"},
				{name:"MZN",hint:"Mozambique Metical"},{name:"NAD",hint:"Namibia Dollar"},{name:"NGN",hint:"Naira"},
				{name:"NIO",hint:"Cordoba Oro"},{name:"NOK",hint:"Norwegian Krone"},{name:"NPR",hint:"Nepalese Rupee"},
				{name:"NZD",hint:"New Zealand Dollar"},{name:"OMR",hint:"Rial Omani"},{name:"PAB",hint:"Balboa"},
				{name:"PEN",hint:"Sol"},{name:"PGK",hint:"Kina"},{name:"PHP",hint:"Philippine Piso"},
				{name:"PKR",hint:"Pakistan Rupee"},{name:"PLN",hint:"Zloty"},{name:"PYG",hint:"Guarani"},
				{name:"QAR",hint:"Qatari Rial"},{name:"RON",hint:"Romanian Leu"},{name:"RSD",hint:"Serbian Dinar"},
				{name:"RUB",hint:"Russian Ruble"},{name:"RWF",hint:"Rwanda Franc"},{name:"SAR",hint:"Saudi Riyal"},
				{name:"SBD",hint:"Solomon Islands Dollar"},{name:"SCR",hint:"Seychelles Rupee"},{name:"SDG",hint:"Sudanese Pound"},
				{name:"SEK",hint:"Swedish Krona"},{name:"SGD",hint:"Singapore Dollar"},{name:"SHP",hint:"Saint Helena Pound"},
				{name:"SLL",hint:"Leone"},{name:"SOS",hint:"Somali Shilling"},{name:"SRD",hint:"Surinam Dollar"},
				{name:"SSP",hint:"South Sudanese Pound"},{name:"STN",hint:"Dobra"},{name:"SVC",hint:"El Salvador Colon"},
				{name:"SYP",hint:"Syrian Pound"},{name:"SZL",hint:"Lilangeni"},{name:"THB",hint:"Baht"},
				{name:"TJS",hint:"Somoni"},{name:"TMT",hint:"Turkmenistan New Manat"},{name:"TND",hint:"Tunisian Dinar"},
				{name:"TOP",hint:"Pa’anga"},{name:"TRY",hint:"Turkish Lira"},{name:"TTD",hint:"Trinidad and Tobago Dollar"},
				{name:"TWD",hint:"New Taiwan Dollar"},{name:"TZS",hint:"Tanzanian Shilling"},{name:"UAH",hint:"Hryvnia"},
				{name:"UGX",hint:"Uganda Shilling"},{name:"USD",hint:"US Dollar"},{name:"USN",hint:"US Dollar (Next day)"},
				{name:"UYI",hint:"Uruguay Peso en Unidades Indexadas (URUIURUI)"},{name:"UYU",hint:"Peso Uruguayo"},{name:"UZS",hint:"Uzbekistan Sum"},
				{name:"VEF",hint:"Bolívar"},{name:"VND",hint:"Dong"},{name:"VUV",hint:"Vatu"},
				{name:"WST",hint:"Tala"},{name:"XAF",hint:"CFA Franc BEAC"},{name:"XAG",hint:"Silver"},
				{name:"XAU",hint:"Gold"},{name:"XBA",hint:"Bond Markets Unit European Composite Unit (EURCO)"},{name:"XBB",hint:"Bond Markets Unit European Monetary Unit (E.M.U.-6)"},
				{name:"XBC",hint:"Bond Markets Unit European Unit of Account 9 (E.U.A.-9)"},{name:"XBD",hint:"Bond Markets Unit European Unit of Account 17 (E.U.A.-17)"},{name:"XCD",hint:"East Caribbean Dollar"},
				{name:"XDR",hint:"SDR (Special Drawing Right)"},{name:"XOF",hint:"CFA Franc BCEAO"},{name:"XPD",hint:"Palladium"},
				{name:"XPF",hint:"CFP Franc"},{name:"XPT",hint:"Platinum"},{name:"XSU",hint:"Sucre"},
				{name:"XTS",hint:"Codes specifically reserved for testing purposes"},{name:"XUA",hint:"ADB Unit of Account"},{name:"YER",hint:"Yemeni Rial"},
				{name:"ZAR",hint:"Rand"},{name:"ZMW",hint:"Zambian Kwacha"},{name:"ZWL",hint:"Zimbabwe Dollar"}
			],
			countries: [
				{code:"AD",name:"Andorra"},{code:"AE",name:"United Arab Emirates"},{code:"AF",name:"Afghanistan"},
				{code:"AG",name:"Antigua and Barbuda"},{code:"AI",name:"Anguilla"},{code:"AL",name:"Albania"},
				{code:"AM",name:"Armenia"},{code:"AO",name:"Angola"},{code:"AQ",name:"Antarctica"},
				{code:"AR",name:"Argentina"},{code:"AS",name:"American Samoa"},{code:"AT",name:"Austria"},
				{code:"AU",name:"Australia"},{code:"AW",name:"Aruba"},{code:"AX",name:"Åland Islands"},
				{code:"AZ",name:"Azerbaijan"},{code:"BA",name:"Bosnia and Herzegovina"},{code:"BB",name:"Barbados"},
				{code:"BD",name:"Bangladesh"},{code:"BE",name:"Belgium"},{code:"BF",name:"Burkina Faso"},
				{code:"BG",name:"Bulgaria"},{code:"BH",name:"Bahrain"},{code:"BI",name:"Burundi"},
				{code:"BJ",name:"Benin"},{code:"BL",name:"Saint Barthélemy"},{code:"BM",name:"Bermuda"},
				{code:"BN",name:"Brunei Darussalam"},{code:"BO",name:"Bolivia, Plurinational State of"},{code:"BQ",name:"Bonaire, Sint Eustatius and Saba"},
				{code:"BR",name:"Brazil"},{code:"BS",name:"Bahamas"},{code:"BT",name:"Bhutan"},
				{code:"BV",name:"Bouvet Island"},{code:"BW",name:"Botswana"},{code:"BY",name:"Belarus"},
				{code:"BZ",name:"Belize"},{code:"CA",name:"Canada"},{code:"CC",name:"Cocos (Keeling) Islands"},
				{code:"CD",name:"Congo, the Democratic Republic of the"},{code:"CF",name:"Central African Republic"},{code:"CG",name:"Congo"},
				{code:"CH",name:"Switzerland"},{code:"CI",name:"Côte d'Ivoire"},{code:"CK",name:"Cook Islands"},
				{code:"CL",name:"Chile"},{code:"CM",name:"Cameroon"},{code:"CN",name:"China"},
				{code:"CO",name:"Colombia"},{code:"CR",name:"Costa Rica"},{code:"CU",name:"Cuba"},
				{code:"CV",name:"Cabo Verde"},{code:"CW",name:"Curaçao"},{code:"CX",name:"Christmas Island"},
				{code:"CY",name:"Cyprus"},{code:"CZ",name:"Czechia"},{code:"DE",name:"Germany"},
				{code:"DJ",name:"Djibouti"},{code:"DK",name:"Denmark"},{code:"DM",name:"Dominica"},
				{code:"DO",name:"Dominican Republic"},{code:"DZ",name:"Algeria"},{code:"EC",name:"Ecuador"},
				{code:"EE",name:"Estonia"},{code:"EG",name:"Egypt"},{code:"EH",name:"Western Sahara"},
				{code:"ER",name:"Eritrea"},{code:"ES",name:"Spain"},{code:"ET",name:"Ethiopia"},
				{code:"FI",name:"Finland"},{code:"FJ",name:"Fiji"},{code:"FK",name:"Falkland Islands (Malvinas)"},
				{code:"FM",name:"Micronesia, Federated States of"},{code:"FO",name:"Faroe Islands"},{code:"FR",name:"France"},
				{code:"GA",name:"Gabon"},{code:"GB",name:"United Kingdom of Great Britain and Northern Ireland"},{code:"GD",name:"Grenada"},
				{code:"GE",name:"Georgia"},{code:"GF",name:"French Guiana"},{code:"GG",name:"Guernsey"},
				{code:"GH",name:"Ghana"},{code:"GI",name:"Gibraltar"},{code:"GL",name:"Greenland"},
				{code:"GM",name:"Gambia"},{code:"GN",name:"Guinea"},{code:"GP",name:"Guadeloupe"},
				{code:"GQ",name:"Equatorial Guinea"},{code:"GR",name:"Greece"},{code:"GS",name:"South Georgia and the South Sandwich Islands"},
				{code:"GT",name:"Guatemala"},{code:"GU",name:"Guam"},{code:"GW",name:"Guinea-Bissau"},
				{code:"GY",name:"Guyana"},{code:"HK",name:"Hong Kong"},{code:"HM",name:"Heard Island and McDonald Islands"},
				{code:"HN",name:"Honduras"},{code:"HR",name:"Croatia"},{code:"HT",name:"Haiti"},
				{code:"HU",name:"Hungary"},{code:"ID",name:"Indonesia"},{code:"IE",name:"Ireland"},
				{code:"IL",name:"Israel"},{code:"IM",name:"Isle of Man"},{code:"IN",name:"India"},
				{code:"IO",name:"British Indian Ocean Territory"},{code:"IQ",name:"Iraq"},{code:"IR",name:"Iran"},
				{code:"IS",name:"Iceland"},{code:"IT",name:"Italy"},{code:"JE",name:"Jersey"},
				{code:"JM",name:"Jamaica"},{code:"JO",name:"Jordan"},{code:"JP",name:"Japan"},
				{code:"KE",name:"Kenya"},{code:"KG",name:"Kyrgyzstan"},{code:"KH",name:"Cambodia"},
				{code:"KI",name:"Kiribati"},{code:"KM",name:"Comoros"},{code:"KN",name:"Saint Kitts and Nevis"},
				{code:"KP",name:"Korea, Democratic People's Republic of"},{code:"KR",name:"Korea, Republic of"},{code:"KW",name:"Kuwait"},
				{code:"KY",name:"Cayman Islands"},{code:"KZ",name:"Kazakhstan"},{code:"LA",name:"Lao People's Democratic Republic"},
				{code:"LB",name:"Lebanon"},{code:"LC",name:"Saint Lucia"},{code:"LI",name:"Liechtenstein"},
				{code:"LK",name:"Sri Lanka"},{code:"LR",name:"Liberia"},{code:"LS",name:"Lesotho"},
				{code:"LT",name:"Lithuania"},{code:"LU",name:"Luxembourg"},{code:"LV",name:"Latvia"},
				{code:"LY",name:"Libya"},{code:"MA",name:"Morocco"},{code:"MC",name:"Monaco"},
				{code:"MD",name:"Moldova, Republic of"},{code:"ME",name:"Montenegro"},{code:"MF",name:"Saint Martin (French part)"},
				{code:"MG",name:"Madagascar"},{code:"MH",name:"Marshall Islands"},{code:"MK",name:"Macedonia, the former Yugoslav Republic of"},
				{code:"ML",name:"Mali"},{code:"MM",name:"Myanmar"},{code:"MN",name:"Mongolia"},
				{code:"MO",name:"Macao"},{code:"MP",name:"Northern Mariana Islands"},{code:"MQ",name:"Martinique"},
				{code:"MR",name:"Mauritania"},{code:"MS",name:"Montserrat"},{code:"MT",name:"Malta"},
				{code:"MU",name:"Mauritius"},{code:"MV",name:"Maldives"},{code:"MW",name:"Malawi"},
				{code:"MX",name:"Mexico"},{code:"MY",name:"Malaysia"},{code:"MZ",name:"Mozambique"},
				{code:"NA",name:"Namibia"},{code:"NC",name:"New Caledonia"},{code:"NE",name:"Niger"},
				{code:"NF",name:"Norfolk Island"},{code:"NG",name:"Nigeria"},{code:"NI",name:"Nicaragua"},
				{code:"NL",name:"Netherlands"},{code:"NO",name:"Norway"},{code:"NP",name:"Nepal"},
				{code:"NR",name:"Nauru"},{code:"NU",name:"Niue"},{code:"NZ",name:"New Zealand"},
				{code:"OM",name:"Oman"},{code:"PA",name:"Panama"},{code:"PE",name:"Peru"},
				{code:"PF",name:"French Polynesia"},{code:"PG",name:"Papua New Guinea"},{code:"PH",name:"Philippines"},
				{code:"PK",name:"Pakistan"},{code:"PL",name:"Poland"},{code:"PM",name:"Saint Pierre and Miquelon"},
				{code:"PN",name:"Pitcairn"},{code:"PR",name:"Puerto Rico"},{code:"PS",name:"Palestine, State of"},
				{code:"PT",name:"Portugal"},{code:"PW",name:"Palau"},{code:"PY",name:"Paraguay"},
				{code:"QA",name:"Qatar"},{code:"RE",name:"Réunion"},{code:"RO",name:"Romania"},
				{code:"RS",name:"Serbia"},{code:"RU",name:"Russian Federation"},{code:"RW",name:"Rwanda"},
				{code:"SA",name:"Saudi Arabia"},{code:"SB",name:"Solomon Islands"},{code:"SC",name:"Seychelles"},
				{code:"SD",name:"Sudan"},{code:"SE",name:"Sweden"},{code:"SG",name:"Singapore"},
				{code:"SH",name:"Saint Helena, Ascension and Tristan da Cunha"},{code:"SI",name:"Slovenia"},{code:"SJ",name:"Svalbard and Jan Mayen"},
				{code:"SK",name:"Slovakia"},{code:"SL",name:"Sierra Leone"},{code:"SM",name:"San Marino"},
				{code:"SN",name:"Senegal"},{code:"SO",name:"Somalia"},{code:"SR",name:"Suriname"},
				{code:"SS",name:"South Sudan"},{code:"ST",name:"Sao Tome and Principe"},{code:"SV",name:"El Salvador"},
				{code:"SX",name:"Sint Maarten (Dutch part)"},{code:"SY",name:"Syrian Arab Republic"},{code:"SZ",name:"Swaziland"},
				{code:"TC",name:"Turks and Caicos Islands"},{code:"TD",name:"Chad"},{code:"TF",name:"French Southern Territories"},
				{code:"TG",name:"Togo"},{code:"TH",name:"Thailand"},{code:"TJ",name:"Tajikistan"},
				{code:"TK",name:"Tokelau"},{code:"TL",name:"Timor-Leste"},{code:"TM",name:"Turkmenistan"},
				{code:"TN",name:"Tunisia"},{code:"TO",name:"Tonga"},{code:"TR",name:"Turkey"},
				{code:"TT",name:"Trinidad and Tobago"},{code:"TV",name:"Tuvalu"},{code:"TW",name:"Taiwan, Province of China"},
				{code:"TZ",name:"Tanzania, United Republic of"},{code:"UA",name:"Ukraine"},{code:"UG",name:"Uganda"},
				{code:"UM",name:"United States Minor Outlying Islands"},{code:"US",name:"United States of America"},{code:"UY",name:"Uruguay"},
				{code:"UZ",name:"Uzbekistan"},{code:"VA",name:"Holy See"},{code:"VC",name:"Saint Vincent and the Grenadines"},
				{code:"VE",name:"Venezuela, Bolivarian Republic of"},{code:"VG",name:"Virgin Islands, British"},{code:"VI",name:"Virgin Islands, U.S."},
				{code:"VN",name:"Viet Nam"},{code:"VU",name:"Vanuatu"},{code:"WF",name:"Wallis and Futuna"},
				{code:"WS",name:"Samoa"},{code:"YE",name:"Yemen"},{code:"YT",name:"Mayotte"},
				{code:"ZA",name:"South Africa"},{code:"ZM",name:"Zambia"},{code:"ZW",name:"Zimbabwe"},
				{code:"1A",name:"Kosovo"},{code:"XI",name:"United Kingdom (Northern Ireland)"}
			],
			invoiceLines: {},
			options: [],
			mediaOptions: [
				{
					text: 'AS4 direct',
					value: 'AS4Direct',
				},
				{
					text: 'Peppol classic',
					value: 'PeppolClassic',
				},
				{
					text: 'Peppol Next',
					value: 'PeppolNext',
				},
			],
			message: {"orderReference":"20230118124231","type":{"id":71,"title":"Request for payment","hint":"Document/message issued by a creditor to a debtor to request payment of one or more invoices past due."},"currency":{"name":"USD","hint":"US Dollar"},"supplier":{"name":"marie","email":null,"address":{"_route":"peppolnext.setting_api.updateAddress","line1":"l1","line2":"l2","city":"Tehran","post_code":"1234","state":"Tehran","country":{"code":"IR","name":"Iran"}}},"customer":{"name":"Client Company Name","email":"","address":{"line1":"Lisk Center Utreht","line2":"De Burren","city":"Utreht","post_code":"3521","state":"","country":{"code":"NL","name":"Netherland"}}},"recipient":{"title":"Phase4","peppolEndpoint":"9915:phase4-test-sender","relationship":1,"isLocal":true,"uid":"62db3148-e57a-40de-8bfc-5c7e014f2557","endpoint":null,"certificate":null,"address":{"line1":"Lisk Center Utreht","line2":"De Burren","city":"Utreht","post_code":"3521","state":"","country":{"code":"NL","name":"Netherland"}}},"vat":"0","invoiceLines":{"items":[],"total":0}},
			// message: {
			// 	orderReference: '',
			// 	type: '',
			// 	currency: '',
			// 	supplier: {
			// 		name: '',
			// 		email: '',
			// 		address: {}
			// 	},
			// 	customer: {
			// 		name: '',
			// 		email: '',
			// 		address: {}
			// 	},
			// 	recipient: {},
			// 	vat: '',
			// 	invoiceLines: {},
			// },
		}
	},
	mounted: function() {
		this.message.orderReference = this.getRandomRefNumber()
		this.loadUserInfo(this)
	},
	computed: {
		recipient() {
			return this.message.recipient;
		}
	},
	watch: {
		recipient(newRecipient, oldRecipient) {
			this.customer.name = newRecipient.title
			this.customer.address = newRecipient.address
		}
	},
	methods: {
		submit() {
			const payload = this.message
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
		}, 100),
		loadUserInfo(vm) {
			fetch(`/index.php/apps/peppolnext/api/v1/setting/asSupplier`)
				.then(res => {
					res.json().then(function(json) {
						vm.message.supplier = json
					})
				})
		},
		getRandomRefNumber() {
			const now = new Date()
			return this.fn(now.getFullYear()) + 
					this.fn(now.getMonth() + 1) + 
					this.fn(now.getUTCDate()) +
					this.fn(now.getHours()) +
					this.fn(now.getMinutes()) +
					this.fn(now.getSeconds())
		},
		fn(n) {
			return n < 10 ? '0' + n : n
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
