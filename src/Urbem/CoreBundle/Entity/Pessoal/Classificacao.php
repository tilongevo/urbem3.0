<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Classificacao
 */
class Classificacao
{
    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $nomeClassificacao;

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

    public function __toString()
    {
        return (string) $this->getDescricao();
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return Classificacao
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
     * Set descricao
     *
     * @param string $descricao
     * @return Classificacao
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
     * Set nomeClassificacao
     *
     * @param string $nomeClassificacao
     * @return Classificacao
     */
    public function setNomeClassificacao($nomeClassificacao)
    {
        $this->nomeClassificacao = $nomeClassificacao;
        return $this;
    }

    /**
     * Get nomeClassificacao
     *
     * @return string
     */
    public function getNomeClassificacao()
    {
        return $this->nomeClassificacao;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalClassificacaoEnquadramento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ClassificacaoEnquadramento $fkPessoalClassificacaoEnquadramento
     * @return Classificacao
     */
    public function addFkPessoalClassificacaoEnquadramentos(\Urbem\CoreBundle\Entity\Pessoal\ClassificacaoEnquadramento $fkPessoalClassificacaoEnquadramento)
    {
        if (false === $this->fkPessoalClassificacaoEnquadramentos->contains($fkPessoalClassificacaoEnquadramento)) {
            $fkPessoalClassificacaoEnquadramento->setFkPessoalClassificacao($this);
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
