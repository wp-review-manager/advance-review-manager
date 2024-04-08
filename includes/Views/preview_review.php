<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="Imagetoolbar" content="No" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.0/css/lightgallery.min.css" integrity="sha512-F2E+YYE1gkt0T5TVajAslgDfTEUQKtlu4ralVq78ViNxhKXQLrgQLLie8u1tVdG2vWnB3ute4hcdbiBtvJQh0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.0/css/lightgallery-bundle.min.css" integrity="sha512-nUqPe0+ak577sKSMThGcKJauRI7ENhKC2FQAOOmdyCYSrUh0GnwLsZNYqwilpMmplN+3nO3zso8CWUgu33BDag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title><?php esc_html_e('Preview Form', 'wp-advance-review-manager') ?></title>
    <?php
     wp_head();
    ?>

    <style>
        body {
            background-color: #f2f2f2;
        }
        .adrm-review-manager-preview{
            margin: 0 auto;
            padding: 70px;
            background-color: #fff;
        }
        .adrm-review-manager-wrapper {
            width: 100%;
        }
        input[type=phone],input[type=email], input[type=number], input[type=text], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        div {
            border-radius: 5px;
            padding: 20px;
        }
        .adrm-review-manager-preview .adrm_preview_footer {
            display: block;
            overflow: hidden;
            width: inherit;
            margin: 0 auto;
            background-color: #fff;
        }

    </style>
</head>
    <body>
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
                    (new ReviewsTemplate)->render($reviews, $form);
                }
                ?>
                <div class="adrm_preview_footer">
                    <p>You are seeing preview version of Advance review manager. This form is only accessible for Admin users. Other users
                        may not access this page. To use this for in a page please use the following shortcode: [wppayform
                        id='<?php echo intval($formID); ?>']</p>
                </div>
            </div>
            <?php
            wp_footer();
        }
        ?>
    </body>
</html>
