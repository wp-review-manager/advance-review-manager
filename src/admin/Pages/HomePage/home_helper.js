const tableColumns = [
    {
        label: "Name",
        field: "name",
        sortable: true
    },
    {
        label: "Category",
        field: "category",
        sortable: true
    },
    {
        label: "Price",
        field: "price",
        sortable: true
    },
    {
        label: "Brand",
        field: "brand",
        sortable: true
    },
    {
        label: "Shortcode",
        field: "shortcode",
        sortable: true
    },
    {
        label: "Actions",
        field: "actions"
    }
]
const tableData = [
    {
        name: "Apple MacBook Pro 17",
        category: "Silver",
        price: "$2999",
        brand: "Apple",
        shortcode: "[wp-review-manager id=1]",
        actions: {
            edit: true,
            delete: true
        }
    },
    {
        name: "Microsoft Surface Pro",
        category: "White",
        price: "$1999",
        brand: "Microsoft",
        shortcode: "[wp-review-manager id=2]",
        actions: {
            edit: true,
            delete: true
        }
    },
    {
        name: "Magic Mouse 2",
        category: "Black",
        price: "$99",
        brand: "Apple",
        shortcode: "[wp-review-manager id=3]",
        actions: {
            edit: true,
            delete: true
        }
    }
]

const formFields = [
    {
        label: 'Name',
        name: 'name',
        type: 'text',
        placeholder: 'Apple MacBook Pro 17',
    },
    {
        label: 'Email',
        name: 'email',
        type: 'email',
        placeholder: 'dasnites@gmail.com',
    },
    {
        label: 'Phone',
        name: 'phone',
        type: 'phone',
        placeholder: '01747102896',
    },
    {
        label: 'Message',
        name: 'message',
        type: 'textarea',
        placeholder: 'Your message',
    },
    {
        label: 'Rating',
        name: 'rating',
        type: 'rating',
    },
    {
        label: 'File',
        name: 'file',
        type: 'file',
        value: [
            {
                image_full: '',
                image_thumb: '',
                alt_text: '',
            }
        ],
    },
    {
        label: 'Radio',
        name: 'radio',
        type: 'radio',
        options: [
            {
                label: 'Option 1',
                value: 'option1',
            },
            {
                label: 'Option 2',
                value: 'option2',
            },
        ],
    },
    {
        label: 'Checkbox',
        name: 'checkbox',
        type: 'checkbox',
        options: [
            {
                label: 'Option 1',
                value: 'option1',
            },
            {
                label: 'Option 2',
                value: 'option2',
            },
        ],
    },
    {
        label: 'Select',
        name: 'select',
        type: 'select',
        options: [
            {
                label: 'Option 1',
                value: 'option1',
            },
            {
                label: 'Option 2',
                value: 'option2',
            },
        ],
    },
    {
        label: 'Date',
        name: 'date',
        type: 'date',
    },
    {
        label: 'Number',
        name: 'number',
        type: 'number',
    },
    {
        label: 'Hidden',
        name: 'hidden',
        type: 'hidden',
    },
    {
        label: 'Submit',
        name: 'submit',
        type: 'submit',
        single_component: true,
    }
]

const commonFormFields = [
    {
        label: 'Name',
        name: 'name',
        type: 'text',
        placeholder: 'Apple MacBook Pro 17',
    },
    {
        label: 'Email',
        name: 'email',
        type: 'email',
        placeholder: 'Enter user email',
    },
    {
        label: 'Message',
        name: 'message',
        type: 'textarea',
        placeholder: 'Your message',
    },
    {
        label: 'Rating',
        name: 'rating',
        type: 'rating',
    },
    {
        label: 'File',
        name: 'file',
        type: 'file',
        value: [
            {
                image_full: '',
                image_thumb: '',
                alt_text: '',
            }
        ],
    },
];

const formTemplate = {
    'blank_form': {
        id: 0,
        title: 'Blank Form',
        thumbnail: 'images/template_1.jpeg',
        formFields: [],

    },
    'hotel_review_form':{
        id: 1,
        title: 'Hotel Review Form',
        thumbnail: 'images/template_1.jpeg',
        formFields: [...commonFormFields, {
            label: 'Hotel Name',
            name: 'hotel_name',
            type: 'text',
            placeholder: 'Hotel Name',
        }],
    },
    'product_review_form': {
        id: 2,
        title: 'Product Review Form',
        thumbnail: 'images/template_1.jpeg',
        formFields: commonFormFields,
    }
}

export {
    tableColumns,
    tableData,
    formTemplate,
    formFields
}