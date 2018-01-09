<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ArquivoIuoc
 */
class ArquivoIuoc
{
    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * PK
     * @var integer
     */
    private $numUnidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $mes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\Uniorcam
     */
    private $fkTcemgUniorcam;


    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return ArquivoIuoc
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return ArquivoIuoc
     */
    public function setNumUnidade($numUnidade)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ArquivoIuoc
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
     * Set mes
     *
     * @param integer $mes
     * @return ArquivoIuoc
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Uniorcam $fkTcemgUniorcam
     * @return ArquivoIuoc
     */
    public function setFkTcemgUniorcam(\Urbem\CoreBundle\Entity\Tcemg\Uniorcam $fkTcemgUniorcam)
    {
        $this->exercicio = $fkTcemgUniorcam->getExercicio();
        $this->numUnidade = $fkTcemgUniorcam->getNumUnidade();
        $this->numOrgao = $fkTcemgUniorcam->getNumOrgao();
        $this->fkTcemgUniorcam = $fkTcemgUniorcam;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgUniorcam
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\Uniorcam
     */
    public function getFkTcemgUniorcam()
    {
        return $this->fkTcemgUniorcam;
    }
}
