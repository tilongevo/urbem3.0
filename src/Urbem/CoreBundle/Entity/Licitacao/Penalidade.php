<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * Penalidade
 */
class Penalidade
{
    /**
     * PK
     * @var integer
     */
    private $codPenalidade;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao
     */
    private $fkLicitacaoPenalidadesCertificacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoPenalidadesCertificacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPenalidade
     *
     * @param integer $codPenalidade
     * @return Penalidade
     */
    public function setCodPenalidade($codPenalidade)
    {
        $this->codPenalidade = $codPenalidade;
        return $this;
    }

    /**
     * Get codPenalidade
     *
     * @return integer
     */
    public function getCodPenalidade()
    {
        return $this->codPenalidade;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Penalidade
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
     * Add LicitacaoPenalidadesCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao $fkLicitacaoPenalidadesCertificacao
     * @return Penalidade
     */
    public function addFkLicitacaoPenalidadesCertificacoes(\Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao $fkLicitacaoPenalidadesCertificacao)
    {
        if (false === $this->fkLicitacaoPenalidadesCertificacoes->contains($fkLicitacaoPenalidadesCertificacao)) {
            $fkLicitacaoPenalidadesCertificacao->setFkLicitacaoPenalidade($this);
            $this->fkLicitacaoPenalidadesCertificacoes->add($fkLicitacaoPenalidadesCertificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPenalidadesCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao $fkLicitacaoPenalidadesCertificacao
     */
    public function removeFkLicitacaoPenalidadesCertificacoes(\Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao $fkLicitacaoPenalidadesCertificacao)
    {
        $this->fkLicitacaoPenalidadesCertificacoes->removeElement($fkLicitacaoPenalidadesCertificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPenalidadesCertificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao
     */
    public function getFkLicitacaoPenalidadesCertificacoes()
    {
        return $this->fkLicitacaoPenalidadesCertificacoes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->codPenalidade.' - '.$this->descricao;
    }
}
