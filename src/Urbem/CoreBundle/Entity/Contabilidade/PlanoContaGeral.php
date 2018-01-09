<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * PlanoContaGeral
 */
class PlanoContaGeral
{
    /**
     * PK
     * @var integer
     */
    private $codUf;

    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * @var string
     */
    private $versao;

    /**
     * @var \DateTime
     */
    private $dtVersao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEstrutura
     */
    private $fkContabilidadePlanoContaEstruturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaHistorico
     */
    private $fkContabilidadePlanoContaHistoricos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwUf
     */
    private $fkSwUf;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadePlanoContaEstruturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadePlanoContaHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return PlanoContaGeral
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return PlanoContaGeral
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set versao
     *
     * @param string $versao
     * @return PlanoContaGeral
     */
    public function setVersao($versao)
    {
        $this->versao = $versao;
        return $this;
    }

    /**
     * Get versao
     *
     * @return string
     */
    public function getVersao()
    {
        return $this->versao;
    }

    /**
     * Set dtVersao
     *
     * @param \DateTime $dtVersao
     * @return PlanoContaGeral
     */
    public function setDtVersao(\DateTime $dtVersao)
    {
        $this->dtVersao = $dtVersao;
        return $this;
    }

    /**
     * Get dtVersao
     *
     * @return \DateTime
     */
    public function getDtVersao()
    {
        return $this->dtVersao;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadePlanoContaEstrutura
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEstrutura $fkContabilidadePlanoContaEstrutura
     * @return PlanoContaGeral
     */
    public function addFkContabilidadePlanoContaEstruturas(\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEstrutura $fkContabilidadePlanoContaEstrutura)
    {
        if (false === $this->fkContabilidadePlanoContaEstruturas->contains($fkContabilidadePlanoContaEstrutura)) {
            $fkContabilidadePlanoContaEstrutura->setFkContabilidadePlanoContaGeral($this);
            $this->fkContabilidadePlanoContaEstruturas->add($fkContabilidadePlanoContaEstrutura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePlanoContaEstrutura
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEstrutura $fkContabilidadePlanoContaEstrutura
     */
    public function removeFkContabilidadePlanoContaEstruturas(\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEstrutura $fkContabilidadePlanoContaEstrutura)
    {
        $this->fkContabilidadePlanoContaEstruturas->removeElement($fkContabilidadePlanoContaEstrutura);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePlanoContaEstruturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEstrutura
     */
    public function getFkContabilidadePlanoContaEstruturas()
    {
        return $this->fkContabilidadePlanoContaEstruturas;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadePlanoContaHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaHistorico $fkContabilidadePlanoContaHistorico
     * @return PlanoContaGeral
     */
    public function addFkContabilidadePlanoContaHistoricos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaHistorico $fkContabilidadePlanoContaHistorico)
    {
        if (false === $this->fkContabilidadePlanoContaHistoricos->contains($fkContabilidadePlanoContaHistorico)) {
            $fkContabilidadePlanoContaHistorico->setFkContabilidadePlanoContaGeral($this);
            $this->fkContabilidadePlanoContaHistoricos->add($fkContabilidadePlanoContaHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePlanoContaHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaHistorico $fkContabilidadePlanoContaHistorico
     */
    public function removeFkContabilidadePlanoContaHistoricos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaHistorico $fkContabilidadePlanoContaHistorico)
    {
        $this->fkContabilidadePlanoContaHistoricos->removeElement($fkContabilidadePlanoContaHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePlanoContaHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaHistorico
     */
    public function getFkContabilidadePlanoContaHistoricos()
    {
        return $this->fkContabilidadePlanoContaHistoricos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwUf
     *
     * @param \Urbem\CoreBundle\Entity\SwUf $fkSwUf
     * @return PlanoContaGeral
     */
    public function setFkSwUf(\Urbem\CoreBundle\Entity\SwUf $fkSwUf)
    {
        $this->codUf = $fkSwUf->getCodUf();
        $this->fkSwUf = $fkSwUf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwUf
     *
     * @return \Urbem\CoreBundle\Entity\SwUf
     */
    public function getFkSwUf()
    {
        return $this->fkSwUf;
    }
}
