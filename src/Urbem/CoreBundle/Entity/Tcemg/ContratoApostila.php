<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

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
    private $codContrato;

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
     * @var \Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    private $fkTcemgContrato;


    /**
     * Set codApostila
     *
     * @param integer $codApostila
     * @return ContratoApostila
     */
    public function setCodApostila($codApostila = null)
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
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoApostila
     */
    public function setCodContrato($codContrato = null)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ContratoApostila
     */
    public function setCodEntidade($codEntidade = null)
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
    public function setExercicio($exercicio = null)
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
    public function setCodTipo($codTipo = null)
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
    public function setCodAlteracao($codAlteracao = null)
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
    public function setDescricao($descricao = null)
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
    public function setDataApostila(\DateTime $dataApostila = null)
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
    public function setValorApostila($valorApostila = null)
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
     * Set fkTcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     * @return ContratoApostila
     */
    public function setFkTcemgContrato(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato = null)
    {
        $this->codContrato = $fkTcemgContrato->getCodContrato();
        $this->codEntidade = $fkTcemgContrato->getCodEntidade();
        $this->exercicio = $fkTcemgContrato->getExercicio();
        $this->fkTcemgContrato = $fkTcemgContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgContrato
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    public function getFkTcemgContrato()
    {
        return $this->fkTcemgContrato;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->codApostila, $this->exercicio);
    }
}
