<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ConvenioAditivo
 */
class ConvenioAditivo
{
    /**
     * PK
     * @var integer
     */
    private $codConvenio;

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
     * PK
     * @var integer
     */
    private $codAditivo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $dataAssinatura;

    /**
     * @var \DateTime
     */
    private $dataFinal;

    /**
     * @var integer
     */
    private $vlConvenio;

    /**
     * @var integer
     */
    private $vlContra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\Convenio
     */
    private $fkTcemgConvenio;


    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConvenioAditivo
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ConvenioAditivo
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
     * @return ConvenioAditivo
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
     * Set codAditivo
     *
     * @param integer $codAditivo
     * @return ConvenioAditivo
     */
    public function setCodAditivo($codAditivo)
    {
        $this->codAditivo = $codAditivo;
        return $this;
    }

    /**
     * Get codAditivo
     *
     * @return integer
     */
    public function getCodAditivo()
    {
        return $this->codAditivo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ConvenioAditivo
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
     * Set dataAssinatura
     *
     * @param \DateTime $dataAssinatura
     * @return ConvenioAditivo
     */
    public function setDataAssinatura(\DateTime $dataAssinatura)
    {
        $this->dataAssinatura = $dataAssinatura;
        return $this;
    }

    /**
     * Get dataAssinatura
     *
     * @return \DateTime
     */
    public function getDataAssinatura()
    {
        return $this->dataAssinatura;
    }

    /**
     * Set dataFinal
     *
     * @param \DateTime $dataFinal
     * @return ConvenioAditivo
     */
    public function setDataFinal(\DateTime $dataFinal = null)
    {
        $this->dataFinal = $dataFinal;
        return $this;
    }

    /**
     * Get dataFinal
     *
     * @return \DateTime
     */
    public function getDataFinal()
    {
        return $this->dataFinal;
    }

    /**
     * Set vlConvenio
     *
     * @param integer $vlConvenio
     * @return ConvenioAditivo
     */
    public function setVlConvenio($vlConvenio = null)
    {
        $this->vlConvenio = $vlConvenio;
        return $this;
    }

    /**
     * Get vlConvenio
     *
     * @return integer
     */
    public function getVlConvenio()
    {
        return $this->vlConvenio;
    }

    /**
     * Set vlContra
     *
     * @param integer $vlContra
     * @return ConvenioAditivo
     */
    public function setVlContra($vlContra = null)
    {
        $this->vlContra = $vlContra;
        return $this;
    }

    /**
     * Get vlContra
     *
     * @return integer
     */
    public function getVlContra()
    {
        return $this->vlContra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Convenio $fkTcemgConvenio
     * @return ConvenioAditivo
     */
    public function setFkTcemgConvenio(\Urbem\CoreBundle\Entity\Tcemg\Convenio $fkTcemgConvenio)
    {
        $this->codConvenio = $fkTcemgConvenio->getCodConvenio();
        $this->codEntidade = $fkTcemgConvenio->getCodEntidade();
        $this->exercicio = $fkTcemgConvenio->getExercicio();
        $this->fkTcemgConvenio = $fkTcemgConvenio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\Convenio
     */
    public function getFkTcemgConvenio()
    {
        return $this->fkTcemgConvenio;
    }
}
