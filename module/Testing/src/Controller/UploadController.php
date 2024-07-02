<?php

namespace Testing\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Testing\Form\UploadForm;
use Testing\Service\ImageManager;

class UploadController extends AbstractActionController
{
    // The image manager.
    private ImageManager $imageManager;
  
    // The constructor method is used for injecting the dependencies 
    // into the controller.
    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function indexAction()
    {
        // Create the form model.
        $form = new UploadForm();
        
        // Check if user has submitted the form.
        if($this->getRequest()->isPost()) {
            
            // Make certain to merge the files info!
            $request = $this->getRequest();
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            
            // Pass data to form.
            $form->setData($data);
                
            // Validate form.
            if($form->isValid()) {
                    
                // Move uploaded file to its destination directory.
                $data = $form->getData();
                    
                // Redirect the user to "Image Gallery" page.
                return $this->redirect()->toRoute('testing.upload');
            }                        
        } 
        
        // Render the page.
        return new ViewModel(['form' => $form]);
    }
}