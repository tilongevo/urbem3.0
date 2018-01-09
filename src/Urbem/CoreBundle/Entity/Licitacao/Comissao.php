<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * Comissao
 */
class Comissao
{
    /**
     * PK
     * @var integer
     */
    private $codComissao;

    /**
     * @var integer
     */
    private $codTipoComissao;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros
     */
    private $fkLicitacaoComissaoMembros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao
     */
    private $fkLicitacaoComissaoLicitacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\TipoComissao
     */
    private $fkLicitacaoTipoComissao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoComissaoMembros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoComissaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codComissao
     *
     * @param integer $codComissao
     * @return Comissao
     */
    public function setCodComissao($codComissao)
    {
        $this->codComissao = $codComissao;
        return $this;
    }

    /**
     * Get codComissao
     *
     * @return integer
     */
    public function getCodComissao()
    {
        return $this->codComissao;
    }

    /**
     * Set codTipoComissao
     *
     * @param integer $codTipoComissao
     * @return Comissao
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return Comissao
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Comissao
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoComissaoMembros
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros
     * @return Comissao
     */
    public function addFkLicitacaoComissaoMembros(\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros)
    {
        if (false === $this->fkLicitacaoComissaoMembros->contains($fkLicitacaoComissaoMembros)) {
            $fkLicitacaoComissaoMembros->setFkLicitacaoComissao($this);
            $this->fkLicitacaoComissaoMembros->add($fkLicitacaoComissaoMembros);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoComissaoMembros
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros
     */
    public function removeFkLicitacaoComissaoMembros(\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros)
    {
        $this->fkLicitacaoComissaoMembros->removeElement($fkLicitacaoComissaoMembros);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoComissaoMembros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros
     */
    public function getFkLicitacaoComissaoMembros()
    {
        return $this->fkLicitacaoComissaoMembros;
    }

    /**
     * OneToMany (owning side)
     * Set fkLicitacaoComissaoMembros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros
     */
    public function setFkLicitacaoComissaoMembros($comissaoMembros)
    {
        return $this->fkLicitacaoComissaoMembros = $comissaoMembros;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoComissaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao $fkLicitacaoComissaoLicitacao
     * @return Comissao
     */
    public function addFkLicitacaoComissaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao $fkLicitacaoComissaoLicitacao)
    {
        if (false === $this->fkLicitacaoComissaoLicitacoes->contains($fkLicitacaoComissaoLicitacao)) {
            $fkLicitacaoComissaoLicitacao->setFkLicitacaoComissao($this);
            $this->fkLicitacaoComissaoLicitacoes->add($fkLicitacaoComissaoLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoComissaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao $fkLicitacaoComissaoLicitacao
     */
    public function removeFkLicitacaoComissaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao $fkLicitacaoComissaoLicitacao)
    {
        $this->fkLicitacaoComissaoLicitacoes->removeElement($fkLicitacaoComissaoLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoComissaoLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao
     */
    public function getFkLicitacaoComissaoLicitacoes()
    {
        return $this->fkLicitacaoComissaoLicitacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoTipoComissao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\TipoComissao $fkLicitacaoTipoComissao
     * @return Comissao
     */
    public function setFkLicitacaoTipoComissao(\Urbem\CoreBundle\Entity\Licitacao\TipoComissao $fkLicitacaoTipoComissao)
    {
        $this->codTipoComissao = $fkLicitacaoTipoComissao->getCodTipoComissao();
        $this->fkLicitacaoTipoComissao = $fkLicitacaoTipoComissao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoTipoComissao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\TipoComissao
     */
    public function getFkLicitacaoTipoComissao()
    {
        return $this->fkLicitacaoTipoComissao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Comissao
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->codComissao) {
            return sprintf(
                "%s - %s",
                $this->codComissao,
                $this->fkNormasNorma
            );
        } else {
            return 'Comissão';
        }
    }
}
