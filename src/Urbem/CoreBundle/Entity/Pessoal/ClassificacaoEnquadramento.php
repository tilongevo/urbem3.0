<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ClassificacaoEnquadramento
 */
class ClassificacaoEnquadramento
{
    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * PK
     * @var integer
     */
    private $codEnquadramento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Aposentadoria
     */
    private $fkPessoalAposentadorias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Classificacao
     */
    private $fkPessoalClassificacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Enquadramento
     */
    private $fkPessoalEnquadramento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAposentadorias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return ClassificacaoEnquadramento
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set codEnquadramento
     *
     * @param integer $codEnquadramento
     * @return ClassificacaoEnquadramento
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
     * OneToMany (owning side)
     * Add PessoalAposentadoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Aposentadoria $fkPessoalAposentadoria
     * @return ClassificacaoEnquadramento
     */
    public function addFkPessoalAposentadorias(\Urbem\CoreBundle\Entity\Pessoal\Aposentadoria $fkPessoalAposentadoria)
    {
        if (false === $this->fkPessoalAposentadorias->contains($fkPessoalAposentadoria)) {
            $fkPessoalAposentadoria->setFkPessoalClassificacaoEnquadramento($this);
            $this->fkPessoalAposentadorias->add($fkPessoalAposentadoria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAposentadoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Aposentadoria $fkPessoalAposentadoria
     */
    public function removeFkPessoalAposentadorias(\Urbem\CoreBundle\Entity\Pessoal\Aposentadoria $fkPessoalAposentadoria)
    {
        $this->fkPessoalAposentadorias->removeElement($fkPessoalAposentadoria);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAposentadorias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Aposentadoria
     */
    public function getFkPessoalAposentadorias()
    {
        return $this->fkPessoalAposentadorias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Classificacao $fkPessoalClassificacao
     * @return ClassificacaoEnquadramento
     */
    public function setFkPessoalClassificacao(\Urbem\CoreBundle\Entity\Pessoal\Classificacao $fkPessoalClassificacao)
    {
        $this->codClassificacao = $fkPessoalClassificacao->getCodClassificacao();
        $this->fkPessoalClassificacao = $fkPessoalClassificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalClassificacao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Classificacao
     */
    public function getFkPessoalClassificacao()
    {
        return $this->fkPessoalClassificacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalEnquadramento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Enquadramento $fkPessoalEnquadramento
     * @return ClassificacaoEnquadramento
     */
    public function setFkPessoalEnquadramento(\Urbem\CoreBundle\Entity\Pessoal\Enquadramento $fkPessoalEnquadramento)
    {
        $this->codEnquadramento = $fkPessoalEnquadramento->getCodEnquadramento();
        $this->fkPessoalEnquadramento = $fkPessoalEnquadramento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalEnquadramento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Enquadramento
     */
    public function getFkPessoalEnquadramento()
    {
        return $this->fkPessoalEnquadramento;
    }
}
