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

const ratingOptions = [
    {
        label: '1 Star',
        value: 1,
    },
    {
        label: '2 Star',
        value: 2,
    },
    {
        label: '3 Star',
        value: 3,
    },
    {
        label: '4 Star',
        value: 4,
    },
    {
        label: '5 Star',
        value: 5,
    }
]

const commonFormFields = [
    {
        label: 'Name',
        name: 'name',
        type: 'text',
        placeholder: 'Apple MacBook Pro 17',
        template_required: true,
        enabled: true,
    },
    {
        label: 'Email',
        name: 'email',
        type: 'email',
        enabled: true,
        placeholder: 'Enter user email',
        template_required: false,
    }
];

const formTemplate = {
    'book_review_form':{
        id: 1,
        title: 'Book Review Form Template',
        desc: 'This is a book review form template', 
        rating_type: 'single',
        thumbnail: 'images/book_temp.jpeg',
        formFields: [...commonFormFields,  {
            label: 'Write a review about the book',
            name: 'message',
            type: 'textarea',
            placeholder: 'Your message',
            template_required: true,
            enabled: true,
        },
        {
            label: 'Provide a rating for the book',
            name: 'rating',
            type: 'rating',
            template_required: true,
            enabled: true,
            options: ratingOptions
        },
       {
        label: "Review Submission",
        name: "review_submission",
        type: "submit",
        enabled: true,
        template_required: true,
       }],
    },
    'product_review_form':{
        id: 1,
        title: 'Product Review Form Template',
        desc: 'This is a product review form template', 
        rating_type: 'single',
        thumbnail: 'images/product_temp.jpeg',
        formFields: [...commonFormFields,
            {
                label: 'Review Title',
                name: 'title',
                type: 'text',
                placeholder: 'Review title',
                template_required: true,
                enabled: true,
            }, 
            {
            label: 'Write a review about the product',
            name: 'message',
            type: 'textarea',
            placeholder: 'Your message',
            template_required: true,
            enabled: true,
        },
        {
            label: 'Rating',
            name: 'rating',
            type: 'rating',
            template_required: true,
            enabled: true,
            options: ratingOptions
        },
       {
        label: "Review Submission",
        name: "review_submission",
        type: "submit",
        enabled: true,
        template_required: true,
       }],
    },
    'food_review_form': {
        id: 2,
        title: 'Food Review Form Template',
        rating_type: 'multiple',
        thumbnail: 'images/food_temp.jpeg',
        formFields: [...commonFormFields,  {
            label: 'Write a review about the food',
            name: 'message',
            type: 'textarea',
            placeholder: 'Your message',
            template_required: true,
            enabled: true,
        },
        {
            label: 'Food',
            name: 'rating',
            type: 'rating',
            template_required: true,
            options: ratingOptions,
            enabled: true,
        },
        {
            label: 'Service',
            name: 'rating_1',
            type: 'rating',
            template_required: false,
            options: ratingOptions,
            enabled: true,
        },
        {
            label: 'Ambience',
            name: 'rating_2',
            type: 'rating',
            template_required: false,
            options: ratingOptions,
            enabled: true,
        },
        {
            label: 'Cleanliness',
            name: 'rating_2',
            type: 'rating',
            template_required: false,
            options: ratingOptions,
            enabled: true,
        },
       {
        label: "Review Submission",
        name: "review_submission",
        type: "submit",
        template_required: true,
        enabled: true,
       }],
    },
    'hotel_review_form': {
        id: 2,
        title: 'Hotel Review Form Template',
        rating_type: 'multiple',
        thumbnail: 'images/hotel_temp.jpeg',
        formFields: [...commonFormFields,  {
            label: 'Write a review about the hotel',
            name: 'message',
            type: 'textarea',
            placeholder: 'Your message',
            template_required: true,
            enabled: true,
        },
        {
            label: 'Staff',
            name: 'rating',
            type: 'rating',
            template_required: true,
            options: ratingOptions,
            enabled: true,
        },
        {
            label: 'Facilities',
            name: 'rating_1',
            type: 'rating',
            template_required: false,
            options: ratingOptions,
            enabled: true,
        },
        {
            label: 'Cleanliness',
            name: 'rating_2',
            type: 'rating',
            template_required: false,
            options: ratingOptions,
            enabled: true,
        },
        {
            label: 'Comfort',
            name: 'rating_2',
            type: 'rating',
            template_required: false,
            options: ratingOptions,
            enabled: true,
        },
        {
            label: 'WiFi',
            name: 'rating_3',
            type: 'rating',
            template_required: false,
            options: ratingOptions,
            enabled: true,
        },
       {
        label: "Review Submission",
        name: "review_submission",
        type: "submit",
        template_required: true,
        enabled: true,
       }],
    },
    'simple_slide_testimonial_template': {
        id: 2,
        title: 'Simple Slide Testimonial Template',
        rating_type: 'single',
        thumbnail: 'images/testimonial_temp.jpeg',
        formFields: [...commonFormFields,
        {
            label: 'Position',
            name: 'position',
            type: 'text',
            placeholder: 'Your message',
            template_required: true,
            enabled: true,
        },
        {
            label: 'Write a review about me',
            name: 'message',
            type: 'textarea',
            placeholder: 'Your message',
            template_required: false,
            enabled: true,
        },
        {
            label: 'Rating',
            name: 'rating',
            type: 'rating',
            template_required: true,
            options: ratingOptions,
            enabled: true,
        },
       {
        label: "Review Submission",
        name: "review_submission",
        type: "submit",
        template_required: true,
        enabled: true,
       }],
    }
}

export {
    tableColumns,
    tableData,
    formTemplate,
    formFields
}