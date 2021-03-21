
// Dashboard
import Dashboard from '../components/dashboardComponent';
import ProductComponent from '../components/productsComponent';
import SupplierComponent from '../components/supplierComponent';
import OrderComponent from '../components/ordersComponent';


export default [
    {
        path:'/admin',
        redirect:'/admin/dashboard'
    },

    {
        path: '/admin/dashboard',
        component: Dashboard,
        name: 'Dashboard',
    },
    {
        path: '/admin/products',
        component: ProductComponent,
        name: 'productComponent',
    },
    {
        path: '/admin/suppliers',
        component: SupplierComponent,
        name: 'SupplierComponent',
    },
    {
        path: '/admin/orders',
        component: OrderComponent,
        name: 'OrderComponent',
    },
]
