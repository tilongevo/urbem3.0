<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Enquadramento
 */
class Enquadramento
{
    /**
     * PK
     * @var integer
     */
    private $codEnquadramento;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $reajuste;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ClassificacaoEnquadramento
     */
    private $fkPessoalClassificacaoEnquadramentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalClassificacaoEnquadramentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEnquadramento
     *
     * @param integer $codEnquadramento
     * @return Enquadramento
     */
    public function setCodEnquadramento($codEnquadramento)
    {
        $this->codEnquadramento = $codEnquadramento;
        return $this;
    }

    /**
     * Get codEnquadramento
     *
     * @return integer
     */
    public function getCodEnquadramento()
    {
        return $this->codEnquadramento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Enquadramento
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
     * Set reajuste
     *
     * @param string $reajuste
     * @return Enquadramento
     */
    public function setReajuste($reajuste)
    {
        $this->reajuste = $reajuste;
        return $this;
    }

    /**
     * Get reajuste
     *
     * @return string
     */
    public function getReajuste()
    {
        return $this->reajuste;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalClassificacaoEnquadramento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ClassificacaoEnquadramento $fkPessoalClassificacaoEnquadramento
     * @return Enquadramento
     */
    public function addFkPessoalClassificacaoEnquadramentos(\Urbem\CoreBundle\Entity\Pessoal\ClassificacaoEnquadramento $fkPessoalClassificacaoEnquadramento)
    {
        if (false === $this->fkPessoalClassificacaoEnquadramentos->contains($fkPessoalClassificacaoEnquadramento)) {
            $fkPessoalClassificacaoEnquadramento->setFkPessoalEnquadramento($this);
            $this->fkPessoalClassificacaoEnquadramentos->add($fkPessoalClassificacaoEnquadramento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalClassificacaoEnquadramento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ClassificacaoEnquadramento $fkPessoalClassificacaoEnquadramento
     */
    public function removeFkPessoalClassificacaoEnquadramentos(\Urbem\CoreBundle\Entity\Pessoal\ClassificacaoEnquadramento $fkPessoalClassificacaoEnquadramento)
    {
        $this->fkPessoalClassificacaoEnquadramentos->removeElement($fkPessoalClassificacaoEnquadramento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalClassificacaoEnquadramentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ClassificacaoEnquadramento
     */
    public function getFkPessoalClassificacaoEnquadramentos()
    {
        return $this->fkPessoalClassificacaoEnquadramentos;
    }
}
