<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * BemMarca
 */
class BemMarca
{
    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * @var integer
     */
    private $codMarca;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Marca
     */
    private $fkAlmoxarifadoMarca;


    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return BemMarca
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set codMarca
     *
     * @param integer $codMarca
     * @return BemMarca
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
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoMarca
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Marca $fkAlmoxarifadoMarca
     * @return BemMarca
     */
    public function setFkAlmoxarifadoMarca(\Urbem\CoreBundle\Entity\Almoxarifado\Marca $fkAlmoxarifadoMarca)
    {
        $this->codMarca = $fkAlmoxarifadoMarca->getCodMarca();
        $this->fkAlmoxarifadoMarca = $fkAlmoxarifadoMarca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoMarca
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Marca
     */
    public function getFkAlmoxarifadoMarca()
    {
        return $this->fkAlmoxarifadoMarca;
    }

    /**
     * OneToOne (owning side)
     * Set PatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return BemMarca
     */
    public function setFkPatrimonioBem(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->codBem = $fkPatrimonioBem->getCodBem();
        $this->fkPatrimonioBem = $fkPatrimonioBem;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPatrimonioBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBem()
    {
        return $this->fkPatrimonioBem;
    }
}
