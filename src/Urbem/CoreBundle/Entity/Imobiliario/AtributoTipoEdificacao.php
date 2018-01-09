<?php

namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * AtributoTipoEdificacao
 */
class AtributoTipoEdificacao
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor
     */
    private $fkImobiliarioAtributoTipoEdificacaoValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao
     */
    private $fkImobiliarioTipoEdificacao;

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
        $this->fkImobiliarioAtributoTipoEdificacaoValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return AtributoTipoEdificacao
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
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoTipoEdificacao
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
     * @return AtributoTipoEdificacao
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
     * @return AtributoTipoEdificacao
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
     * @return AtributoTipoEdificacao
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
     * Add ImobiliarioAtributoTipoEdificacaoValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor $fkImobiliarioAtributoTipoEdificacaoValor
     * @return AtributoTipoEdificacao
     */
    public function addFkImobiliarioAtributoTipoEdificacaoValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor $fkImobiliarioAtributoTipoEdificacaoValor)
    {
        if (false === $this->fkImobiliarioAtributoTipoEdificacaoValores->contains($fkImobiliarioAtributoTipoEdificacaoValor)) {
            $fkImobiliarioAtributoTipoEdificacaoValor->setFkImobiliarioAtributoTipoEdificacao($this);
            $this->fkImobiliarioAtributoTipoEdificacaoValores->add($fkImobiliarioAtributoTipoEdificacaoValor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoTipoEdificacaoValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor $fkImobiliarioAtributoTipoEdificacaoValor
     */
    public function removeFkImobiliarioAtributoTipoEdificacaoValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor $fkImobiliarioAtributoTipoEdificacaoValor)
    {
        $this->fkImobiliarioAtributoTipoEdificacaoValores->removeElement($fkImobiliarioAtributoTipoEdificacaoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoTipoEdificacaoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor
     */
    public function getFkImobiliarioAtributoTipoEdificacaoValores()
    {
        return $this->fkImobiliarioAtributoTipoEdificacaoValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioTipoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao $fkImobiliarioTipoEdificacao
     * @return AtributoTipoEdificacao
     */
    public function setFkImobiliarioTipoEdificacao(\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao $fkImobiliarioTipoEdificacao)
    {
        $this->codTipo = $fkImobiliarioTipoEdificacao->getCodTipo();
        $this->fkImobiliarioTipoEdificacao = $fkImobiliarioTipoEdificacao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioTipoEdificacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao
     */
    public function getFkImobiliarioTipoEdificacao()
    {
        return $this->fkImobiliarioTipoEdificacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoTipoEdificacao
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
        return (string) $this->codAtributo;
    }
}
