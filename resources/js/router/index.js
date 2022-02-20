import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import About from '../pages/About';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import ProductDetail from '../pages/ProductDetail';
import Message from '../pages/Message';
import EditProduct from '../pages/EditProduct';
import AddProduct from '../pages/AddProduct';
import Setting from '../pages/Setting';
import EditSetting from '../pages/EditSetting';
import MyProduct from '../pages/MyProduct';


import Books from '../components/Books';
import AddBook from '../components/AddBook';
import EditBook from '../components/EditBook';


export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'about',
        path: '/about',
        component: About
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'productdetail',
        path: '/productdetail/:id',
        component: ProductDetail
    },
    {
        name: 'message',
        path: '/message/:id/:proid',
        component: Message
    },
    // {
    //     name: 'messages',
    //     path: '/messages',
    //     component: Message
    // },
    {
        name: 'editproduct',
        path: '/editproduct/:id',
        component: EditProduct
    },
    {
        name: 'addproduct',
        path: '/addproduct',
        component: AddProduct
    },
    {
        name: 'myproduct',
        path: '/myproduct',
        component: MyProduct
    },
    {
        name: 'setting',
        path: '/setting',
        component: Setting
    },
    {
        name: 'editsetting',
        path: '/editsetting',
        component: EditSetting
    },
    {
        name: 'books',
        path: '/books',
        component: Books
    },
    {
        name: 'addbook',
        path: '/books/add',
        component: AddBook
    },
    {
        name: 'editbook',
        path: '/books/edit/:id',
        component: EditBook
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
