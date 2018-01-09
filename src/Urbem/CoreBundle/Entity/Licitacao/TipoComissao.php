<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * TipoComissao
 */
class TipoComissao
{
    /**
     * PK
     * @var integer
     */
    private $codTipoComissao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Comissao
     */
    private $fkLicitacaoComissoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoComissoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoComissao
     *
     * @param integer $codTipoComissao
     * @return TipoComissao
     */
    public function setCodTipoComissao($codTipoComissao)
    {
        $this->codTipoComissao = $codTipoComissao;
        return $this;
    }

    /**
     * Get codTipoComissao
     *
     * @return integer
     */
    public function getCodTipoComissao()
    {
        return $this->codTipoComissao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoComissao
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
     * Add LicitacaoComissao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Comissao $fkLicitacaoComissao
     * @return TipoComissao
     */
    public function addFkLicitacaoComissoes(\Urbem\CoreBundle\Entity\Licitacao\Comissao $fkLicitacaoComissao)
    {
        if (false === $this->fkLicitacaoComissoes->contains($fkLicitacaoComissao)) {
            $fkLicitacaoComissao->setFkLicitacaoTipoComissao($this);
            $this->fkLicitacaoComissoes->add($fkLicitacaoComissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoComissao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Comissao $fkLicitacaoComissao
     */
    public function removeFkLicitacaoComissoes(\Urbem\CoreBundle\Entity\Licitacao\Comissao $fkLicitacaoComissao)
    {
        $this->fkLicitacaoComissoes->removeElement($fkLicitacaoComissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoComissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Comissao
     */
    public function getFkLicitacaoComissoes()
    {
        return $this->fkLicitacaoComissoes;
    }
}
