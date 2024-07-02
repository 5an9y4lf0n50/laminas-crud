<?php

namespace Testing\Form;

use Laminas\Form\Form;
use Laminas\Form\Element\File;
use Laminas\Form\Element\Submit;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\FileInput;

class UploadForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('upload');

        // Set POST method for this form.
        $this->setAttribute('method', 'post');
            
        // Set binary content encoding.
        $this->setAttribute('enctype', 'multipart/form-data');

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

        $this->addInputFilter();  

    }

    private function addInputFilter() 
    {
        $inputFilter = new InputFilter();   
        $this->setInputFilter($inputFilter);
     
        // Add validation rules for the "file" field.	 
        $inputFilter->add([
            'type'     => FileInput::class,
            'name'     => 'file',
            'required' => true,   
            'validators' => [
                ['name'    => 'FileUploadFile'],
                [
                    'name'    => 'FileMimeType',                        
                    'options' => [                            
                        'mimeType'  => ['image/jpeg', 'image/png']
                    ]
                ],
                ['name'    => 'FileIsImage'],
                [
                    'name'    => 'FileImageSize',
                    'options' => [
                        'minWidth'  => 128,
                        'minHeight' => 128,
                        'maxWidth'  => 4096,
                        'maxHeight' => 4096
                    ]
                ],
            ],
            'filters'  => [                    
                [
                    'name' => 'FileRenameUpload',
                    'options' => [  
                        'target' => './data/upload',
                        'useUploadName' => true,
                        'useUploadExtension' => true,
                        'overwrite' => true,
                        'randomize' => false
                    ]
                ]
            ],   
        ]);                
    }
}