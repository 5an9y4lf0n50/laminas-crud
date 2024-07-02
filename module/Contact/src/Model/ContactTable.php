<?php

namespace Contact\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class ContactTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getContact($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveContact(Contact $contact)
    {
        $data = [
            'name'      => $contact->name,
            'email'     => $contact->email,
            'phone'     => $contact->phone,
            'website'   => $contact->website,
            'address'   => $contact->address,
            'status'    => $contact->status,
        ];

      

        $id = (int) $contact->id;

        if ($id === 0) {
            $data["created_at"] = date("Y-m-d H:i:s");
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getContact($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update contact with identifier %d; does not exist',
                $id
            ));
        }
        
        $data["updated_at"] = date("Y-m-d H:i:s");
        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteContact($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}