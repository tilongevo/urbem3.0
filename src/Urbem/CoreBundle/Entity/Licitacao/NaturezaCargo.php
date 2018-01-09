<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * NaturezaCargo
 */
class NaturezaCargo
{
    /**
     * PK
     * @var integer
     */
    private $codigo;

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
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\MembroAdicional
     */
    private $fkLicitacaoMembroAdicionais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoComissaoMembros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoMembroAdicionais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     * @return NaturezaCargo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return NaturezaCargo
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
     * Add LicitacaoComissaoMembros
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros
     * @return NaturezaCargo
     */
    public function addFkLicitacaoComissaoMembros(\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros)
    {
        if (false === $this->fkLicitacaoComissaoMembros->contains($fkLicitacaoComissaoMembros)) {
            $fkLicitacaoComissaoMembros->setFkLicitacaoNaturezaCargo($this);
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
     * Add LicitacaoMembroAdicional
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\MembroAdicional $fkLicitacaoMembroAdicional
     * @return NaturezaCargo
     */
    public function addFkLicitacaoMembroAdicionais(\Urbem\CoreBundle\Entity\Licitacao\MembroAdicional $fkLicitacaoMembroAdicional)
    {
        if (false === $this->fkLicitacaoMembroAdicionais->contains($fkLicitacaoMembroAdicional)) {
            $fkLicitacaoMembroAdicional->setFkLicitacaoNaturezaCargo($this);
            $this->fkLicitacaoMembroAdicionais->add($fkLicitacaoMembroAdicional);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoMembroAdicional
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\MembroAdicional $fkLicitacaoMembroAdicional
     */
    public function removeFkLicitacaoMembroAdicionais(\Urbem\CoreBundle\Entity\Licitacao\MembroAdicional $fkLicitacaoMembroAdicional)
    {
        $this->fkLicitacaoMembroAdicionais->removeElement($fkLicitacaoMembroAdicional);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoMembroAdicionais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\MembroAdicional
     */
    public function getFkLicitacaoMembroAdicionais()
    {
        return $this->fkLicitacaoMembroAdicionais;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->descricao}";
    }
}
