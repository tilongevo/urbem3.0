<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * ProcessoEstorno
 */
class ProcessoEstorno
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
     * @var \Urbem\CoreBundle\Entity\Divida\DividaEstorno
     */
    private $fkDividaDividaEstorno;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;


    /**
     * Set codInscricao
     *
     * @param integer $codInscricao
     * @return ProcessoEstorno
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
     * @return ProcessoEstorno
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
     * @return ProcessoEstorno
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
     * @return ProcessoEstorno
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
     * @return ProcessoEstorno
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
     * Set DividaDividaEstorno
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaEstorno $fkDividaDividaEstorno
     * @return ProcessoEstorno
     */
    public function setFkDividaDividaEstorno(\Urbem\CoreBundle\Entity\Divida\DividaEstorno $fkDividaDividaEstorno)
    {
        $this->codInscricao = $fkDividaDividaEstorno->getCodInscricao();
        $this->exercicio = $fkDividaDividaEstorno->getExercicio();
        $this->fkDividaDividaEstorno = $fkDividaDividaEstorno;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkDividaDividaEstorno
     *
     * @return \Urbem\CoreBundle\Entity\Divida\DividaEstorno
     */
    public function getFkDividaDividaEstorno()
    {
        return $this->fkDividaDividaEstorno;
    }
}
