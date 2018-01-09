<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * TipoMovimentacao
 */
class TipoMovimentacao
{
    /**
     * PK
     * @var integer
     */
    private $codTipoMovimentacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\TcepeConfiguracaoRelacionaHistorico
     */
    private $fkPessoalTcepeConfiguracaoRelacionaHistoricos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalTcepeConfiguracaoRelacionaHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoMovimentacao
     *
     * @param integer $codTipoMovimentacao
     * @return TipoMovimentacao
     */
    public function setCodTipoMovimentacao($codTipoMovimentacao)
    {
        $this->codTipoMovimentacao = $codTipoMovimentacao;
        return $this;
    }

    /**
     * Get codTipoMovimentacao
     *
     * @return integer
     */
    public function getCodTipoMovimentacao()
    {
        return $this->codTipoMovimentacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoMovimentacao
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
     * Add PessoalTcepeConfiguracaoRelacionaHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TcepeConfiguracaoRelacionaHistorico $fkPessoalTcepeConfiguracaoRelacionaHistorico
     * @return TipoMovimentacao
     */
    public function addFkPessoalTcepeConfiguracaoRelacionaHistoricos(\Urbem\CoreBundle\Entity\Pessoal\TcepeConfiguracaoRelacionaHistorico $fkPessoalTcepeConfiguracaoRelacionaHistorico)
    {
        if (false === $this->fkPessoalTcepeConfiguracaoRelacionaHistoricos->contains($fkPessoalTcepeConfiguracaoRelacionaHistorico)) {
            $fkPessoalTcepeConfiguracaoRelacionaHistorico->setFkTcepeTipoMovimentacao($this);
            $this->fkPessoalTcepeConfiguracaoRelacionaHistoricos->add($fkPessoalTcepeConfiguracaoRelacionaHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalTcepeConfiguracaoRelacionaHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TcepeConfiguracaoRelacionaHistorico $fkPessoalTcepeConfiguracaoRelacionaHistorico
     */
    public function removeFkPessoalTcepeConfiguracaoRelacionaHistoricos(\Urbem\CoreBundle\Entity\Pessoal\TcepeConfiguracaoRelacionaHistorico $fkPessoalTcepeConfiguracaoRelacionaHistorico)
    {
        $this->fkPessoalTcepeConfiguracaoRelacionaHistoricos->removeElement($fkPessoalTcepeConfiguracaoRelacionaHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalTcepeConfiguracaoRelacionaHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\TcepeConfiguracaoRelacionaHistorico
     */
    public function getFkPessoalTcepeConfiguracaoRelacionaHistoricos()
    {
        return $this->fkPessoalTcepeConfiguracaoRelacionaHistoricos;
    }
}
