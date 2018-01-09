<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * ProcessoCancelamento
 */
class ProcessoCancelamento
{
    /**
     * PK
     * @var integer
     */
    private $codInscricao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $anoExercicio;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Divida\DividaCancelada
     */
    private $fkDividaDividaCancelada;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;


    /**
     * Set codInscricao
     *
     * @param integer $codInscricao
     * @return ProcessoCancelamento
     */
    public function setCodInscricao($codInscricao)
    {
        $this->codInscricao = $codInscricao;
        return $this;
    }

    /**
     * Get codInscricao
     *
     * @return integer
     */
    public function getCodInscricao()
    {
        return $this->codInscricao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ProcessoCancelamento
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProcessoCancelamento
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return ProcessoCancelamento
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ProcessoCancelamento
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }

    /**
     * OneToOne (owning side)
     * Set DividaDividaCancelada
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaCancelada $fkDividaDividaCancelada
     * @return ProcessoCancelamento
     */
    public function setFkDividaDividaCancelada(\Urbem\CoreBundle\Entity\Divida\DividaCancelada $fkDividaDividaCancelada)
    {
        $this->codInscricao = $fkDividaDividaCancelada->getCodInscricao();
        $this->exercicio = $fkDividaDividaCancelada->getExercicio();
        $this->fkDividaDividaCancelada = $fkDividaDividaCancelada;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkDividaDividaCancelada
     *
     * @return \Urbem\CoreBundle\Entity\Divida\DividaCancelada
     */
    public function getFkDividaDividaCancelada()
    {
        return $this->fkDividaDividaCancelada;
    }
}
