<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAtributoDinamico
 */
class SwAtributoDinamico
{
    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var boolean
     */
    private $naoNulo = true;

    /**
     * @var string
     */
    private $nomAtributo;

    /**
     * @var string
     */
    private $valorPadrao;

    /**
     * @var string
     */
    private $ajuda;

    /**
     * @var string
     */
    private $mascara;

    /**
     * @var boolean
     */
    private $indexado = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAtributoValorPadrao
     */
    private $fkSwAtributoValorPadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAtributoIntegridade
     */
    private $fkSwAtributoIntegridades;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    private $fkAdministracaoModulo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\TipoAtributo
     */
    private $fkAdministracaoTipoAtributo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwAtributoValorPadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwAtributoIntegridades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return SwAtributoDinamico
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return SwAtributoDinamico
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return SwAtributoDinamico
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
     * Set naoNulo
     *
     * @param boolean $naoNulo
     * @return SwAtributoDinamico
     */
    public function setNaoNulo($naoNulo)
    {
        $this->naoNulo = $naoNulo;
        return $this;
    }

    /**
     * Get naoNulo
     *
     * @return boolean
     */
    public function getNaoNulo()
    {
        return $this->naoNulo;
    }

    /**
     * Set nomAtributo
     *
     * @param string $nomAtributo
     * @return SwAtributoDinamico
     */
    public function setNomAtributo($nomAtributo)
    {
        $this->nomAtributo = $nomAtributo;
        return $this;
    }

    /**
     * Get nomAtributo
     *
     * @return string
     */
    public function getNomAtributo()
    {
        return $this->nomAtributo;
    }

    /**
     * Set valorPadrao
     *
     * @param string $valorPadrao
     * @return SwAtributoDinamico
     */
    public function setValorPadrao($valorPadrao)
    {
        $this->valorPadrao = $valorPadrao;
        return $this;
    }

    /**
     * Get valorPadrao
     *
     * @return string
     */
    public function getValorPadrao()
    {
        return $this->valorPadrao;
    }

    /**
     * Set ajuda
     *
     * @param string $ajuda
     * @return SwAtributoDinamico
     */
    public function setAjuda($ajuda)
    {
        $this->ajuda = $ajuda;
        return $this;
    }

    /**
     * Get ajuda
     *
     * @return string
     */
    public function getAjuda()
    {
        return $this->ajuda;
    }

    /**
     * Set mascara
     *
     * @param string $mascara
     * @return SwAtributoDinamico
     */
    public function setMascara($mascara)
    {
        $this->mascara = $mascara;
        return $this;
    }

    /**
     * Get mascara
     *
     * @return string
     */
    public function getMascara()
    {
        return $this->mascara;
    }

    /**
     * Set indexado
     *
     * @param boolean $indexado
     * @return SwAtributoDinamico
     */
    public function setIndexado($indexado = null)
    {
        $this->indexado = $indexado;
        return $this;
    }

    /**
     * Get indexado
     *
     * @return boolean
     */
    public function getIndexado()
    {
        return $this->indexado;
    }

    /**
     * OneToMany (owning side)
     * Add SwAtributoValorPadrao
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoValorPadrao $fkSwAtributoValorPadrao
     * @return SwAtributoDinamico
     */
    public function addFkSwAtributoValorPadroes(\Urbem\CoreBundle\Entity\SwAtributoValorPadrao $fkSwAtributoValorPadrao)
    {
        if (false === $this->fkSwAtributoValorPadroes->contains($fkSwAtributoValorPadrao)) {
            $fkSwAtributoValorPadrao->setFkSwAtributoDinamico($this);
            $this->fkSwAtributoValorPadroes->add($fkSwAtributoValorPadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAtributoValorPadrao
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoValorPadrao $fkSwAtributoValorPadrao
     */
    public function removeFkSwAtributoValorPadroes(\Urbem\CoreBundle\Entity\SwAtributoValorPadrao $fkSwAtributoValorPadrao)
    {
        $this->fkSwAtributoValorPadroes->removeElement($fkSwAtributoValorPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAtributoValorPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAtributoValorPadrao
     */
    public function getFkSwAtributoValorPadroes()
    {
        return $this->fkSwAtributoValorPadroes;
    }

    /**
     * OneToMany (owning side)
     * Add SwAtributoIntegridade
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoIntegridade $fkSwAtributoIntegridade
     * @return SwAtributoDinamico
     */
    public function addFkSwAtributoIntegridades(\Urbem\CoreBundle\Entity\SwAtributoIntegridade $fkSwAtributoIntegridade)
    {
        if (false === $this->fkSwAtributoIntegridades->contains($fkSwAtributoIntegridade)) {
            $fkSwAtributoIntegridade->setFkSwAtributoDinamico($this);
            $this->fkSwAtributoIntegridades->add($fkSwAtributoIntegridade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAtributoIntegridade
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoIntegridade $fkSwAtributoIntegridade
     */
    public function removeFkSwAtributoIntegridades(\Urbem\CoreBundle\Entity\SwAtributoIntegridade $fkSwAtributoIntegridade)
    {
        $this->fkSwAtributoIntegridades->removeElement($fkSwAtributoIntegridade);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAtributoIntegridades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAtributoIntegridade
     */
    public function getFkSwAtributoIntegridades()
    {
        return $this->fkSwAtributoIntegridades;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return SwAtributoDinamico
     */
    public function setFkAdministracaoModulo(\Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo)
    {
        $this->codModulo = $fkAdministracaoModulo->getCodModulo();
        $this->fkAdministracaoModulo = $fkAdministracaoModulo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModulo
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    public function getFkAdministracaoModulo()
    {
        return $this->fkAdministracaoModulo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoTipoAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\TipoAtributo $fkAdministracaoTipoAtributo
     * @return SwAtributoDinamico
     */
    public function setFkAdministracaoTipoAtributo(\Urbem\CoreBundle\Entity\Administracao\TipoAtributo $fkAdministracaoTipoAtributo)
    {
        $this->codTipo = $fkAdministracaoTipoAtributo->getCodTipo();
        $this->fkAdministracaoTipoAtributo = $fkAdministracaoTipoAtributo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoTipoAtributo
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\TipoAtributo
     */
    public function getFkAdministracaoTipoAtributo()
    {
        return $this->fkAdministracaoTipoAtributo;
    }
}
