<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * LancamentoDepreciacao
 */
class LancamentoDepreciacao
{
    /**
     * PK
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var integer
     */
    private $codLote;

    /**
     * @var integer
     */
    private $sequencia;

    /**
     * @var integer
     */
    private $codDepreciacao;

    /**
     * @var integer
     */
    private $codBem;

    /**
     * @var \DateTime
     */
    private $timestampDepreciacao;

    /**
     * @var boolean
     */
    private $estorno;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    private $fkContabilidadeLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Depreciacao
     */
    private $fkPatrimonioDepreciacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return LancamentoDepreciacao
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return LancamentoDepreciacao
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return LancamentoDepreciacao
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return LancamentoDepreciacao
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return LancamentoDepreciacao
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LancamentoDepreciacao
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return LancamentoDepreciacao
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set codDepreciacao
     *
     * @param integer $codDepreciacao
     * @return LancamentoDepreciacao
     */
    public function setCodDepreciacao($codDepreciacao)
    {
        $this->codDepreciacao = $codDepreciacao;
        return $this;
    }

    /**
     * Get codDepreciacao
     *
     * @return integer
     */
    public function getCodDepreciacao()
    {
        return $this->codDepreciacao;
    }

    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return LancamentoDepreciacao
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set timestampDepreciacao
     *
     * @param \DateTime $timestampDepreciacao
     * @return LancamentoDepreciacao
     */
    public function setTimestampDepreciacao(\DateTime $timestampDepreciacao)
    {
        $this->timestampDepreciacao = $timestampDepreciacao;
        return $this;
    }

    /**
     * Get timestampDepreciacao
     *
     * @return \DateTime
     */
    public function getTimestampDepreciacao()
    {
        return $this->timestampDepreciacao;
    }

    /**
     * Set estorno
     *
     * @param boolean $estorno
     * @return LancamentoDepreciacao
     */
    public function setEstorno($estorno)
    {
        $this->estorno = $estorno;
        return $this;
    }

    /**
     * Get estorno
     *
     * @return boolean
     */
    public function getEstorno()
    {
        return $this->estorno;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento
     * @return LancamentoDepreciacao
     */
    public function setFkContabilidadeLancamento(\Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento)
    {
        $this->sequencia = $fkContabilidadeLancamento->getSequencia();
        $this->codLote = $fkContabilidadeLancamento->getCodLote();
        $this->tipo = $fkContabilidadeLancamento->getTipo();
        $this->exercicio = $fkContabilidadeLancamento->getExercicio();
        $this->codEntidade = $fkContabilidadeLancamento->getCodEntidade();
        $this->fkContabilidadeLancamento = $fkContabilidadeLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    public function getFkContabilidadeLancamento()
    {
        return $this->fkContabilidadeLancamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Depreciacao $fkPatrimonioDepreciacao
     * @return LancamentoDepreciacao
     */
    public function setFkPatrimonioDepreciacao(\Urbem\CoreBundle\Entity\Patrimonio\Depreciacao $fkPatrimonioDepreciacao)
    {
        $this->codDepreciacao = $fkPatrimonioDepreciacao->getCodDepreciacao();
        $this->codBem = $fkPatrimonioDepreciacao->getCodBem();
        $this->timestampDepreciacao = $fkPatrimonioDepreciacao->getTimestamp();
        $this->fkPatrimonioDepreciacao = $fkPatrimonioDepreciacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioDepreciacao
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Depreciacao
     */
    public function getFkPatrimonioDepreciacao()
    {
        return $this->fkPatrimonioDepreciacao;
    }

    public function __toString()
    {
        return (string) $this->fkPatrimonioDepreciacao;
    }
}
