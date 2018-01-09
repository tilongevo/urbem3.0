<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ProvimentoContabil
 */
class ProvimentoContabil
{
    /**
     * PK
     * @var integer
     */
    private $codProvimento;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    private $fkTcmgoUnidadeResponsaveis;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoUnidadeResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codProvimento
     *
     * @param integer $codProvimento
     * @return ProvimentoContabil
     */
    public function setCodProvimento($codProvimento)
    {
        $this->codProvimento = $codProvimento;
        return $this;
    }

    /**
     * Get codProvimento
     *
     * @return integer
     */
    public function getCodProvimento()
    {
        return $this->codProvimento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ProvimentoContabil
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
     * Add TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     * @return ProvimentoContabil
     */
    public function addFkTcmgoUnidadeResponsaveis(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        if (false === $this->fkTcmgoUnidadeResponsaveis->contains($fkTcmgoUnidadeResponsavel)) {
            $fkTcmgoUnidadeResponsavel->setFkTcmgoProvimentoContabil($this);
            $this->fkTcmgoUnidadeResponsaveis->add($fkTcmgoUnidadeResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     */
    public function removeFkTcmgoUnidadeResponsaveis(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        $this->fkTcmgoUnidadeResponsaveis->removeElement($fkTcmgoUnidadeResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoUnidadeResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    public function getFkTcmgoUnidadeResponsaveis()
    {
        return $this->fkTcmgoUnidadeResponsaveis;
    }
}
