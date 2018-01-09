<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * CategoriaEmpenho
 */
class CategoriaEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codCategoria;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    private $fkEmpenhoAutorizacaoEmpenhos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoAutorizacaoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return CategoriaEmpenho
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return CategoriaEmpenho
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
     * Add EmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return CategoriaEmpenho
     */
    public function addFkEmpenhoEmpenhos(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        if (false === $this->fkEmpenhoEmpenhos->contains($fkEmpenhoEmpenho)) {
            $fkEmpenhoEmpenho->setFkEmpenhoCategoriaEmpenho($this);
            $this->fkEmpenhoEmpenhos->add($fkEmpenhoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     */
    public function removeFkEmpenhoEmpenhos(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->fkEmpenhoEmpenhos->removeElement($fkEmpenhoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenhos()
    {
        return $this->fkEmpenhoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho
     * @return CategoriaEmpenho
     */
    public function addFkEmpenhoAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho)
    {
        if (false === $this->fkEmpenhoAutorizacaoEmpenhos->contains($fkEmpenhoAutorizacaoEmpenho)) {
            $fkEmpenhoAutorizacaoEmpenho->setFkEmpenhoCategoriaEmpenho($this);
            $this->fkEmpenhoAutorizacaoEmpenhos->add($fkEmpenhoAutorizacaoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho
     */
    public function removeFkEmpenhoAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho)
    {
        $this->fkEmpenhoAutorizacaoEmpenhos->removeElement($fkEmpenhoAutorizacaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoAutorizacaoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    public function getFkEmpenhoAutorizacaoEmpenhos()
    {
        return $this->fkEmpenhoAutorizacaoEmpenhos;
    }
}
