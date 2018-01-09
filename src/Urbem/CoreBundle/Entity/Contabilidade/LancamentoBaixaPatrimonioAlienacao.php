<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * LancamentoBaixaPatrimonioAlienacao
 */
class LancamentoBaixaPatrimonioAlienacao
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
    private $codBem;

    /**
     * @var integer
     */
    private $codArrecadacao;

    /**
     * @var string
     */
    private $exercicioArrecadacao;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampArrecadacao;

    /**
     * @var boolean
     */
    private $estorno = false;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    private $fkContabilidadeLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    private $fkTesourariaArrecadacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
        $this->timestampArrecadacao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return LancamentoBaixaPatrimonioAlienacao
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
     * @return LancamentoBaixaPatrimonioAlienacao
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
     * @return LancamentoBaixaPatrimonioAlienacao
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
     * @return LancamentoBaixaPatrimonioAlienacao
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
     * @return LancamentoBaixaPatrimonioAlienacao
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
     * @return LancamentoBaixaPatrimonioAlienacao
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
     * @return LancamentoBaixaPatrimonioAlienacao
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
     * Set codBem
     *
     * @param integer $codBem
     * @return LancamentoBaixaPatrimonioAlienacao
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
     * Set codArrecadacao
     *
     * @param integer $codArrecadacao
     * @return LancamentoBaixaPatrimonioAlienacao
     */
    public function setCodArrecadacao($codArrecadacao)
    {
        $this->codArrecadacao = $codArrecadacao;
        return $this;
    }

    /**
     * Get codArrecadacao
     *
     * @return integer
     */
    public function getCodArrecadacao()
    {
        return $this->codArrecadacao;
    }

    /**
     * Set exercicioArrecadacao
     *
     * @param string $exercicioArrecadacao
     * @return LancamentoBaixaPatrimonioAlienacao
     */
    public function setExercicioArrecadacao($exercicioArrecadacao)
    {
        $this->exercicioArrecadacao = $exercicioArrecadacao;
        return $this;
    }

    /**
     * Get exercicioArrecadacao
     *
     * @return string
     */
    public function getExercicioArrecadacao()
    {
        return $this->exercicioArrecadacao;
    }

    /**
     * Set timestampArrecadacao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao
     * @return LancamentoBaixaPatrimonioAlienacao
     */
    public function setTimestampArrecadacao(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao)
    {
        $this->timestampArrecadacao = $timestampArrecadacao;
        return $this;
    }

    /**
     * Get timestampArrecadacao
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampArrecadacao()
    {
        return $this->timestampArrecadacao;
    }

    /**
     * Set estorno
     *
     * @param boolean $estorno
     * @return LancamentoBaixaPatrimonioAlienacao
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
     * @return LancamentoBaixaPatrimonioAlienacao
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
     * Set fkPatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return LancamentoBaixaPatrimonioAlienacao
     */
    public function setFkPatrimonioBem(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->codBem = $fkPatrimonioBem->getCodBem();
        $this->fkPatrimonioBem = $fkPatrimonioBem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBem()
    {
        return $this->fkPatrimonioBem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     * @return LancamentoBaixaPatrimonioAlienacao
     */
    public function setFkTesourariaArrecadacao(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        $this->codArrecadacao = $fkTesourariaArrecadacao->getCodArrecadacao();
        $this->exercicioArrecadacao = $fkTesourariaArrecadacao->getExercicio();
        $this->timestampArrecadacao = $fkTesourariaArrecadacao->getTimestampArrecadacao();
        $this->fkTesourariaArrecadacao = $fkTesourariaArrecadacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaArrecadacao
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    public function getFkTesourariaArrecadacao()
    {
        return $this->fkTesourariaArrecadacao;
    }
}
