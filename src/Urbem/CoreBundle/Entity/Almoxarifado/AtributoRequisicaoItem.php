<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * AtributoRequisicaoItem
 */
class AtributoRequisicaoItem
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * PK
     * @var integer
     */
    private $codRequisicao;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $codMarca;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * PK
     * @var integer
     */
    private $codSequencial;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItemValor
     */
    private $fkAlmoxarifadoAtributoRequisicaoItemValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem
     */
    private $fkAlmoxarifadoRequisicaoItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoAtributoRequisicaoItemValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AtributoRequisicaoItem
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return AtributoRequisicaoItem
     */
    public function setCodAlmoxarifado($codAlmoxarifado)
    {
        $this->codAlmoxarifado = $codAlmoxarifado;
        return $this;
    }

    /**
     * Get codAlmoxarifado
     *
     * @return integer
     */
    public function getCodAlmoxarifado()
    {
        return $this->codAlmoxarifado;
    }

    /**
     * Set codRequisicao
     *
     * @param integer $codRequisicao
     * @return AtributoRequisicaoItem
     */
    public function setCodRequisicao($codRequisicao)
    {
        $this->codRequisicao = $codRequisicao;
        return $this;
    }

    /**
     * Get codRequisicao
     *
     * @return integer
     */
    public function getCodRequisicao()
    {
        return $this->codRequisicao;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return AtributoRequisicaoItem
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
     * Set codMarca
     *
     * @param integer $codMarca
     * @return AtributoRequisicaoItem
     */
    public function setCodMarca($codMarca)
    {
        $this->codMarca = $codMarca;
        return $this;
    }

    /**
     * Get codMarca
     *
     * @return integer
     */
    public function getCodMarca()
    {
        return $this->codMarca;
    }

    /**
     * Set codCentro
     *
     * @param integer $codCentro
     * @return AtributoRequisicaoItem
     */
    public function setCodCentro($codCentro)
    {
        $this->codCentro = $codCentro;
        return $this;
    }

    /**
     * Get codCentro
     *
     * @return integer
     */
    public function getCodCentro()
    {
        return $this->codCentro;
    }

    /**
     * Set codSequencial
     *
     * @param integer $codSequencial
     * @return AtributoRequisicaoItem
     */
    public function setCodSequencial($codSequencial)
    {
        $this->codSequencial = $codSequencial;
        return $this;
    }

    /**
     * Get codSequencial
     *
     * @return integer
     */
    public function getCodSequencial()
    {
        return $this->codSequencial;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return AtributoRequisicaoItem
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoRequisicaoItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItemValor $fkAlmoxarifadoAtributoRequisicaoItemValor
     * @return AtributoRequisicaoItem
     */
    public function addFkAlmoxarifadoAtributoRequisicaoItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItemValor $fkAlmoxarifadoAtributoRequisicaoItemValor)
    {
        if (false === $this->fkAlmoxarifadoAtributoRequisicaoItemValores->contains($fkAlmoxarifadoAtributoRequisicaoItemValor)) {
            $fkAlmoxarifadoAtributoRequisicaoItemValor->setFkAlmoxarifadoAtributoRequisicaoItem($this);
            $this->fkAlmoxarifadoAtributoRequisicaoItemValores->add($fkAlmoxarifadoAtributoRequisicaoItemValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoRequisicaoItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItemValor $fkAlmoxarifadoAtributoRequisicaoItemValor
     */
    public function removeFkAlmoxarifadoAtributoRequisicaoItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItemValor $fkAlmoxarifadoAtributoRequisicaoItemValor)
    {
        $this->fkAlmoxarifadoAtributoRequisicaoItemValores->removeElement($fkAlmoxarifadoAtributoRequisicaoItemValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoRequisicaoItemValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItemValor
     */
    public function getFkAlmoxarifadoAtributoRequisicaoItemValores()
    {
        return $this->fkAlmoxarifadoAtributoRequisicaoItemValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoRequisicaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem $fkAlmoxarifadoRequisicaoItem
     * @return AtributoRequisicaoItem
     */
    public function setFkAlmoxarifadoRequisicaoItem(\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem $fkAlmoxarifadoRequisicaoItem)
    {
        $this->codAlmoxarifado = $fkAlmoxarifadoRequisicaoItem->getCodAlmoxarifado();
        $this->codRequisicao = $fkAlmoxarifadoRequisicaoItem->getCodRequisicao();
        $this->exercicio = $fkAlmoxarifadoRequisicaoItem->getExercicio();
        $this->codCentro = $fkAlmoxarifadoRequisicaoItem->getCodCentro();
        $this->codMarca = $fkAlmoxarifadoRequisicaoItem->getCodMarca();
        $this->codItem = $fkAlmoxarifadoRequisicaoItem->getCodItem();
        $this->fkAlmoxarifadoRequisicaoItem = $fkAlmoxarifadoRequisicaoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoRequisicaoItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem
     */
    public function getFkAlmoxarifadoRequisicaoItem()
    {
        return $this->fkAlmoxarifadoRequisicaoItem;
    }
}
