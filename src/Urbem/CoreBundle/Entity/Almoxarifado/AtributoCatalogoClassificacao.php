<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * AtributoCatalogoClassificacao
 */
class AtributoCatalogoClassificacao
{
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
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * PK
     * @var integer
     */
    private $codCatalogo;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacaoItemValor
     */
    private $fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao
     */
    private $fkAlmoxarifadoCatalogoClassificacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoCatalogoClassificacao
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
     * @return AtributoCatalogoClassificacao
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
     * @return AtributoCatalogoClassificacao
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
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return AtributoCatalogoClassificacao
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set codCatalogo
     *
     * @param integer $codCatalogo
     * @return AtributoCatalogoClassificacao
     */
    public function setCodCatalogo($codCatalogo)
    {
        $this->codCatalogo = $codCatalogo;
        return $this;
    }

    /**
     * Get codCatalogo
     *
     * @return integer
     */
    public function getCodCatalogo()
    {
        return $this->codCatalogo;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return AtributoCatalogoClassificacao
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
     * Add AlmoxarifadoAtributoCatalogoClassificacaoItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacaoItemValor $fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor
     * @return AtributoCatalogoClassificacao
     */
    public function addFkAlmoxarifadoAtributoCatalogoClassificacaoItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacaoItemValor $fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor)
    {
        if (false === $this->fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores->contains($fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor)) {
            $fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor->setFkAlmoxarifadoAtributoCatalogoClassificacao($this);
            $this->fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores->add($fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoCatalogoClassificacaoItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacaoItemValor $fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor
     */
    public function removeFkAlmoxarifadoAtributoCatalogoClassificacaoItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacaoItemValor $fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor)
    {
        $this->fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores->removeElement($fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacaoItemValor
     */
    public function getFkAlmoxarifadoAtributoCatalogoClassificacaoItemValores()
    {
        return $this->fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoCatalogoClassificacao
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
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao $fkAlmoxarifadoCatalogoClassificacao
     * @return AtributoCatalogoClassificacao
     */
    public function setFkAlmoxarifadoCatalogoClassificacao(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao $fkAlmoxarifadoCatalogoClassificacao)
    {
        $this->codClassificacao = $fkAlmoxarifadoCatalogoClassificacao->getCodClassificacao();
        $this->codCatalogo = $fkAlmoxarifadoCatalogoClassificacao->getCodCatalogo();
        $this->fkAlmoxarifadoCatalogoClassificacao = $fkAlmoxarifadoCatalogoClassificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoClassificacao
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao
     */
    public function getFkAlmoxarifadoCatalogoClassificacao()
    {
        return $this->fkAlmoxarifadoCatalogoClassificacao;
    }
}
