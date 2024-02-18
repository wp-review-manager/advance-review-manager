<?php
use WPReviewManager\Services\ArrayHelper as Arr;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>WP Review Preview</title>
        <?php
            wp_meta();
        ?>
    </head>
    <style>
        body {
            background-color: #f2f2f2;
        }
        .wprm-review-manager-wrapper {
            margin: 0 auto;
            margin-top: 70px;
            width: 70%;
            padding: 70px;
            background-color: #fff;
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
    </style>
    <body>
    <?php
        if (isset($form) && !empty($form)) {
            $title = $form->post_title;
            $formFields = $form->form_fields;
            // dd($formFields);
        }
    ?>
        <div class="wprm-review-manager-wrapper <?php echo $preview_page == 'yes' ? 'wprm-preview-page' : '' ?>">
            <h3><?php echo $title ?></h3>
            <div>
                <form action="/action_page.php">
                    <?php
                        foreach ($formFields as $formField) {
                        $type = Arr::get($formField, 'type');
                        $name = Arr::get($formField, 'name');
                        $placeholder = Arr::get($formField, 'placeholder');
                        // dd($formField);
                    ?>

                    <label for="fname"><?php echo Arr::get($formField, 'label') ?></label>

                    <?php if ($type == 'text' || $type == 'email' || $type == 'phone' || $type == 'number') { ?>
                        <input type="<?php echo $type ?>" name="<?php echo $name ?>" placeholder="<?php echo $placeholder ?>">
                    <?php
                        } else if ($type == 'textarea') {
                    ?>
                        <textarea id="subject" name="subject" placeholder="Write something.."></textarea>
                    <?php
                        } else if ($type == 'select') {
                    ?>
                    <select id="country" name="country">
                        <option value="australia">Australia</option>
                        <option value="canada">Canada</option>
                        <option value="usa">USA</option>
                    </select>
                    <?php
                    } else if (Arr::get($formField, 'type') == 'submit') {
                    ?>
                    <input type="submit" value="Submit">
                    <?php
                    }}
                    ?>
                </form>
            </div>
        </div>
    </body>
</html>