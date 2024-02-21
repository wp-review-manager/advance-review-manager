jQuery(document).ready(function ($) {
    // Your code here
    $('.wprm-review-form-submit').click(function(e){
        e.preventDefault();
        let form = $(this).closest('form');
        let formID = +form.attr('data-wprm-form-id');
        let formData = form.serializeArray();

        let inputIndex = 0;
        form.find('[data-id]').each(function() {
            formData[inputIndex]['label'] = $(this).attr('data-id');
            // data[inputIndex]['placeholder'] = $(this).attr('placeholder') || '';
            inputIndex++;
        });
        let data = {
            formID: formID,
            formData: formData,
            action: 'wp_review_manager_ajax',
            nonce: window.WPRMPublic.wprm_nonce,
            route: 'create_review'
        }
        makeAjaxRequest(data, formID);
    })

    function makeAjaxRequest(data, formID) {
        $.ajax({
            url: window.WPRMPublic.ajax_url, // This is a global JavaScript variable defined by WordPress itself.
            type: 'POST',
            data: data,
            success: function(response) {
                // Handle the response here
                console.log(response);
            }
        });
    }
})