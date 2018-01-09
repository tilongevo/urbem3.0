<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ArquivoAmp
 */
class ArquivoAmp
{
    /**
     * PK
     * @var integer
     */
    private $codAcao;

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
     * @var \Urbem\CoreBundle\Entity\Ppa\Acao
     */
    private $fkPpaAcao;


    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return ArquivoAmp
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ArquivoAmp
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
     * @return ArquivoAmp
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
     * Set fkPpaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao
     * @return ArquivoAmp
     */
    public function setFkPpaAcao(\Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao)
    {
        $this->codAcao = $fkPpaAcao->getCodAcao();
        $this->fkPpaAcao = $fkPpaAcao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaAcao
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Acao
     */
    public function getFkPpaAcao()
    {
        return $this->fkPpaAcao;
    }
}
