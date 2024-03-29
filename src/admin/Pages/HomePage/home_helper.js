const tableColumns = [
    {
        label: "ID",
        field: "ID",
        sortable: true
    },
    {
        label: "Title",
        field: "post_title",
        sortable: true
    },
    {
        label: "Reviews",
        field: "reviews",
        sortable: true
    },
    {
        label: "Created At",
        field: "post_date",
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
        shortcode: "[advance-review-manager id=1]",
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
        shortcode: "[advance-review-manager id=2]",
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
        shortcode: "[advance-review-manager id=3]",
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
        required: true,
    },
    {
        label: 'Email',
        name: 'email',
        type: 'email',
        placeholder: 'dasnites@gmail.com',
        required: false,
    },
    {
        label: 'Phone',
        name: 'phone',
        type: 'phone',
        placeholder: '01747102896',
        required: false,
    },
    {
        label: 'Message',
        name: 'message',
        type: 'textarea',
        placeholder: 'Your message',
        required: true,
    },
    {
        label: 'Rating',
        name: 'rating',
        type: 'rating',
        required: true,
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
        required: false,
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
        required: false,
    },
    {
        label: 'Checkbox',
        name: 'checkbox',
        type: 'checkbox',
        required: false,
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
        required: false,
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
        required: false,
    },
    {
        label: 'Number',
        name: 'number',
        type: 'number',
        required: false,
    },
    {
        label: 'Hidden',
        name: 'hidden',
        type: 'hidden',
        required: false,
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
        template_required: true,
    },
    {
        label: 'Email',
        name: 'email',
        type: 'email',
        placeholder: 'Enter user email',
        template_required: false,
    }
];

const formTemplate = {
    'single_rating_form_template':{
        id: 1,
        title: 'Book Review Form Template',
        desc: 'This is a book review form template', 
        rating_type: 'single',
        thumbnail: 'images/template_1.jpeg',
        formFields: [...commonFormFields,  {
            label: 'Write a review about the book',
            name: 'message',
            type: 'textarea',
            placeholder: 'Your message',
            template_required: true,
        },
        {
            label: 'Provide a rating for the book',
            name: 'rating',
            type: 'rating',
            template_required: true,
        },
       {
        label: "Review Submission",
        name: "review_submission",
        type: "submit",
        template_required: true,
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