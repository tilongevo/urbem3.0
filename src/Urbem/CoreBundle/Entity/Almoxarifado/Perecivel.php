<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Perecivel
 */
class Perecivel
{
    /**
     * PK
     * @var string
     */
    private $lote;

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
    private $codAlmoxarifado;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * @var \DateTime
     */
    private $dtFabricacao;

    /**
     * @var \DateTime
     */
    private $dtValidade;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel
     */
    private $fkAlmoxarifadoLancamentoPereciveis;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial
     */
    private $fkAlmoxarifadoEstoqueMaterial;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoLancamentoPereciveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set lote
     *
     * @param string $lote
     * @return Perecivel
     */
    public function setLote($lote)
    {
        $this->lote = $lote;
        return $this;
    }

    /**
     * Get lote
     *
     * @return string
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return Perecivel
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
     * @return Perecivel
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
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return Perecivel
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
     * Set codCentro
     *
     * @param integer $codCentro
     * @return Perecivel
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
     * Set dtFabricacao
     *
     * @param \DateTime $dtFabricacao
     * @return Perecivel
     */
    public function setDtFabricacao(\DateTime $dtFabricacao)
    {
        $this->dtFabricacao = $dtFabricacao;
        return $this;
    }

    /**
     * Get dtFabricacao
     *
     * @return \DateTime
     */
    public function getDtFabricacao()
    {
        return $this->dtFabricacao;
    }

    /**
     * Set dtValidade
     *
     * @param \DateTime $dtValidade
     * @return Perecivel
     */
    public function setDtValidade(\DateTime $dtValidade)
    {
        $this->dtValidade = $dtValidade;
        return $this;
    }

    /**
     * Get dtValidade
     *
     * @return \DateTime
     */
    public function getDtValidade()
    {
        return $this->dtValidade;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoPerecivel
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel $fkAlmoxarifadoLancamentoPerecivel
     * @return Perecivel
     */
    public function addFkAlmoxarifadoLancamentoPereciveis(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel $fkAlmoxarifadoLancamentoPerecivel)
    {
        if (false === $this->fkAlmoxarifadoLancamentoPereciveis->contains($fkAlmoxarifadoLancamentoPerecivel)) {
            $fkAlmoxarifadoLancamentoPerecivel->setFkAlmoxarifadoPerecivel($this);
            $this->fkAlmoxarifadoLancamentoPereciveis->add($fkAlmoxarifadoLancamentoPerecivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoPerecivel
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel $fkAlmoxarifadoLancamentoPerecivel
     */
    public function removeFkAlmoxarifadoLancamentoPereciveis(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel $fkAlmoxarifadoLancamentoPerecivel)
    {
        $this->fkAlmoxarifadoLancamentoPereciveis->removeElement($fkAlmoxarifadoLancamentoPerecivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoPereciveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel
     */
    public function getFkAlmoxarifadoLancamentoPereciveis()
    {
        return $this->fkAlmoxarifadoLancamentoPereciveis;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoEstoqueMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial
     * @return Perecivel
     */
    public function setFkAlmoxarifadoEstoqueMaterial(\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial)
    {
        $this->codItem = $fkAlmoxarifadoEstoqueMaterial->getCodItem();
        $this->codMarca = $fkAlmoxarifadoEstoqueMaterial->getCodMarca();
        $this->codAlmoxarifado = $fkAlmoxarifadoEstoqueMaterial->getCodAlmoxarifado();
        $this->codCentro = $fkAlmoxarifadoEstoqueMaterial->getCodCentro();
        $this->fkAlmoxarifadoEstoqueMaterial = $fkAlmoxarifadoEstoqueMaterial;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoEstoqueMaterial
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial
     */
    public function getFkAlmoxarifadoEstoqueMaterial()
    {
        return $this->fkAlmoxarifadoEstoqueMaterial;
    }

    public function __toString()
    {
        return (string) "Perecível";
    }
}
