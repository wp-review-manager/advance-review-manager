import Admin from './Pages/HomePage/Admin.vue';
import Contact from './Pages/Contact.vue';
import EditorIndex from './Pages/Editor/Index.vue';
import FormEditor from './Pages/Editor/FormEditor.vue';

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
    path: '/user-guide',
    name: 'user-guide',
    component: Contact
},
{
    path: '/support-&-debug',
    name: 'support-&-debug',
    component: Contact
},
{
    path: '/form/edit/:id',
    name: 'editor-index',
    component: EditorIndex,
    children: [{
        path: '',
        name: 'edit-form',
        component: FormEditor
    },
    {
        path: 'settings',
        name: 'edit-form-settings',
        component: FormEditor
    }
    ]
}
];