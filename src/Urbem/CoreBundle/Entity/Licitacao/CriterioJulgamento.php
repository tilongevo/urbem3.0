<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * CriterioJulgamento
 */
class CriterioJulgamento
{
    /**
     * PK
     * @var integer
     */
    private $codCriterio;

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
     * Set codCriterio
     *
     * @param integer $codCriterio
     * @return CriterioJulgamento
     */
    public function setCodCriterio($codCriterio)
    {
        $this->codCriterio = $codCriterio;
        return $this;
    }

    /**
     * Get codCriterio
     *
     * @return integer
     */
    public function getCodCriterio()
    {
        return $this->codCriterio;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return CriterioJulgamento
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
     * Add LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return CriterioJulgamento
     */
    public function addFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        if (false === $this->fkLicitacaoLicitacoes->contains($fkLicitacaoLicitacao)) {
            $fkLicitacaoLicitacao->setFkLicitacaoCriterioJulgamento($this);
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

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codCriterio, $this->descricao);
    }


}
