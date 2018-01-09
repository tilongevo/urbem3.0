<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * TipoChamadaPublica
 */
class TipoChamadaPublica
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoChamadaPublica
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoChamadaPublica
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
     * @return TipoChamadaPublica
     */
    public function addFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        if (false === $this->fkLicitacaoLicitacoes->contains($fkLicitacaoLicitacao)) {
            $fkLicitacaoLicitacao->setFkLicitacaoTipoChamadaPublica($this);
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
        return $this->descricao;
    }
}
