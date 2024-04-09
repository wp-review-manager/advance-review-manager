
    <?php
    use ADReviewManager\Services\ArrayHelper as Arr;
    use ADReviewManager\Classes\Vite;
    use ADReviewManager\Views\ReviewsTemplate;

    ?>
    <?php
        if (isset($form) && !empty($form)) {
            $title = $form->post_title;
            $formFields = $form->form_fields;
            $formID = $form->ID;
            ?>
            <div class='adrm-review-manager-preview'>
                <?php
                if ($show_review_form == 'yes') {
                    ?>
                    <div class="adrm-review-manager-wrapper">
                        <h3><?php echo $title ?></h3>
                        <div>
                            <form data-adrm-form-id="<?php echo $formID ?>">
                                <?php
                                // dd($formFields);
                                    foreach ($formFields as $formField) {
                    
                                    if (Arr::get($formField, 'enabled', false) == "false") {
                                        continue;
                                    }
                                    $type = Arr::get($formField, 'type', '');
                                    $name = Arr::get($formField, 'name', '');
                                    $label = Arr::get($formField, 'label','');
                                    $placeholder = Arr::get($formField, 'placeholder', '');
                                    // dd($formField);
                                    if (Arr::get($formField, 'type') != 'submit') {
                                ?>
                                <label for="fname"><?php echo Arr::get($formField, 'label') ?></label>

                                <?php } if ($type == 'text' || $type == 'email' || $type == 'phone' || $type == 'number') { ?>
                                    <input data-id="<?php echo $label ?>" type="<?php echo $type ?>" name="<?php echo $name ?>" placeholder="<?php echo $placeholder ?>">
                                <?php
                                    } else if ($type == 'textarea') {
                                ?>
                                    <textarea data-id="<?php echo $label ?>" id="subject" name="<?php echo $name ?>" placeholder="<?php echo $placeholder ?>"></textarea>
                                <?php
                                    } else if ($type == 'select') {
                                ?>
                                <select placeholder="<?php echo $placeholder ?>" data-id="<?php echo $label ?>" type="select" id="country" name="<?php echo $name ?>">
                                    <option value="australia">Australia</option>
                                    <option value="canada">Canada</option>
                                    <option value="usa">USA</option>
                                </select>
                                <?php
                                } else if (Arr::get($formField, 'type') == 'submit') {
                                ?>
                                <input class="adrm-success-notification" type="submit" value="<?php echo $formField['label'] ?>">
                                <?php
                                } else if (Arr::get($formField, 'type') == 'rating') { ?>
                                <select placeholder="<?php echo $placeholder ?>" data-id="<?php echo $label ?>" type="select" id="<?php echo $name ?>" name="<?php echo $name ?>">
                                    <option></option>
                                    <?php foreach($formField['options'] as $option) {?>
                                        <option value="<?php echo $option['value'] ?>"><?php echo $option['label']  ?></option>
                                    <?php } ?>
                                </select>
                                <?php
                            }}
                                ?>
                            </form>
                        </div>
                    </div>
                    <?php
                }
                if ($show_review_template == 'yes') {
                    (new ReviewsTemplate)->render($reviews, $form, $total_reviews, $pagination);
                }
                ?>
            </div>
            <?php
        }