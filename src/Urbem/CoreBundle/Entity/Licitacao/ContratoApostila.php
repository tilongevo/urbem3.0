<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ContratoApostila
 */
class ContratoApostila
{
    /**
     * PK
     * @var integer
     */
    private $codApostila;

    /**
     * PK
     * @var integer
     */
    private $numContrato;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codAlteracao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $dataApostila;

    /**
     * @var integer
     */
    private $valorApostila;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContrato;


    /**
     * Set codApostila
     *
     * @param integer $codApostila
     * @return ContratoApostila
     */
    public function setCodApostila($codApostila)
    {
        $this->codApostila = $codApostila;
        return $this;
    }

    /**
     * Get codApostila
     *
     * @return integer
     */
    public function getCodApostila()
    {
        return $this->codApostila;
    }

    /**
     * Set numContrato
     *
     * @param integer $numContrato
     * @return ContratoApostila
     */
    public function setNumContrato($numContrato)
    {
        $this->numContrato = $numContrato;
        return $this;
    }

    /**
     * Get numContrato
     *
     * @return integer
     */
    public function getNumContrato()
    {
        return $this->numContrato;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ContratoApostila
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContratoApostila
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ContratoApostila
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set codAlteracao
     *
     * @param integer $codAlteracao
     * @return ContratoApostila
     */
    public function setCodAlteracao($codAlteracao)
    {
        $this->codAlteracao = $codAlteracao;
        return $this;
    }

    /**
     * Get codAlteracao
     *
     * @return integer
     */
    public function getCodAlteracao()
    {
        return $this->codAlteracao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ContratoApostila
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set dataApostila
     *
     * @param \DateTime $dataApostila
     * @return ContratoApostila
     */
    public function setDataApostila(\DateTime $dataApostila)
    {
        $this->dataApostila = $dataApostila;
        return $this;
    }

    /**
     * Get dataApostila
     *
     * @return \DateTime
     */
    public function getDataApostila()
    {
        return $this->dataApostila;
    }

    /**
     * Set valorApostila
     *
     * @param integer $valorApostila
     * @return ContratoApostila
     */
    public function setValorApostila($valorApostila)
    {
        $this->valorApostila = $valorApostila;
        return $this;
    }

    /**
     * Get valorApostila
     *
     * @return integer
     */
    public function getValorApostila()
    {
        return $this->valorApostila;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return ContratoApostila
     */
    public function setFkLicitacaoContrato(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->exercicio = $fkLicitacaoContrato->getExercicio();
        $this->codEntidade = $fkLicitacaoContrato->getCodEntidade();
        $this->numContrato = $fkLicitacaoContrato->getNumContrato();
        $this->fkLicitacaoContrato = $fkLicitacaoContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoContrato
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContrato()
    {
        return $this->fkLicitacaoContrato;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codApostila;
    }
}
