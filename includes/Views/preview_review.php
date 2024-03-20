<?php
use ADReviewManager\Services\ArrayHelper as Arr;
use ADReviewManager\Classes\Vite;
use ADReviewManager\Views\ReviewsTemplate;

?>
    <style>
        body {
            background-color: #f2f2f2;
        }
        .adrm-review-manager-wrapper {
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
            $formID = $form->ID;
        }
    ?>
        <div class="adrm-review-manager-wrapper <?php echo $preview_page == 'yes' ? 'adrm-preview-page' : '' ?>">
            <h3><?php echo $title ?></h3>
            <div>
                <form data-adrm-form-id="<?php echo $formID ?>">
                    <?php
                        foreach ($formFields as $formField) {
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
                    <input class="adrm-success-notification" type="submit" value="Submit">
                    <?php
                    } else if (Arr::get($formField, 'type') == 'rating') { ?>
                       <select placeholder="<?php echo $placeholder ?>" data-id="<?php echo $label ?>" type="select" id="<?php echo $name ?>" name="<?php echo $name ?>">
                            <option value="0" disabled>Rating</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    <?php
                }}
                    ?>
                </form>
            </div>
        </div>
        <?php 
        // (new ReviewsTemplate)->render($reviews);
        ?>
    </body>
</html>
