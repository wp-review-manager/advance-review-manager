import Admin from './Components/Admin.vue';
import Contact from './Components/Contact.vue';

export default [{
    path: '/',
    name: 'dashboard',
    component: Admin,
    meta: {
        active: 'dashboard'
    },
},
{
    path: '/settings',
    name: 'contact',
    component: Contact
},
{
    path: '/usage-guide',
    name: 'usage-guide',
    component: Contact
},
{
    path: '/support-&-debug',
    name: 'support-&-debug',
    component: Contact
}
];