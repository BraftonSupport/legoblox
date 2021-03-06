<?php

return array(
    '5a4e43a686bcf' => array(
        'key' => '5a4e43a686bcf',
        'name' => 'slideshow',
        'label' => __( 'Slideshow', 'braftonium' ),
        'display' => 'block',
        'sub_fields' => array(
            array(
                'key' => 'field_5a4d572786bd0',
                'label' => __( 'Title', 'braftonium' ),
                'name' => 'title',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5a4d47a385bd1',
                'label' => __( 'Show', 'braftonium' ),
                'name' => 'show_text',
                'type' => 'checkbox',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'intro' => __( 'Show Intro Text', 'braftonium' ),
                    'outro' => __( 'Show Outro Text', 'braftonium' ),
                ),
                'allow_custom' => 0,
                'save_custom' => 0,
                'default_value' => array(
                ),
                'layout' => 'vertical',
                'toggle' => 0,
                'return_format' => 'value',
            ),
            array(
                'key' => 'field_5a4d48d386bd2',
                'label' => __( 'Intro Text', 'braftonium' ),
                'name' => 'intro_text',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5a4d47a385bd1',
                            'operator' => '==',
                            'value' => 'intro',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
            array(
                'key' => 'field_5b4d574f8c579',
                'label' => __( 'List Custom Content or Recent Posts', 'braftonium' ),
                'name' => 'list_type',
                'type' => 'radio',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'custom' => __( 'Custom', 'braftonium' ),
                    'recent' => __( 'Recent', 'braftonium' ),
                ),
                'allow_null' => 0,
                'other_choice' => 0,
                'save_other_choice' => 0,
                'default_value' => 'custom',
                'layout' => 'horizontal',
                'return_format' => 'value',
            ),
            array(
                'key' => 'field_5a4d587bcb1fe',
                'label' => __( 'Custom Slides', 'braftonium' ),
                'name' => 'slide',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5b4d574f8c579',
                            'operator' => '==',
                            'value' => 'custom',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '100',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => 'field_5a4f552a2f98e',
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'Add Slide',
                'sub_fields' => array(
                    array(
                        'key' => 'field_5a4f552a2f98e',
                        'label' => __( 'Heading', 'braftonium' ),
                        'name' => 'left-content',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '38',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'tabs' => 'all',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                        'delay' => 0,
                    ),
                    array(
                        'key' => 'field_5a4d48e4cb1ff',
                        'label' => __( 'Image', 'braftonium' ),
                        'name' => 'image',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '24',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'id',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),
                    array(
                        'key' => 'field_5a4d59e4cb200',
                        'label' => __( 'Content or Excerpt', 'braftonium' ),
                        'name' => 'right-content',
                        'type' => 'wysiwyg',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '38',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'tabs' => 'all',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                        'delay' => 0,
                    ),
                    array(
                        'key' => 'field_5a4d40facb201',
                        'label' => __( 'Link', 'braftonium' ),
                        'name' => 'button',
                        'type' => 'link',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                    ),
                ),
            ),
            array(
                'key' => 'field_5a5d5799d4ddb',
                'label' => __( 'Recent', 'braftonium' ),
                'name' => 'recent',
                'type' => 'radio',
                'instructions' => __( 'If not the most recent posts, put in a custom post type, eg: "testimonial", "event", and "team-member".', 'braftonium' ),
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5b4d574f8c579',
                            'operator' => '==',
                            'value' => 'recent',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'post' => 'post',
                ),
                'allow_null' => 0,
                'other_choice' => 1,
                'save_other_choice' => 0,
                'default_value' => '',
                'layout' => 'horizontal',
                'return_format' => 'value',
            ),
            array(
                'key' => 'field_5a4e583bee06f',
                'label' => __( 'Number of Posts', 'braftonium' ),
                'name' => 'number_of_posts',
                'type' => 'number',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5b4d574f8c579',
                            'operator' => '==',
                            'value' => 'recent',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5a590c535bed0',
                'label' => __( 'Button?', 'braftonium' ),
                'name' => 'showbutton',
                'type' => 'checkbox',
                'instructions' => __( 'Do not check this box if you want to link the content but not show a button.', 'braftonium' ),
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'show' => __( 'Show button?', 'braftonium' ),
                ),
                'allow_custom' => 0,
                'save_custom' => 0,
                'default_value' => array(
                ),
                'layout' => 'vertical',
                'toggle' => 0,
                'return_format' => 'value',
            ),
            array(
                'key' => 'field_5a591043640ea',
                'label' => __( 'Image Size and Shape', 'braftonium' ),
                'name' => 'image_size_and_shape',
                'type' => 'radio',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'circle' => __( 'Circle', 'braftonium' ),
                    'oval' => __( 'Oval', 'braftonium' ),
                ),
                'allow_custom' => 0,
                'save_custom' => 0,
                'default_value' => array(
                ),
                'layout' => 'vertical',
                'toggle' => 0,
                'return_format' => 'value',
            ),
            array(
                'key' => 'field_5a4d4ac04dc6d',
                'label' => __( 'Outro Text', 'braftonium' ),
                'name' => 'outro_text',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5a4d47a385bd1',
                            'operator' => '==',
                            'value' => 'outro',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
            array(
                'key' => 'field_5a4d571d47280',
                'label' => __( 'Style', 'braftonium' ),
                'name' => 'style',
                'type' => 'clone',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'clone' => array(
                    0 => 'group_5a4d3902e55eb',
                ),
                'display' => 'seamless',
                'layout' => 'block',
                'prefix_label' => 0,
                'prefix_name' => 0,
            ),
        ),
        'min' => '',
        'max' => '',
    )
);