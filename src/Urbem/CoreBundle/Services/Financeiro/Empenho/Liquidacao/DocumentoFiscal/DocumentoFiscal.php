<?php

namespace Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class DocumentoFiscal
{
    private $simpleFactory;

    public $entityManager;

    public $session;

    protected $type;

    protected $notaLiquidacao;

    protected $dataForm;

    protected $codEmpenho;

    protected $types = [
        'al' => 'alagoas',
        'mg' => 'minasGerais',
        'rs' => 'rioGrandeSul',
    ];

    public function __construct(DocumentoFiscalFactory $simpleFactory, EntityManager $em, Session $session)
    {
        $this->simpleFactory = $simpleFactory;
        $this->entityManager = $em;
        $this->session = $session;
    }

    public function form()
    {
        $tipo = $this->type;

        $documentoFiscalType = $this->simpleFactory->getDocumentoFiscalType($tipo);

        return $documentoFiscalType->form($this);
    }

    public function execute()
    {
        $tipo = $this->type;

        $documentoFiscalType = $this->simpleFactory->getDocumentoFiscalType($tipo);

        return $documentoFiscalType->execute($this);
    }

    public function getInfo()
    {
        $tipo = $this->type;

        $documentoFiscalType = $this->simpleFactory->getDocumentoFiscalType($tipo);

        return $documentoFiscalType->getInfo($this);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $type = $this->parseType($type);

        if (empty($type)) {
            throw new \RuntimeException('Documento Fiscal type cannot be null');
        }

        $this->type = $type;
    }

    private function parseType($type)
    {
        if (!is_string($type)) {
            throw new \RuntimeException('String type expected [documento fiscal]');
        }

        return $this->types[strtolower($type)];
    }

    /**
     * @return mixed
     */
    public function getNotaLiquidacao()
    {
        return $this->notaLiquidacao;
    }

    /**,
     * @param $notaLiquidacao
     */
    public function setNotaLiquidacao($notaLiquidacao)
    {
        $this->notaLiquidacao = $notaLiquidacao;
    }

    /**
     * @return mixed
     */
    public function getDataForm()
    {
        return $this->dataForm;
    }

    /**
     * @param $dataForm
     */
    public function setDataForm($dataForm)
    {
        $this->dataForm = $dataForm;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return mixed
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * @param mixed $codEmpenho
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
    }
}
