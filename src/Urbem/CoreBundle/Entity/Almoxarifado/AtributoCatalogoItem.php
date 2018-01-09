<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * AtributoCatalogoItem
 */
class AtributoCatalogoItem
{
    /**
     * PK
     * @var integer
     */
    private $codItem;

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
    private $ativo = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor
     */
    private $fkAlmoxarifadoAtributoEstoqueMaterialValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoInventarioItemValor
     */
    private $fkAlmoxarifadoAtributoInventarioItemValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItemValor
     */
    private $fkAlmoxarifadoAtributoPedidoTransferenciaItemValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItem;

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
        $this->fkAlmoxarifadoAtributoEstoqueMaterialValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoAtributoInventarioItemValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoAtributoPedidoTransferenciaItemValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return AtributoCatalogoItem
     */
    public function setCodItem($codItem)
    {
        $this->codItem = $codItem;
        return $this;
    }

    /**
     * Get codItem
     *
     * @return integer
     */
    public function getCodItem()
    {
        return $this->codItem;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoCatalogoItem
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
     * @return AtributoCatalogoItem
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
     * @return AtributoCatalogoItem
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
     * @return AtributoCatalogoItem
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
     * Add AlmoxarifadoAtributoEstoqueMaterialValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor $fkAlmoxarifadoAtributoEstoqueMaterialValor
     * @return AtributoCatalogoItem
     */
    public function addFkAlmoxarifadoAtributoEstoqueMaterialValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor $fkAlmoxarifadoAtributoEstoqueMaterialValor)
    {
        if (false === $this->fkAlmoxarifadoAtributoEstoqueMaterialValores->contains($fkAlmoxarifadoAtributoEstoqueMaterialValor)) {
            $fkAlmoxarifadoAtributoEstoqueMaterialValor->setFkAlmoxarifadoAtributoCatalogoItem($this);
            $this->fkAlmoxarifadoAtributoEstoqueMaterialValores->add($fkAlmoxarifadoAtributoEstoqueMaterialValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoEstoqueMaterialValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor $fkAlmoxarifadoAtributoEstoqueMaterialValor
     */
    public function removeFkAlmoxarifadoAtributoEstoqueMaterialValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor $fkAlmoxarifadoAtributoEstoqueMaterialValor)
    {
        $this->fkAlmoxarifadoAtributoEstoqueMaterialValores->removeElement($fkAlmoxarifadoAtributoEstoqueMaterialValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoEstoqueMaterialValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor
     */
    public function getFkAlmoxarifadoAtributoEstoqueMaterialValores()
    {
        return $this->fkAlmoxarifadoAtributoEstoqueMaterialValores;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoInventarioItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoInventarioItemValor $fkAlmoxarifadoAtributoInventarioItemValor
     * @return AtributoCatalogoItem
     */
    public function addFkAlmoxarifadoAtributoInventarioItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoInventarioItemValor $fkAlmoxarifadoAtributoInventarioItemValor)
    {
        if (false === $this->fkAlmoxarifadoAtributoInventarioItemValores->contains($fkAlmoxarifadoAtributoInventarioItemValor)) {
            $fkAlmoxarifadoAtributoInventarioItemValor->setFkAlmoxarifadoAtributoCatalogoItem($this);
            $this->fkAlmoxarifadoAtributoInventarioItemValores->add($fkAlmoxarifadoAtributoInventarioItemValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoInventarioItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoInventarioItemValor $fkAlmoxarifadoAtributoInventarioItemValor
     */
    public function removeFkAlmoxarifadoAtributoInventarioItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoInventarioItemValor $fkAlmoxarifadoAtributoInventarioItemValor)
    {
        $this->fkAlmoxarifadoAtributoInventarioItemValores->removeElement($fkAlmoxarifadoAtributoInventarioItemValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoInventarioItemValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoInventarioItemValor
     */
    public function getFkAlmoxarifadoAtributoInventarioItemValores()
    {
        return $this->fkAlmoxarifadoAtributoInventarioItemValores;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoPedidoTransferenciaItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItemValor $fkAlmoxarifadoAtributoPedidoTransferenciaItemValor
     * @return AtributoCatalogoItem
     */
    public function addFkAlmoxarifadoAtributoPedidoTransferenciaItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItemValor $fkAlmoxarifadoAtributoPedidoTransferenciaItemValor)
    {
        if (false === $this->fkAlmoxarifadoAtributoPedidoTransferenciaItemValores->contains($fkAlmoxarifadoAtributoPedidoTransferenciaItemValor)) {
            $fkAlmoxarifadoAtributoPedidoTransferenciaItemValor->setFkAlmoxarifadoAtributoCatalogoItem($this);
            $this->fkAlmoxarifadoAtributoPedidoTransferenciaItemValores->add($fkAlmoxarifadoAtributoPedidoTransferenciaItemValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoPedidoTransferenciaItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItemValor $fkAlmoxarifadoAtributoPedidoTransferenciaItemValor
     */
    public function removeFkAlmoxarifadoAtributoPedidoTransferenciaItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItemValor $fkAlmoxarifadoAtributoPedidoTransferenciaItemValor)
    {
        $this->fkAlmoxarifadoAtributoPedidoTransferenciaItemValores->removeElement($fkAlmoxarifadoAtributoPedidoTransferenciaItemValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoPedidoTransferenciaItemValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItemValor
     */
    public function getFkAlmoxarifadoAtributoPedidoTransferenciaItemValores()
    {
        return $this->fkAlmoxarifadoAtributoPedidoTransferenciaItemValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return AtributoCatalogoItem
     */
    public function setFkAlmoxarifadoCatalogoItem(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem)
    {
        $this->codItem = $fkAlmoxarifadoCatalogoItem->getCodItem();
        $this->fkAlmoxarifadoCatalogoItem = $fkAlmoxarifadoCatalogoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    public function getFkAlmoxarifadoCatalogoItem()
    {
        return $this->fkAlmoxarifadoCatalogoItem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoCatalogoItem
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
}
