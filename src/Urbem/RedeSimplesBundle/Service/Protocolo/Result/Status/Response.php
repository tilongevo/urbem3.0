<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Result\Status;

use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch\FieldCollection;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch\FieldCollectionInterface;

class Response implements StatusResponseInterface
{
    /**
     * @var string
     */
    protected $mensagem;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var FieldCollectionInterface
     */
    protected $fields;

    public function __construct(array $response)
    {
        $this->mensagem = (string) $response['message'];
        $this->status = (string) $response['status'];
        $this->fields = new FieldCollection($response['fields']);
    }

    /**
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return FieldCollectionInterface
     */
    public function getFields()
    {
        return $this->fields;
    }
}
