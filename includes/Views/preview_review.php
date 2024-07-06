<?php

    use ADReviewManager\Services\ArrayHelper as Arr;
    use ADReviewManager\Classes\Vite;
    use ADReviewManager\Views\ReviewsTemplate;

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

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
                        <h3><?php echo esc_html($title) ?></h3>
                        <div>
                            <form data-adrm-form-id="<?php echo esc_attr($formID) ?>">
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
                                    $required = Arr::get($formField, 'template_required', false) == true;
                                    if (Arr::get($formField, 'type') != 'submit') {
                                ?>
                                <label for="fname"><?php echo esc_html(Arr::get($formField, 'label')) ?></label>

                                <?php } if ($type == 'text' || $type == 'email' || $type == 'phone' || $type == 'number') { ?>
                                    <input required="<?php echo esc_html($required) ?>" data-id="<?php echo esc_html($label) ?>" type="<?php echo esc_html($type) ?>" name="<?php echo esc_attr($name) ?>" placeholder="<?php echo esc_attr($placeholder) ?>">
                                <?php
                                    } else if ($type == 'textarea') {
                                ?>
                                    <textarea required="<?php echo esc_attr($required) ?>" data-id="<?php echo esc_attr($label) ?>" id="subject" name="<?php echo esc_attr($name) ?>" placeholder="<?php echo esc_attr($placeholder) ?>"></textarea>
                                <?php
                                    } else if ($type == 'select') {
                                ?>
                                <select required="<?php echo esc_attr($required) ?>" placeholder="<?php echo esc_attr($placeholder) ?>" data-id="<?php echo esc_attr($label) ?>" type="select" id="country" name="<?php echo esc_attr($name) ?>">
                                    <option value="australia">Australia</option>
                                    <option value="canada">Canada</option>
                                    <option value="usa">USA</option>
                                </select>
                                <?php
                                } else if (Arr::get($formField, 'type') == 'submit') {
                                ?>
                                <input class="adrm-success-notification" type="submit" value="<?php echo esc_attr($formField['label']) ?>">
                                <?php
                                } else if (Arr::get($formField, 'type') == 'rating') { ?>
                                <select required="<?php echo esc_attr($required) ?>" placeholder="<?php echo esc_attr($placeholder) ?>" data-id="<?php echo esc_attr($label) ?>" type="select" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>">
                                    <option></option>
                                    <?php foreach($formField['options'] as $option) {?>
                                        <option value="<?php echo esc_attr($option['value']) ?>"><?php echo esc_html($option['label']);  ?></option>
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
                    (new ReviewsTemplate)->render($reviews, $form, $total_reviews, $pagination, $all_reviews);
                }
                ?>
            </div>
            <?php
        }