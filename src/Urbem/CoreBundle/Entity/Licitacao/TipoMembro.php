<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * TipoMembro
 */
class TipoMembro
{
    /**
     * PK
     * @var integer
     */
    private $codTipoMembro;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros
     */
    private $fkLicitacaoComissaoMembros;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoComissaoMembros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoMembro
     *
     * @param integer $codTipoMembro
     * @return TipoMembro
     */
    public function setCodTipoMembro($codTipoMembro)
    {
        $this->codTipoMembro = $codTipoMembro;
        return $this;
    }

    /**
     * Get codTipoMembro
     *
     * @return integer
     */
    public function getCodTipoMembro()
    {
        return $this->codTipoMembro;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoMembro
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
     * Add LicitacaoComissaoMembros
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros
     * @return TipoMembro
     */
    public function addFkLicitacaoComissaoMembros(\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros)
    {
        if (false === $this->fkLicitacaoComissaoMembros->contains($fkLicitacaoComissaoMembros)) {
            $fkLicitacaoComissaoMembros->setFkLicitacaoTipoMembro($this);
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
}
