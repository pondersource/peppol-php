/**
 * @copyright Copyright (c) 2018 John Molakvoæ <skjnldsv@protonmail.com>
 *
 * @author John Molakvoæ <skjnldsv@protonmail.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */
import { generateFilePath } from '@nextcloud/router'
import Vue from 'vue'
import App from './App'
import ComposeMessage from './ComposeMessage'
import MessageList from './MessageList'
import ConnectionList from './ConnectionList'
import CustomerList from './CustomerList'
import SupplierList from './SupplierList'
import NewCustomer from './NewCustomer'
import NewSupplier from './NewSupplier'
import VueRouter from 'vue-router'

const routes = [
	{ path: '/message/new', component: ComposeMessage },
	{ path: '/message/list/:category', component: MessageList },
	{ path: '/connection/list', component: ConnectionList },
	{ path: '/contact/list/customers', component: CustomerList },
	{ path: '/contact/list/suppliers', component: SupplierList },
	{ path: '/contact/new/customer', component: NewCustomer },
	{ path: '/contact/new/supplier', component: NewSupplier },
]

const router = new VueRouter({
	routes, // short for `routes: routes`
})

Vue.use(VueRouter)

// eslint-disable-next-line
__webpack_public_path__ = generateFilePath(appName, '', 'js/')

Vue.mixin({ methods: { t, n } })

export default new Vue({
	router,
	el: '#content',
	render: h => h(App),
})
