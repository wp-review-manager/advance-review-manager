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

const formData = {
    name: 'gjgjgjhgjh',
    email: '',
    phone: '',
    message: '',
    rating: 0,
    file: [
        {
            image_full: '',
            image_thumb: '',
            alt_text: '',
        }
    ],
    radio: '',
    checkbox: [],
    select: '',
}
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

const commonFormData = {
    name: '',
    email: '',
    message: '',
    rating: 0,
    file: [
        {
            image_full: '',
            image_thumb: '',
            alt_text: '',
        }
    ],
    radio: '',
    checkbox: [],
}

const formTemplates = [
    {
        title: 'Hotel Review Form',
        thumbnail: 'https://via.placeholder.com/150',
        FormData: commonFormData,
        formFields: commonFormFields,
    },
    {
        title: 'Product Review Form',
        thumbnail: 'https://via.placeholder.com/150',
        FormData: commonFormData,
        formFields: commonFormFields,
    }
]

export {
    tableColumns,
    tableData,
    formTemplates
}
