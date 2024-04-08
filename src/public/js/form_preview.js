jQuery(document).ready(function ($) {

    let getReviewParamsData = {
        action: 'ad_review_manager_ajax',
        nonce: window.ADRMPublic.adrm_nonce,
        route: 'get_reviews'
    }

    $('.adrm-filter-by-star').change(function(e){
        let form = $(this).closest('.review-template_settings_wrapper');
        let formID = +form.attr('data-form-id');
        getReviewParamsData['formID'] = formID;
        getReviewParamsData['filter'] = $(this).val();
        makeAjaxRequestForReviewGet();
    });

    $('.adrm-sort-input').change(function(e){
        let form = $(this).closest('.review-template_settings_wrapper');
        let formID = +form.attr('data-form-id');
        getReviewParamsData['formID'] = formID;
        getReviewParamsData['sort'] = $(this).val();
        makeAjaxRequestForReviewGet();
    });
        
    $('.adrm-success-notification').click(function(e){
        e.preventDefault();
        let form = $(this).closest('form');
        let formID = +form.attr('data-adrm-form-id');
        // let formSerialized = form.serializeArray();
     
        let formFieldData = {
            ratings: []
        };

        let formComponent = form.serializeArray();
        let inputIndex = 0;
        form.find('[data-id]').each(function() {
            formComponent[inputIndex]['label'] = $(this).attr('data-id');
            // data[inputIndex]['placeholder'] = $(this).attr('placeholder') || '';
            inputIndex++;
        });
        formComponent.map((field) => {
            if(field.name.includes('rating')) {
                formFieldData['ratings'].push({
                    name: field.name,
                    value: field.value,
                    label: field.label
                });
            } else {
                formFieldData[field.name] = field.value;
            }
        })
        
        let data = {
            formID: formID,
            formComponent: formComponent,
            formFieldData: formFieldData,
            action: 'ad_review_manager_ajax',
            nonce: window.ADRMPublic.adrm_nonce,
            route: 'create_review'
        }
        makeAjaxRequestForReviewSubmit(data, formID);
    })

    function makeAjaxRequestForReviewSubmit(data, formID) {
        const form = $(`[data-adrm-form-id="${formID}"]`);

        $.ajax({
            url: window.ADRMPublic.ajax_url, // This is a global JavaScript variable defined by WordPress itself.
            type: 'POST',
            data: data,
            success: function(response) {
                // Handle the response here

                $(form).find('input:not([type=submit])').val('');
                var notification = $('<div class="adrm-success-notification">Form submitted successfully</div>');

                // Append the notification to the body
                $(form).append(notification);
    
                // Remove the notification after 3 seconds
                setTimeout(function() {
                    notification.remove();
                }, 3000);
    
                console.log(response);
            }
        });
    }

    function makeAjaxRequestForReviewGet () {
        $.ajax({
            url: window.ADRMPublic.ajax_url,
            type: 'GET',
            data: getReviewParamsData,
            success: function(response) {
                // Handle the response here
                if (response.success) {
                    domUpdateAfterReviewGet(response.data);
                }
            }
        });
    }

    // For food review template filter and sort functionality
    function domUpdateAfterReviewGet (response) {
        console.log(typeof response, response, response?.length);

        const reviewContainer = $('.adrm_food_review_template_wrapper');
        reviewContainer.empty();
        let created_at = '';
        let avatar = '';
        let average_rating = 0;
        if (response?.length) {
            response.map((review, key) => {
                created_at = review?.created_at;
                avatar = review?.avatar;
                average_rating = review?.average_rating;
            
                review = review?.meta?.formFieldData
                // console.log({review}, {avatar}, {average_rating})
                const reviewHTML = `
                <div class="adrm_food_review_template">
                    <div class="adrm-reviewer-info">
                        <div class="adrm-reviewer-avatar">
                            ${avatar}
                        </div>
                        <div class="adrm-reviewer-name">
                            <span>${review?.name}</span>
                        </div>
                        <div class="adrm-reviewer-email">
                            <span>${review?.email}</span>
                        </div>
                    </div>
                    <div class="adrm-review-body">
                        <div class="adrm-review-rating">
                            <div class="adrm-star-rating">
                            ${Array.from({ length: 5 }, (_, index) => {
                                return `<label name="rating" class="${index < average_rating ? 'active' : ''}" value="${index + 1}">★</label>`;
                            }).join('')}
                            </div>
                            <span class="adrm-review-date"> Reviewed ${created_at}</span>
                        </div>
                        <div class="adrm-review-content">
                            <p>${review?.message}</p>
                        </div>
                        <div class="review-categories">
                                ${review?.ratings.map((rating) => {
                                    return `<div class="adrm-star-rating">
                                        ${Array.from({ length: 5 }, (_, index) => {
                                            return `<label name="rating" class="${index < rating?.value ? 'active' : ''}" value="${index + 1}">★</label>`;
                                        }).join('')}

                                        <p>${rating?.label}</p>
                                    </div>`;
                                }).join('')}
                        </div>
                    </div>
                </div>
                `;
                reviewContainer.append(reviewHTML);
            })
        } else {
            reviewContainer.append('<div class="adrm_food_review_template"><p class="adrm-empty-review">No reviews found yet !</p></div>');
        }
        // Update the DOM with the response
    }
})