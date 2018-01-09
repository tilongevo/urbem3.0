<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * RoyaltiesEmpenho
 */
class RoyaltiesEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

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
    private $codRoyalties;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\Royalties
     */
    private $fkTcernRoyalties;


    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return RoyaltiesEmpenho
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return RoyaltiesEmpenho
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
     * @return RoyaltiesEmpenho
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
     * Set codRoyalties
     *
     * @param integer $codRoyalties
     * @return RoyaltiesEmpenho
     */
    public function setCodRoyalties($codRoyalties)
    {
        $this->codRoyalties = $codRoyalties;
        return $this;
    }

    /**
     * Get codRoyalties
     *
     * @return integer
     */
    public function getCodRoyalties()
    {
        return $this->codRoyalties;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return RoyaltiesEmpenho
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicio = $fkEmpenhoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenho->getCodEntidade();
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcernRoyalties
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\Royalties $fkTcernRoyalties
     * @return RoyaltiesEmpenho
     */
    public function setFkTcernRoyalties(\Urbem\CoreBundle\Entity\Tcern\Royalties $fkTcernRoyalties)
    {
        $this->codRoyalties = $fkTcernRoyalties->getCodRoyalties();
        $this->fkTcernRoyalties = $fkTcernRoyalties;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernRoyalties
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\Royalties
     */
    public function getFkTcernRoyalties()
    {
        return $this->fkTcernRoyalties;
    }
}
