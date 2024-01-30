import routes from './routes';
import ElementPlus from 'element-plus'
import * as ElementPlusIconsVue from '@element-plus/icons-vue';
import 'element-plus/dist/index.css'
import { createWebHashHistory, createRouter } from 'vue-router'
import WPPluginVueTailwind from './Bits/WPPluginVueTailwind';

const router = createRouter({
    history: createWebHashHistory(),
    routes
});


const framework = new WPPluginVueTailwind();

framework.app.config.globalProperties.appVars = window.WPPluginVueTailwindAdmin;

Object.keys(ElementPlusIconsVue).forEach(key => {
    framework.app.component(key, ElementPlusIconsVue[key])
});
framework.app.use(router);
framework.app.use(ElementPlus);
window.WPPluginVueTailwindApp = framework.app.mount('#WPRM_app');

router.afterEach((to, from) => {
    jQuery('.WPRM_menu_item').removeClass('active');
    let active = to.meta.active;
    if (active) {
        jQuery('.WPRM_main-menu-items').find('li[data-key=' + active + ']').addClass('active');
    }
});
