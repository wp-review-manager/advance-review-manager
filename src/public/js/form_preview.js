jQuery(document).ready(function ($) {

    let getReviewParamsData = {
        action: 'ad_review_manager_ajax',
        nonce: window.ADRMPublic.adrm_nonce,
        route: 'get_reviews'
    }
    const template_type = $('.review-template_settings_wrapper').attr('data-template-type');

    console.log('.....', {template_type})

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

    $('.adrm-page-number').click(function(e){
        $(this).addClass('active').siblings().removeClass('active');
        let form = $(this).closest('.review-template_settings_wrapper');

        let formID = +form.attr('data-form-id');
        let page = $(this).text();
        getReviewParamsData['formID'] = formID;
        getReviewParamsData['page'] = page;
        makeAjaxRequestForReviewGet();
    });

    $('.adrm-next-page, .adrm-prev-page').click(function(e){
        let form = $(this).closest('.review-template_settings_wrapper');
        let formID = +form.attr('data-form-id');
        let page = +$('.adrm-page-number.active').text();
        getReviewParamsData['formID'] = formID;
        let nextPage = $(this).hasClass('adrm-next-page') ? page + 1 : page - 1;
        getReviewParamsData['page'] = nextPage;
        
        // Remove the active class from the current page and add it to the next page
        $('.adrm-page-number.active').removeClass('active');
        $('.adrm-page-number').eq(nextPage - 1).addClass('active');
    
        makeAjaxRequestForReviewGet();
    });

        
    $('.adrm-success-notification').click(function(e){
        e.preventDefault();
        let form = $(this).closest('form');
        let formID = +form.attr('data-adrm-form-id');
        // let formSerialized = form.serializeArray();
        const validForm = formValidation(form, formID);

        if (validForm) {
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
        } else {
            var errorMessage = $('<div class="adrm-error-notification">Please fill required field !</div>');
            $(form).append(errorMessage);
            // Remove the notification after 3 seconds
            setTimeout(function() {
                errorMessage.remove();
            }, 3000);
        }
    })


    function formValidation(form, formID) {
        let validForm = true;
        let formComponent = form.serializeArray();
        formComponent.map((field) => {
            if(field.name.includes('rating')) {
                if (!field.value) {
                    validForm = false;
                    $(`[name="${field.name}"]`).addClass('error');
                } else {
                    $(`[name="${field.name}"]`).removeClass('error');
                }
            } else {
                if (!field.value) {
                    validForm = false;
                    $(`[name="${field.name}"]`).addClass('error');
                } else {
                    $(`[name="${field.name}"]`).removeClass('error');
                }
            }
        })
        return validForm;
    }

    function makeAjaxRequestForReviewSubmit(data, formID) {
        const form = $(`[data-adrm-form-id="${formID}"]`);

        $.ajax({
            url: window.ADRMPublic.ajax_url, // This is a global JavaScript variable defined by WordPress itself.
            type: 'POST',
            data: data,
            success: function(response) {
                // Handle the response here

                $(form).find('input:not([type=submit])').val('');
                var notification = $('<div class="adrm-success-notification">Review submitted successfully</div>');

                // Append the notification to the body
                $(form).append(notification);
    
                // Remove the notification after 3 seconds
                setTimeout(function() {
                    notification.remove();
                }, 3000);
                location.reload();
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
                    const reviewContainer = $('.adrm_food_review_template_wrapper, .adrm_product_review_temp');
                    domUpdateAfterReviewGet(response.data, reviewContainer);  
                }
            }
        });
    }

    // For food review template filter and sort functionality
    function domUpdateAfterReviewGet (response, reviewContainer) {
        reviewContainer.empty();
        let created_at = '';
        let avatar = '';
        let average_rating = 0;
        let reviews = response?.reviews || [];
        if (reviews?.length) {
            reviews.map((review, key) => {
                created_at = review?.created_at;
                avatar = review?.avatar;
                average_rating = review?.average_rating;
            
                review = review?.meta?.formFieldData

                // console.log({review}, {avatar}, {average_rating})
                if(template_type?.includes('hotel-review-form-template') || template_type?.includes('food-review-form-template')) {
                    renderDomForFoodAndHotel(reviewContainer, avatar, review, created_at, average_rating);
                } else if (template_type?.includes('product-review-form-template')) {
                    renderDomForProductTemp(reviewContainer, avatar, review, created_at, average_rating);
                }
            })
        } else {
            reviewContainer.append('<div class="adrm_food_review_template"><p class="adrm-empty-review">No reviews found yet !</p></div>');
        }
        // Update the DOM with the response
    }

    function renderDomForFoodAndHotel (reviewContainer, avatar, review, created_at, average_rating) {
        console.log('.....', {reviewContainer}, {avatar}, {review}, {created_at}, {average_rating})
        const reviewHTML = `
        <div class="adrm_food_review_template">
            <div class="adrm-reviewer-info">
                <div class="adrm-reviewer-avatar">
                    ${avatar}
                </div>
                <div class="adrm-reviewer-name">
                    <span>${review?.name || ''}</span>
                </div>
                <div class="adrm-reviewer-email">
                    <span>${review?.email || ''}</span>
                </div>
            </div>
            <div class="adrm-review-body">
                <div class="adrm-review-rating">
                    <div class="adrm-star-rating">
                    ${Array.from({ length: 5 }, (_, index) => {
                        return `<label name="rating" class="${index < average_rating ? 'active' : ''}" value="${index + 1}">★</label>`;
                    }).join('')}
                    </div>
                    <span class="adrm-review-date"> Reviewed ${extractDate(created_at)}</span>
                </div>
                <div class="adrm-review-content">
                    <p>${review?.message}</p>
                </div>
                <div class="review-categories">
                        ${review?.ratings?.map((rating) => {
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
    }

    function renderDomForProductTemp (reviewContainer, avatar, review, created_at, average_rating) {
        let reviewHTML = `
            <div class="adrm_review_temp_one adrm_product_review_temp">
                <div class="adrm_review_temp_one_avatar">
                    ${avatar}
                </div>
                <div class="adrm_review_temp_one_content">
                    <div class="adrm_review_temp_one_content_header">
                        <div class="left">
                            <p class="date adrm-heading">${review?.name || ''}</p>
                            <h3 class="adrm_review_temp_one_content_header_name adrm-heading">
                                ${review?.title || ''}
                            </h3>
                        </div>
                        <div class="adrm-review-rating">
                            <p> ${extractDate(created_at)}</p>
                            <div class="adrm-star-rating">
                            ${Array.from({ length: 5 }, (_, index) => {
                                return `<label name="rating" class="${index < average_rating ? 'active' : ''}" value="${index + 1}">★</label>`;
                            }).join('')}
                            </div>
                        </div>
                    </div>
                    <div class="adrm_review_temp_one_content_body">
                        <p class="review">${review?.message}</p>
                    </div>
                </div>
                <?php if (count($comments)): ?>
                <div class="adrm-review-reply-section"> 
                    <h4 style="font-size: 16px; color: #333">Replies</h4>
                    <?php foreach ($comments as $comment) { ?>
                        <div class="adrm-review-comment">
                            <div> 
                                <span style="font-size: 16px; color: #000"><?php echo esc_html(ucfirst($comment['name'])) ?></span>
                            </div>
                            <div class="adrm-review-comment-content">
                                <p><?php echo esc_html(Arr::get($comment, 'comment')); ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php endif; ?>
            </div>`;
        

        let replyHtml = `
            <div class="adrm-review-reply-section"> 
                <h4 style="font-size: 16px; color: #333">Replies</h4>
        `;
    
        comments.forEach(comment => {
            replyHtml += `
                <div class="adrm-review-comment">
                    <div> 
                        <span style="font-size: 16px; color: #000">${comment.name}</span>
                    </div>
                    <div class="adrm-review-comment-content">
                        <p>${comment.comment}</p>
                    </div>
                </div>
            `;
        });
    
        replyHtml += `</div>`;
    
        // Add replyHtml to the DOM
        const container = document.querySelector('.adrm_review_temp_one.adrm_product_review_temp');
        container.innerHTML += replyHtml;

   
        reviewContainer.append(reviewHTML);
    }

    function extractDate(dateString) {
        // Create a new Date object from the given string
        const date = new Date(dateString);
        
        // Extract the year, month, and day
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        
        // Format the date as YYYY-MM-DD
        const formattedDate = `${year}-${month}-${day}`;
        
        return formattedDate;
    }
})

// Testimonial slider
jQuery(document).ready(function ($) {
    $('.btn').click(function() {
        var current = $('.adrm-testimonial-container.active');
        var next = current.next('.adrm-testimonial-container');
        var prev = current.prev('.adrm-testimonial-container');
        var progress_dot = $('.progress-dot.active');
        if ($(this).attr('id') == 'btn-next') {
            if (next.length) {
                current.removeClass('active');
                progress_dot.removeClass('active');
                progress_dot.next().addClass('active');
                next.addClass('active');

            } else {
                current.removeClass('active');
                progress_dot.removeClass('active');
                $('.progress-dot').first().addClass('active');
                current.siblings().first().addClass('active');
            }
        } else {
            if (prev.length) {
                current.removeClass('active');
                progress_dot.removeClass('active');
                progress_dot.prev().addClass('active');
                prev.addClass('active');
            } else {
                current.removeClass('active');
                progress_dot.removeClass('active');
                $('.progress-dot').last().addClass('active');
                current.siblings().last().addClass('active');
            }
        }
    });
    jQuery(document).ready(function($) {
        $('.adrm-reply-btn').on('click', function() {
            $(this).closest('.adrm_food_review_template').find('.adrm-reply').toggle();
        });
    }); 

    jQuery(document).ready(function($) {
        $('.adrm-reply-btn').on('click', function() {
            $(this).closest('.adrm_review_product_temp').find('.adrm-reply').toggle();
        });
    }); 

    jQuery(document).ready(function($) {
        $('.adrm-reply-btn').on('click', function() {
            $(this).closest('.adrm_hotel_review_template').find('.adrm-reply').toggle();
        });
    }); 

    jQuery(document).ready(function($) {
        $('.adrm-reply-btn').on('click', function() {
            console.log('clicked');
            $(this).closest('.adrm_review_temp_book').find('.adrm-reply').toggle();
        });
    }); 

    jQuery(document).ready(function($) {
        $('.adrm-reply-form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            // make the button disabled
            $(this).find('button').attr('disabled', true);
            var formData = $(this).serialize(); // Serialize form data
    
            $.ajax({
                url: window.ADRMPublic.ajax_url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Handle the response here
                    location.reload();
                }
            });
        });
    });
})