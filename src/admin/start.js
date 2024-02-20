import routes from './routes';
import 'element-plus/dist/index.css'
// import * as ElementPlusIconsVue from '@element-plus/icons-vue'
import { createWebHashHistory, createRouter } from 'vue-router'
import Framework from './Bits/Framework';

const router = createRouter({
    history: createWebHashHistory(),
    routes
});


const framework = new Framework();

framework.app.config.globalProperties.appVars = window.WPRMAdmin;

// Object.keys(ElementPlusIconsVue).forEach(key => {
//     framework.app.component(key, ElementPlusIconsVue[key])
// });
framework.app.use(router);
// framework.app.use(ElementPlus);
window.WPPluginVueTailwindApp = framework.app.mount('#WPRM_app');

router.afterEach((to, from) => {
    jQuery('.WPRM_menu_item').removeClass('active');
    let active = to.meta.active;
    if (active) {
        jQuery('.WPRM_main-menu-items').find('li[data-key=' + active + ']').addClass('active');
    }
});
