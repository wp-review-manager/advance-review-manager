import routes from './routes';
import { createWebHashHistory, createRouter } from 'vue-router'
import WPPluginVueTailwind from './Bits/WPPluginVueTailwind';

const router = createRouter({
    history: createWebHashHistory(),
    routes
});


const framework = new WPPluginVueTailwind();

framework.app.config.globalProperties.appVars = window.WPPluginVueTailwindAdmin;

window.WPPluginVueTailwindApp = framework.app.use(router).mount('#WPRM_app');

router.afterEach((to, from) => {
    jQuery('.WPRM_menu_item').removeClass('active');
    let active = to.meta.active;
    if (active) {
        jQuery('.WPRM_main-menu-items').find('li[data-key=' + active + ']').addClass('active');
    }
});
