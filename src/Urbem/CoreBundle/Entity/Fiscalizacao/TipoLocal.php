<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * TipoLocal
 */
class TipoLocal
{
    /**
     * PK
     * @var integer
     */
    private $codLocal;

    /**
     * @var string
     */
    private $nomLocal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras
     */
    private $fkFiscalizacaoProcessoFiscalObras;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoProcessoFiscalObras = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLocal
     *
     * @param integer $codLocal
     * @return TipoLocal
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * Set nomLocal
     *
     * @param string $nomLocal
     * @return TipoLocal
     */
    public function setNomLocal($nomLocal)
    {
        $this->nomLocal = $nomLocal;
        return $this;
    }

    /**
     * Get nomLocal
     *
     * @return string
     */
    public function getNomLocal()
    {
        return $this->nomLocal;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoProcessoFiscalObras
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras $fkFiscalizacaoProcessoFiscalObras
     * @return TipoLocal
     */
    public function addFkFiscalizacaoProcessoFiscalObras(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras $fkFiscalizacaoProcessoFiscalObras)
    {
        if (false === $this->fkFiscalizacaoProcessoFiscalObras->contains($fkFiscalizacaoProcessoFiscalObras)) {
            $fkFiscalizacaoProcessoFiscalObras->setFkFiscalizacaoTipoLocal($this);
            $this->fkFiscalizacaoProcessoFiscalObras->add($fkFiscalizacaoProcessoFiscalObras);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProcessoFiscalObras
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras $fkFiscalizacaoProcessoFiscalObras
     */
    public function removeFkFiscalizacaoProcessoFiscalObras(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras $fkFiscalizacaoProcessoFiscalObras)
    {
        $this->fkFiscalizacaoProcessoFiscalObras->removeElement($fkFiscalizacaoProcessoFiscalObras);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProcessoFiscalObras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras
     */
    public function getFkFiscalizacaoProcessoFiscalObras()
    {
        return $this->fkFiscalizacaoProcessoFiscalObras;
    }
}
