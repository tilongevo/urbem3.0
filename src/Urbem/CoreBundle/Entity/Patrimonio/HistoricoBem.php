<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * HistoricoBem
 */
class HistoricoBem
{
    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codSituacao;

    /**
     * @var integer
     */
    private $codLocal;

    /**
     * @var integer
     */
    private $codOrgao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem
     */
    private $fkPatrimonioInventarioHistoricoBens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\SituacaoBem
     */
    private $fkPatrimonioSituacaoBem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPatrimonioInventarioHistoricoBens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return HistoricoBem
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
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return HistoricoBem
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codSituacao
     *
     * @param integer $codSituacao
     * @return HistoricoBem
     */
    public function setCodSituacao($codSituacao)
    {
        $this->codSituacao = $codSituacao;
        return $this;
    }

    /**
     * Get codSituacao
     *
     * @return integer
     */
    public function getCodSituacao()
    {
        return $this->codSituacao;
    }

    /**
     * Set codLocal
     *
     * @param integer $codLocal
     * @return HistoricoBem
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
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return HistoricoBem
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return HistoricoBem
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
     * OneToMany (owning side)
     * Add PatrimonioInventarioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem
     * @return HistoricoBem
     */
    public function addFkPatrimonioInventarioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem)
    {
        if (false === $this->fkPatrimonioInventarioHistoricoBens->contains($fkPatrimonioInventarioHistoricoBem)) {
            $fkPatrimonioInventarioHistoricoBem->setFkPatrimonioHistoricoBem($this);
            $this->fkPatrimonioInventarioHistoricoBens->add($fkPatrimonioInventarioHistoricoBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioInventarioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem
     */
    public function removeFkPatrimonioInventarioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem)
    {
        $this->fkPatrimonioInventarioHistoricoBens->removeElement($fkPatrimonioInventarioHistoricoBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioInventarioHistoricoBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem
     */
    public function getFkPatrimonioInventarioHistoricoBens()
    {
        return $this->fkPatrimonioInventarioHistoricoBens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return HistoricoBem
     */
    public function setFkPatrimonioBem(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->codBem = $fkPatrimonioBem->getCodBem();
        $this->fkPatrimonioBem = $fkPatrimonioBem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBem()
    {
        return $this->fkPatrimonioBem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioSituacaoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\SituacaoBem $fkPatrimonioSituacaoBem
     * @return HistoricoBem
     */
    public function setFkPatrimonioSituacaoBem(\Urbem\CoreBundle\Entity\Patrimonio\SituacaoBem $fkPatrimonioSituacaoBem)
    {
        $this->codSituacao = $fkPatrimonioSituacaoBem->getCodSituacao();
        $this->fkPatrimonioSituacaoBem = $fkPatrimonioSituacaoBem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioSituacaoBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\SituacaoBem
     */
    public function getFkPatrimonioSituacaoBem()
    {
        return $this->fkPatrimonioSituacaoBem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return HistoricoBem
     */
    public function setFkOrganogramaLocal(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        $this->codLocal = $fkOrganogramaLocal->getCodLocal();
        $this->fkOrganogramaLocal = $fkOrganogramaLocal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaLocal
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Local
     */
    public function getFkOrganogramaLocal()
    {
        return $this->fkOrganogramaLocal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return HistoricoBem
     */
    public function setFkOrganogramaOrgao(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgao = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }
}
