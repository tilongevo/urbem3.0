<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * DepreciacaoReavaliacao
 */
class DepreciacaoReavaliacao
{
    /**
     * PK
     * @var integer
     */
    private $codDepreciacao;

    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codReavaliacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Depreciacao
     */
    private $fkPatrimonioDepreciacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Reavaliacao
     */
    private $fkPatrimonioReavaliacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codDepreciacao
     *
     * @param integer $codDepreciacao
     * @return DepreciacaoReavaliacao
     */
    public function setCodDepreciacao($codDepreciacao)
    {
        $this->codDepreciacao = $codDepreciacao;
        return $this;
    }

    /**
     * Get codDepreciacao
     *
     * @return integer
     */
    public function getCodDepreciacao()
    {
        return $this->codDepreciacao;
    }

    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return DepreciacaoReavaliacao
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return DepreciacaoReavaliacao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codReavaliacao
     *
     * @param integer $codReavaliacao
     * @return DepreciacaoReavaliacao
     */
    public function setCodReavaliacao($codReavaliacao)
    {
        $this->codReavaliacao = $codReavaliacao;
        return $this;
    }

    /**
     * Get codReavaliacao
     *
     * @return integer
     */
    public function getCodReavaliacao()
    {
        return $this->codReavaliacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioReavaliacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Reavaliacao $fkPatrimonioReavaliacao
     * @return DepreciacaoReavaliacao
     */
    public function setFkPatrimonioReavaliacao(\Urbem\CoreBundle\Entity\Patrimonio\Reavaliacao $fkPatrimonioReavaliacao)
    {
        $this->codReavaliacao = $fkPatrimonioReavaliacao->getCodReavaliacao();
        $this->codBem = $fkPatrimonioReavaliacao->getCodBem();
        $this->fkPatrimonioReavaliacao = $fkPatrimonioReavaliacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioReavaliacao
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Reavaliacao
     */
    public function getFkPatrimonioReavaliacao()
    {
        return $this->fkPatrimonioReavaliacao;
    }

    /**
     * OneToOne (owning side)
     * Set PatrimonioDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Depreciacao $fkPatrimonioDepreciacao
     * @return DepreciacaoReavaliacao
     */
    public function setFkPatrimonioDepreciacao(\Urbem\CoreBundle\Entity\Patrimonio\Depreciacao $fkPatrimonioDepreciacao)
    {
        $this->codDepreciacao = $fkPatrimonioDepreciacao->getCodDepreciacao();
        $this->codBem = $fkPatrimonioDepreciacao->getCodBem();
        $this->timestamp = $fkPatrimonioDepreciacao->getTimestamp();
        $this->fkPatrimonioDepreciacao = $fkPatrimonioDepreciacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPatrimonioDepreciacao
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Depreciacao
     */
    public function getFkPatrimonioDepreciacao()
    {
        return $this->fkPatrimonioDepreciacao;
    }
}
