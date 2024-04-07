jQuery(document).ready(function ($) {
    $('.adrm-success-notification').click(function(e){
        e.preventDefault();
        let form = $(this).closest('form');
        let formID = +form.attr('data-adrm-form-id');
        // let formSerialized = form.serializeArray();
     
        let formFieldData = {
            ratings: []
        };

        // formSerialized.map((field) => {
        //     if(field.name.includes('rating')) {
        //         formFieldData['ratings'].push({
        //             name: field.label,
        //             value: field.value
        //         });
        //     } else {
        //         formFieldData[field.name] = field.value;
        //     }
        // })

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
        makeAjaxRequest(data, formID);
    })

    function makeAjaxRequest(data, formID) {
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
})