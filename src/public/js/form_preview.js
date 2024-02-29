jQuery(document).ready(function ($) {
    // Your code here
    $('.wprm-review-form-submit').click(function(e){
        e.preventDefault();
        let form = $(this).closest('form');
        let formID = +form.attr('data-wprm-form-id');
        let formFieldData = form.serializeArray();
        let formComponent = form.serializeArray();
        let inputIndex = 0;
        form.find('[data-id]').each(function() {
            formComponent[inputIndex]['label'] = $(this).attr('data-id');
            // data[inputIndex]['placeholder'] = $(this).attr('placeholder') || '';
            inputIndex++;
        });
        let data = {
            formID: formID,
            formComponent: formComponent,
            formFieldData: formFieldData,
            action: 'wp_review_manager_ajax',
            nonce: window.WPRMPublic.wprm_nonce,
            route: 'create_review'
        }
        makeAjaxRequest(data, formID);
    })

    function makeAjaxRequest(data, formID) {
        const form = $(`[data-wprm-form-id="${formID}"]`);

        $.ajax({
            url: window.WPRMPublic.ajax_url, // This is a global JavaScript variable defined by WordPress itself.
            type: 'POST',
            data: data,
            success: function(response) {
                // Handle the response here

                $(form).find('input:not([type=submit])').val('');
                var notification = $('<div class="wprm-success-notification">Form submitted successfully</div>');

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
})