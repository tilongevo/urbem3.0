<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * RegimeExecucaoObras
 */
class RegimeExecucaoObras
{
    /**
     * PK
     * @var integer
     */
    private $codRegime;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codRegime
     *
     * @param integer $codRegime
     * @return RegimeExecucaoObras
     */
    public function setCodRegime($codRegime)
    {
        $this->codRegime = $codRegime;
        return $this;
    }

    /**
     * Get codRegime
     *
     * @return integer
     */
    public function getCodRegime()
    {
        return $this->codRegime;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return RegimeExecucaoObras
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
     * Add LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return RegimeExecucaoObras
     */
    public function addFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        if (false === $this->fkLicitacaoLicitacoes->contains($fkLicitacaoLicitacao)) {
            $fkLicitacaoLicitacao->setFkComprasRegimeExecucaoObras($this);
            $this->fkLicitacaoLicitacoes->add($fkLicitacaoLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     */
    public function removeFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->fkLicitacaoLicitacoes->removeElement($fkLicitacaoLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacoes()
    {
        return $this->fkLicitacaoLicitacoes;
    }
}
