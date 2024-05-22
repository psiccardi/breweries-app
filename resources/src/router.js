import { createRouter, createWebHistory } from "vue-router";
import { getUserAPI } from "../js/utilities/api";

/**
 * First level components
 */
// Index (main component)
import Index from './Index.vue'
import Backoffice from './pages/Backoffice.vue'
import Breweries from './pages/Breweries.vue'

// 404 page
import NotFound from './NotFound.vue';

/**
 * Index sub-components
 */
//Login page
import Login from './pages/Login.vue';

import { ref, defineEmits } from "vue";
import Utils from "./../js/utilities/utils.js";
import { useI18n } from "vue-i18n";
const routes = [
    {
        path: '/',
        component: Index,
        name: 'Index',
        children: [
            {
                path: 'login',
                component: Login,
                name: 'Login'
            },
            {
                path: 'breweries',
                component: Backoffice,
                name: 'Breweries',
                meta: {
                    protected: true
                },
                children: [
                    {
                        path: '',
                        component: Breweries,
                        name: 'Breweries',
                        meta: {
                            protected: true
                        }
                    },
                ]
            }

        ]
    },

    {
        path: "/:catchAll(.*)",
        component: NotFound,
        name: 'NotFound'
    }
    // {
    //     path: '/:pathMatch(.*)*',
    //     component: notFound
    // }
]

const router = createRouter({

    history: createWebHistory(),

    routes

})

const checkUser = async function (fn) {
    return new Promise(function (resolve, reject) {
        getUserAPI(
            {},
            (resp) => {
                Utils.response.handleError(resp);
                resolve(resp);
            },
            (err) => {
                console.log(err.stack);
                resolve(null)
            }
        );
    })
};

router.beforeEach(async (to, from, next) => {
    let user = null;
    try {
        user = await checkUser()
    } catch (e) {}
    if (!user && to?.meta?.protected) {
        next({name: 'Login'})
    } else {
        next()
    }
    // if (!to.meta) {
    //     return true;
    // }
    // if (to.meta.protected && user?.id) {
    //     return true;
    // }
    // return false;

})

export default router
