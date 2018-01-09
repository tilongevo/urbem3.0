<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Inventario
 */
class Inventario
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
    private $codInventario;

    /**
     * @var \DateTime
     */
    private $dtInventario;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var boolean
     */
    private $processado = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\InventarioAnulacao
     */
    private $fkAlmoxarifadoInventarioAnulacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacaoBloqueio
     */
    private $fkAlmoxarifadoCatalogoClassificacaoBloqueios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens
     */
    private $fkAlmoxarifadoInventarioItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    private $fkAlmoxarifadoAlmoxarifado;

    private $codInventarioExercicio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoCatalogoClassificacaoBloqueios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoInventarioItens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Inventario
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
     * @return Inventario
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
     * Set codInventario
     *
     * @param integer $codInventario
     * @return Inventario
     */
    public function setCodInventario($codInventario)
    {
        $this->codInventario = $codInventario;
        return $this;
    }

    /**
     * Get codInventario
     *
     * @return integer
     */
    public function getCodInventario()
    {
        return $this->codInventario;
    }

    /**
     * Set dtInventario
     *
     * @param \DateTime $dtInventario
     * @return Inventario
     */
    public function setDtInventario(\DateTime $dtInventario = null)
    {
        $this->dtInventario = $dtInventario;
        return $this;
    }

    /**
     * Get dtInventario
     *
     * @return \DateTime
     */
    public function getDtInventario()
    {
        return $this->dtInventario;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return Inventario
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set processado
     *
     * @param boolean $processado
     * @return Inventario
     */
    public function setProcessado($processado)
    {
        $this->processado = $processado;
        return $this;
    }

    /**
     * Get processado
     *
     * @return boolean
     */
    public function getProcessado()
    {
        return $this->processado;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoCatalogoClassificacaoBloqueio
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacaoBloqueio $fkAlmoxarifadoCatalogoClassificacaoBloqueio
     * @return Inventario
     */
    public function addFkAlmoxarifadoCatalogoClassificacaoBloqueios(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacaoBloqueio $fkAlmoxarifadoCatalogoClassificacaoBloqueio)
    {
        if (false === $this->fkAlmoxarifadoCatalogoClassificacaoBloqueios->contains($fkAlmoxarifadoCatalogoClassificacaoBloqueio)) {
            $fkAlmoxarifadoCatalogoClassificacaoBloqueio->setFkAlmoxarifadoInventario($this);
            $this->fkAlmoxarifadoCatalogoClassificacaoBloqueios->add($fkAlmoxarifadoCatalogoClassificacaoBloqueio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCatalogoClassificacaoBloqueio
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacaoBloqueio $fkAlmoxarifadoCatalogoClassificacaoBloqueio
     */
    public function removeFkAlmoxarifadoCatalogoClassificacaoBloqueios(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacaoBloqueio $fkAlmoxarifadoCatalogoClassificacaoBloqueio)
    {
        $this->fkAlmoxarifadoCatalogoClassificacaoBloqueios->removeElement($fkAlmoxarifadoCatalogoClassificacaoBloqueio);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCatalogoClassificacaoBloqueios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacaoBloqueio
     */
    public function getFkAlmoxarifadoCatalogoClassificacaoBloqueios()
    {
        return $this->fkAlmoxarifadoCatalogoClassificacaoBloqueios;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoInventarioItens
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens $fkAlmoxarifadoInventarioItens
     * @return Inventario
     */
    public function addFkAlmoxarifadoInventarioItens(\Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens $fkAlmoxarifadoInventarioItens)
    {
        if (false === $this->fkAlmoxarifadoInventarioItens->contains($fkAlmoxarifadoInventarioItens)) {
            $fkAlmoxarifadoInventarioItens->setFkAlmoxarifadoInventario($this);
            $this->fkAlmoxarifadoInventarioItens->add($fkAlmoxarifadoInventarioItens);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoInventarioItens
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens $fkAlmoxarifadoInventarioItens
     */
    public function removeFkAlmoxarifadoInventarioItens(\Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens $fkAlmoxarifadoInventarioItens)
    {
        $this->fkAlmoxarifadoInventarioItens->removeElement($fkAlmoxarifadoInventarioItens);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoInventarioItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens
     */
    public function getFkAlmoxarifadoInventarioItens()
    {
        return $this->fkAlmoxarifadoInventarioItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoAlmoxarifado
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado
     * @return Inventario
     */
    public function setFkAlmoxarifadoAlmoxarifado(\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado)
    {
        $this->codAlmoxarifado = $fkAlmoxarifadoAlmoxarifado->getCodAlmoxarifado();
        $this->fkAlmoxarifadoAlmoxarifado = $fkAlmoxarifadoAlmoxarifado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoAlmoxarifado
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    public function getFkAlmoxarifadoAlmoxarifado()
    {
        return $this->fkAlmoxarifadoAlmoxarifado;
    }

    /**
     * OneToOne (inverse side)
     * Set AlmoxarifadoInventarioAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\InventarioAnulacao $fkAlmoxarifadoInventarioAnulacao
     * @return Inventario
     */
    public function setFkAlmoxarifadoInventarioAnulacao(\Urbem\CoreBundle\Entity\Almoxarifado\InventarioAnulacao $fkAlmoxarifadoInventarioAnulacao)
    {
        $fkAlmoxarifadoInventarioAnulacao->setFkAlmoxarifadoInventario($this);
        $this->fkAlmoxarifadoInventarioAnulacao = $fkAlmoxarifadoInventarioAnulacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAlmoxarifadoInventarioAnulacao
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\InventarioAnulacao
     */
    public function getFkAlmoxarifadoInventarioAnulacao()
    {
        return $this->fkAlmoxarifadoInventarioAnulacao;
    }

    /**
     * @return string
     */
    public function getCodInventarioExercicio()
    {
        if ($this->codInventario && $this->exercicio) {
            return sprintf(
                '%s/%s',
                $this->codInventario,
                $this->exercicio
            );
        } else {
            return 'Inventário';
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getCodInventarioExercicio();
    }
}
