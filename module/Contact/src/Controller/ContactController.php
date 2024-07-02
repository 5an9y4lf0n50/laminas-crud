<?php

namespace Contact\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Contact\Model\ContactTable;
use Contact\Form\ContactForm;
use Contact\Model\Contact;

class ContactController extends AbstractActionController
{
    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(ContactTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'contacts' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new ContactForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $contact = new Contact();
        $form->setInputFilter($contact->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }
        

        $contact->exchangeArray($form->getData());
        $this->table->saveContact($contact);

        $this->flashMessenger()->addSuccessMessage(
            'Contact created successfully.'
        );

        return $this->redirect()->toRoute('contact');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('contact', ['action' => 'add']);
        }

        // Retrieve the contact with the specified id. Doing so raises
        // an exception if the contact is not found, which should result
        // in redirecting to the landing page.
        try {
            $contact = $this->table->getContact($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('contact', ['action' => 'index']);
        }

        $form = new ContactForm();
        $form->bind($contact);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($contact->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        try {

            $this->flashMessenger()->addSuccessMessage(
                'Contact updated successfully.'
            );

            $this->table->saveContact($contact);
        } catch (\Exception $e) {
        }

        // Redirect to contact list
        return $this->redirect()->toRoute('contact', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('contact');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteContact($id);
            }

            $this->flashMessenger()->addSuccessMessage(
                'Contact deleted successfully.'
            );

            // Redirect to list of contact
            return $this->redirect()->toRoute('contact');
        }

        return [
            'id'    => $id,
            'contact' => $this->table->getContact($id),
        ];
    }

    public function jsonAction()
    {
        $data = $this->table->fetchAll();
        return new JsonModel($data);
    }

    public function plainAction()
    {
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent('some data');
        return $response;
    }

}