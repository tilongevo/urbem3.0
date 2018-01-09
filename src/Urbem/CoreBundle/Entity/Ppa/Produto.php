<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * Produto
 */
class Produto
{
    /**
     * PK
     * @var integer
     */
    private $codProduto;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $especificacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    private $fkPpaAcaoDados;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPpaAcaoDados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codProduto
     *
     * @param integer $codProduto
     * @return Produto
     */
    public function setCodProduto($codProduto)
    {
        $this->codProduto = $codProduto;
        return $this;
    }

    /**
     * Get codProduto
     *
     * @return integer
     */
    public function getCodProduto()
    {
        return $this->codProduto;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Produto
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
     * Set especificacao
     *
     * @param string $especificacao
     * @return Produto
     */
    public function setEspecificacao($especificacao)
    {
        $this->especificacao = $especificacao;
        return $this;
    }

    /**
     * Get especificacao
     *
     * @return string
     */
    public function getEspecificacao()
    {
        return $this->especificacao;
    }

    /**
     * OneToMany (owning side)
     * Add PpaAcaoDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados
     * @return Produto
     */
    public function addFkPpaAcaoDados(\Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados)
    {
        if (false === $this->fkPpaAcaoDados->contains($fkPpaAcaoDados)) {
            $fkPpaAcaoDados->setFkPpaProduto($this);
            $this->fkPpaAcaoDados->add($fkPpaAcaoDados);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaAcaoDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados
     */
    public function removeFkPpaAcaoDados(\Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados)
    {
        $this->fkPpaAcaoDados->removeElement($fkPpaAcaoDados);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaAcaoDados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    public function getFkPpaAcaoDados()
    {
        return $this->fkPpaAcaoDados;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codProduto, $this->descricao);
    }
}
