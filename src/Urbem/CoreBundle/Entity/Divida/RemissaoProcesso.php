<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * RemissaoProcesso
 */
class RemissaoProcesso
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
     * @var \Urbem\CoreBundle\Entity\Divida\DividaRemissao
     */
    private $fkDividaDividaRemissao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;


    /**
     * Set codInscricao
     *
     * @param integer $codInscricao
     * @return RemissaoProcesso
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
     * @return RemissaoProcesso
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
     * @return RemissaoProcesso
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
     * @return RemissaoProcesso
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
     * @return RemissaoProcesso
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
     * Set DividaDividaRemissao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaRemissao $fkDividaDividaRemissao
     * @return RemissaoProcesso
     */
    public function setFkDividaDividaRemissao(\Urbem\CoreBundle\Entity\Divida\DividaRemissao $fkDividaDividaRemissao)
    {
        $this->codInscricao = $fkDividaDividaRemissao->getCodInscricao();
        $this->exercicio = $fkDividaDividaRemissao->getExercicio();
        $this->fkDividaDividaRemissao = $fkDividaDividaRemissao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkDividaDividaRemissao
     *
     * @return \Urbem\CoreBundle\Entity\Divida\DividaRemissao
     */
    public function getFkDividaDividaRemissao()
    {
        return $this->fkDividaDividaRemissao;
    }
}
