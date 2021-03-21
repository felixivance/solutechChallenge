
// Dashboard
import Dashboard from '../components/dashboardComponent';
import ProductComponent from '../components/productsComponent';


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

]
