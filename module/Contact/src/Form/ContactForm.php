<?php

namespace Contact\Form;

use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\File;
use Laminas\Form\Form;

class ContactForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('contact');

        $this->add([
            'name' => 'id',
            'type' => Hidden::class,
        ]);
        $this->add([
            'name' => 'name',
            'type' => Text::class,
            'options' => [
                'label' => 'Name',
            ],
        ]);
        $this->add([
            'name' => 'email',
            'type' => Text::class,
            'options' => [
                'label' => 'Email',
            ],
        ]);
        $this->add([
            'name' => 'phone',
            'type' => Text::class,
            'options' => [
                'label' => 'Phone',
            ],
        ]);
        $this->add([
            'name' => 'website',
            'type' => Text::class,
            'options' => [
                'label' => 'Website',
            ],
        ]);
        $this->add([
            'name' => 'address',
            'type' => Textarea::class,
            'options' => [
                'label' => 'Street Address',
            ],
        ]);
        $this->add([
            'name' => 'status',
            'type' => Select::class,
            'options' => [
                'label' => 'Status',
                'value_options' => [
                    '' => '',
                    '0' => 'Disable',
                    '1' => 'Enable'
                ],
            ],
        ]);
        $this->add([
            'type'  => File::class,
            'name' => 'file',
            'attributes' => [                
                'id' => 'file'
            ],
            'options' => [
                'label' => 'Upload file',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}