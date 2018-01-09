<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ComissaoMembros
 */
class ComissaoMembros
{
    /**
     * PK
     * @var integer
     */
    private $codComissao;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $codTipoMembro;

    /**
     * @var string
     */
    private $cargo;

    /**
     * @var integer
     */
    private $naturezaCargo = 0;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\MembroExcluido
     */
    private $fkLicitacaoMembroExcluido;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacaoMembros
     */
    private $fkLicitacaoComissaoLicitacaoMembros;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Comissao
     */
    private $fkLicitacaoComissao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\TipoMembro
     */
    private $fkLicitacaoTipoMembro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\NaturezaCargo
     */
    private $fkLicitacaoNaturezaCargo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoComissaoLicitacaoMembros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codComissao
     *
     * @param integer $codComissao
     * @return ComissaoMembros
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ComissaoMembros
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return ComissaoMembros
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
     * Set codTipoMembro
     *
     * @param integer $codTipoMembro
     * @return ComissaoMembros
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
     * Set cargo
     *
     * @param string $cargo
     * @return ComissaoMembros
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set naturezaCargo
     *
     * @param integer $naturezaCargo
     * @return ComissaoMembros
     */
    public function setNaturezaCargo($naturezaCargo)
    {
        $this->naturezaCargo = $naturezaCargo;
        return $this;
    }

    /**
     * Get naturezaCargo
     *
     * @return integer
     */
    public function getNaturezaCargo()
    {
        return $this->naturezaCargo;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoComissaoLicitacaoMembros
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacaoMembros $fkLicitacaoComissaoLicitacaoMembros
     * @return ComissaoMembros
     */
    public function addFkLicitacaoComissaoLicitacaoMembros(\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacaoMembros $fkLicitacaoComissaoLicitacaoMembros)
    {
        if (false === $this->fkLicitacaoComissaoLicitacaoMembros->contains($fkLicitacaoComissaoLicitacaoMembros)) {
            $fkLicitacaoComissaoLicitacaoMembros->setFkLicitacaoComissaoMembros($this);
            $this->fkLicitacaoComissaoLicitacaoMembros->add($fkLicitacaoComissaoLicitacaoMembros);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoComissaoLicitacaoMembros
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacaoMembros $fkLicitacaoComissaoLicitacaoMembros
     */
    public function removeFkLicitacaoComissaoLicitacaoMembros(\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacaoMembros $fkLicitacaoComissaoLicitacaoMembros)
    {
        $this->fkLicitacaoComissaoLicitacaoMembros->removeElement($fkLicitacaoComissaoLicitacaoMembros);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoComissaoLicitacaoMembros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacaoMembros
     */
    public function getFkLicitacaoComissaoLicitacaoMembros()
    {
        return $this->fkLicitacaoComissaoLicitacaoMembros;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoComissao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Comissao $fkLicitacaoComissao
     * @return ComissaoMembros
     */
    public function setFkLicitacaoComissao(\Urbem\CoreBundle\Entity\Licitacao\Comissao $fkLicitacaoComissao)
    {
        $this->codComissao = $fkLicitacaoComissao->getCodComissao();
        $this->fkLicitacaoComissao = $fkLicitacaoComissao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoComissao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Comissao
     */
    public function getFkLicitacaoComissao()
    {
        return $this->fkLicitacaoComissao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ComissaoMembros
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return ComissaoMembros
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
     * ManyToOne (inverse side)
     * Set fkLicitacaoTipoMembro
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\TipoMembro $fkLicitacaoTipoMembro
     * @return ComissaoMembros
     */
    public function setFkLicitacaoTipoMembro(\Urbem\CoreBundle\Entity\Licitacao\TipoMembro $fkLicitacaoTipoMembro)
    {
        $this->codTipoMembro = $fkLicitacaoTipoMembro->getCodTipoMembro();
        $this->fkLicitacaoTipoMembro = $fkLicitacaoTipoMembro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoTipoMembro
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\TipoMembro
     */
    public function getFkLicitacaoTipoMembro()
    {
        return $this->fkLicitacaoTipoMembro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoNaturezaCargo
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\NaturezaCargo $fkLicitacaoNaturezaCargo
     * @return ComissaoMembros
     */
    public function setFkLicitacaoNaturezaCargo(\Urbem\CoreBundle\Entity\Licitacao\NaturezaCargo $fkLicitacaoNaturezaCargo)
    {
        $this->naturezaCargo = $fkLicitacaoNaturezaCargo->getCodigo();
        $this->fkLicitacaoNaturezaCargo = $fkLicitacaoNaturezaCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoNaturezaCargo
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\NaturezaCargo
     */
    public function getFkLicitacaoNaturezaCargo()
    {
        return $this->fkLicitacaoNaturezaCargo;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoMembroExcluido
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\MembroExcluido $fkLicitacaoMembroExcluido
     * @return ComissaoMembros
     */
    public function setFkLicitacaoMembroExcluido(\Urbem\CoreBundle\Entity\Licitacao\MembroExcluido $fkLicitacaoMembroExcluido)
    {
        $fkLicitacaoMembroExcluido->setFkLicitacaoComissaoMembros($this);
        $this->fkLicitacaoMembroExcluido = $fkLicitacaoMembroExcluido;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoMembroExcluido
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\MembroExcluido
     */
    public function getFkLicitacaoMembroExcluido()
    {
        return $this->fkLicitacaoMembroExcluido;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->fkSwCgm) {
            return $this->fkSwCgm->getNomCgm();
        }

        return '';
    }
}
