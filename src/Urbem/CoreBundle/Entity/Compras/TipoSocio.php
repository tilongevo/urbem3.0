<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * TipoSocio
 */
class TipoSocio
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorSocio
     */
    private $fkComprasFornecedorSocios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasFornecedorSocios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoSocio
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
     * Set descricao
     *
     * @param string $descricao
     * @return TipoSocio
     */
    public function setDescricao($descricao)
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
     * Add ComprasFornecedorSocio
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorSocio $fkComprasFornecedorSocio
     * @return TipoSocio
     */
    public function addFkComprasFornecedorSocios(\Urbem\CoreBundle\Entity\Compras\FornecedorSocio $fkComprasFornecedorSocio)
    {
        if (false === $this->fkComprasFornecedorSocios->contains($fkComprasFornecedorSocio)) {
            $fkComprasFornecedorSocio->setFkComprasTipoSocio($this);
            $this->fkComprasFornecedorSocios->add($fkComprasFornecedorSocio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasFornecedorSocio
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorSocio $fkComprasFornecedorSocio
     */
    public function removeFkComprasFornecedorSocios(\Urbem\CoreBundle\Entity\Compras\FornecedorSocio $fkComprasFornecedorSocio)
    {
        $this->fkComprasFornecedorSocios->removeElement($fkComprasFornecedorSocio);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasFornecedorSocios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorSocio
     */
    public function getFkComprasFornecedorSocios()
    {
        return $this->fkComprasFornecedorSocios;
    }
}
