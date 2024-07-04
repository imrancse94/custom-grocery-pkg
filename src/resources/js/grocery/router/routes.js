export default [
    {
        path: '/',
        redirect: {name:'pre-order'}
    },
    {
        path: "/pre-order",
        name: 'pre-order',
        component: () => import("../Pages/PreOrder.vue"),
        meta: {
            auth: false
        }
    },
    {
        path: '/auth',
        name: 'auth',
        redirect: {name: "auth.orders"},
        component: () => import('../layouts/AuthenticatedLayout.vue'),
        meta: {
            auth: true
        },
        children: [
            {
                path: 'orders',
                name: 'auth.orders',
                component: () => import('../Pages/Auth/Orders.vue')
            }
        ]

    },
    {
        path: "/login",
        name:'login',
        component: () => import('../Pages/Login.vue'),
        meta: {
            auth: false,
            disable_after_auth:true
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: '404',
        component: () =>
            import ('../Pages/NotFound.vue'),
        meta: {
            auth: false
        }
    },
]
