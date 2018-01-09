<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * AtributoNivel
 */
class AtributoNivel
{
    /**
     * PK
     * @var integer
     */
    private $codNivel;

    /**
     * PK
     * @var integer
     */
    private $codVigencia;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor
     */
    private $fkImobiliarioAtributoNivelValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Nivel
     */
    private $fkImobiliarioNivel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioAtributoNivelValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNivel
     *
     * @param integer $codNivel
     * @return AtributoNivel
     */
    public function setCodNivel($codNivel)
    {
        $this->codNivel = $codNivel;
        return $this;
    }

    /**
     * Get codNivel
     *
     * @return integer
     */
    public function getCodNivel()
    {
        return $this->codNivel;
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return AtributoNivel
     */
    public function setCodVigencia($codVigencia)
    {
        $this->codVigencia = $codVigencia;
        return $this;
    }

    /**
     * Get codVigencia
     *
     * @return integer
     */
    public function getCodVigencia()
    {
        return $this->codVigencia;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoNivel
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
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoNivel
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoNivel
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
     * Set ativo
     *
     * @param boolean $ativo
     * @return AtributoNivel
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
     * Add ImobiliarioAtributoNivelValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor $fkImobiliarioAtributoNivelValor
     * @return AtributoNivel
     */
    public function addFkImobiliarioAtributoNivelValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor $fkImobiliarioAtributoNivelValor)
    {
        if (false === $this->fkImobiliarioAtributoNivelValores->contains($fkImobiliarioAtributoNivelValor)) {
            $fkImobiliarioAtributoNivelValor->setFkImobiliarioAtributoNivel($this);
            $this->fkImobiliarioAtributoNivelValores->add($fkImobiliarioAtributoNivelValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoNivelValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor $fkImobiliarioAtributoNivelValor
     */
    public function removeFkImobiliarioAtributoNivelValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor $fkImobiliarioAtributoNivelValor)
    {
        $this->fkImobiliarioAtributoNivelValores->removeElement($fkImobiliarioAtributoNivelValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoNivelValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor
     */
    public function getFkImobiliarioAtributoNivelValores()
    {
        return $this->fkImobiliarioAtributoNivelValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioNivel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Nivel $fkImobiliarioNivel
     * @return AtributoNivel
     */
    public function setFkImobiliarioNivel(\Urbem\CoreBundle\Entity\Imobiliario\Nivel $fkImobiliarioNivel)
    {
        $this->codNivel = $fkImobiliarioNivel->getCodNivel();
        $this->codVigencia = $fkImobiliarioNivel->getCodVigencia();
        $this->fkImobiliarioNivel = $fkImobiliarioNivel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioNivel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Nivel
     */
    public function getFkImobiliarioNivel()
    {
        return $this->fkImobiliarioNivel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoNivel
     */
    public function setFkAdministracaoAtributoDinamico(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        $this->codModulo = $fkAdministracaoAtributoDinamico->getCodModulo();
        $this->codCadastro = $fkAdministracaoAtributoDinamico->getCodCadastro();
        $this->codAtributo = $fkAdministracaoAtributoDinamico->getCodAtributo();
        $this->fkAdministracaoAtributoDinamico = $fkAdministracaoAtributoDinamico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAtributoDinamico
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    public function getFkAdministracaoAtributoDinamico()
    {
        return $this->fkAdministracaoAtributoDinamico;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkAdministracaoAtributoDinamico;
    }
}
