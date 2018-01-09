<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * TipoVeiculosPublicidade
 */
class TipoVeiculosPublicidade
{
    /**
     * PK
     * @var integer
     */
    private $codTipoVeiculosPublicidade;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    private $fkLicitacaoVeiculosPublicidades;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoVeiculosPublicidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoVeiculosPublicidade
     *
     * @param integer $codTipoVeiculosPublicidade
     * @return TipoVeiculosPublicidade
     */
    public function setCodTipoVeiculosPublicidade($codTipoVeiculosPublicidade)
    {
        $this->codTipoVeiculosPublicidade = $codTipoVeiculosPublicidade;
        return $this;
    }

    /**
     * Get codTipoVeiculosPublicidade
     *
     * @return integer
     */
    public function getCodTipoVeiculosPublicidade()
    {
        return $this->codTipoVeiculosPublicidade;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoVeiculosPublicidade
     */
    public function setDescricao($descricao = null)
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
     * Add LicitacaoVeiculosPublicidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade
     * @return TipoVeiculosPublicidade
     */
    public function addFkLicitacaoVeiculosPublicidades(\Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade)
    {
        if (false === $this->fkLicitacaoVeiculosPublicidades->contains($fkLicitacaoVeiculosPublicidade)) {
            $fkLicitacaoVeiculosPublicidade->setFkLicitacaoTipoVeiculosPublicidade($this);
            $this->fkLicitacaoVeiculosPublicidades->add($fkLicitacaoVeiculosPublicidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoVeiculosPublicidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade
     */
    public function removeFkLicitacaoVeiculosPublicidades(\Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade)
    {
        $this->fkLicitacaoVeiculosPublicidades->removeElement($fkLicitacaoVeiculosPublicidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoVeiculosPublicidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    public function getFkLicitacaoVeiculosPublicidades()
    {
        return $this->fkLicitacaoVeiculosPublicidades;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codTipoVeiculosPublicidade, $this->descricao);
    }
}
