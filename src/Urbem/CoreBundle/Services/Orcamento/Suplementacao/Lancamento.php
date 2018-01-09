<?php

namespace Urbem\CoreBundle\Services\Orcamento\Suplementacao;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class Lancamento
{
    private $simpleFactory;

    public $entityManager;

    public $session;

    protected $type;

    protected $subType = null;

    protected $exercicio;

    protected $entidade;

    protected $descricaoDecreto;

    protected $valor;

    protected $codLote = null;

    protected $sequencia = null;

    protected $subTipoReabrir = null;

    protected $types = [
        'suplementar' => [1, 2, 3, 4, 5],
        'especial' => [6, 7, 8, 9, 10],
        'extraordinario' => [11],
        'transferencia' => [12, 13, 14],
        'anulacaoExterna' => [15],
        'anulacaoSuplementacao' => [16]
    ];

    protected $subTypes = [
        'suplementarAnulacao' => [1, 2, 3, 4, 5],
        'especialAnulacao' => [6, 7, 8, 9, 10],
        'extraordinarioAnulacao' => [11],
        'transferenciaAnulacao' => [12, 13, 14],
        'anulacaoExternaAnulacao' => [15]
    ];

    public function __construct(LancamentoFactory $simpleFactory, EntityManager $em, Session $session)
    {
        $this->simpleFactory = $simpleFactory;
        $this->entityManager = $em;
        $this->session = $session;
    }

    public function execute()
    {
        $tipo = $this->type;
        if (is_null($tipo)) {
            $tipo = $this->subType;
        }
        $lancamentoType = $this->simpleFactory->getLancamentoType($tipo);

        return $lancamentoType->execute($this);
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
            throw new \RuntimeException('Lancamento type cannot be null');
        }

        $this->type = $type;
    }

    private function parseType($type)
    {
        if (!is_integer($type)) {
            throw new \RuntimeException('Integer lancamento type expected');
        }
        $typeArray = array_filter($this->types, function ($key) use ($type) {
            return in_array($type, $this->types[$key]);
        }, ARRAY_FILTER_USE_KEY);
        $key = array_keys($typeArray);
        return array_shift($key);
    }

    /**
     * @return mixed
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * @param mixed $exercicio
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
    }

    /**
     * @return mixed
     */
    public function getEntidade()
    {
        return $this->entidade;
    }

    /**
     * @param mixed $entidade
     */
    public function setEntidade($entidade)
    {
        $this->entidade = $entidade;
    }

    public function setDescricaoDecreto($norma)
    {
        $descricaoDecreto = $norma->getFkNormasNormaTipoNormas()->first()->getFkNormasTipoNorma()->getNomTipoNorma()
            . ' ' . $norma->getNumNorma()
            . '/' . $norma->getExercicio()
            . ' - ' . $norma->getNomNorma();

        $this->descricaoDecreto = $descricaoDecreto;
    }

    /**
     * @return mixed
     */
    public function getDescricaoDecreto()
    {
        return $this->descricaoDecreto;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return mixed
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * @param mixed $codLote
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
    }

    /**
     * @return mixed
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * @param mixed $sequencia
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
    }

    /**
     * @return null
     */
    public function getSubTipoReabrir()
    {
        return $this->subTipoReabrir;
    }

    /**
     * @param null $subTipoReabrir
     */
    public function setSubTipoReabrir($subTipoReabrir)
    {
        $this->subTipoReabrir = $subTipoReabrir;
    }

    /**
     * @return mixed
     */
    public function getSubType()
    {
        return $this->subTypes;
    }

    public function setSubType($subType)
    {
        $subType = $this->parseSubType($subType);
        if (empty($subType)) {
            throw new \RuntimeException('Lancamento sub type cannot be null');
        }

        $this->subType = $subType;
    }

    private function parseSubType($subType)
    {
        if (!is_integer($subType)) {
            throw new \RuntimeException('Integer lancamento sub type expected');
        }
        $typeArray = array_filter($this->subTypes, function ($key) use ($subType) {
            return in_array($subType, $this->subTypes[$key]);
        }, ARRAY_FILTER_USE_KEY);

        $types = array_keys($typeArray);
        return array_shift($types);
    }
}
