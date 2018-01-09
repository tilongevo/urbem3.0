<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * PermissaoAlmoxarifados
 */
class PermissaoAlmoxarifados
{
    /**
     * PK
     * @var integer
     */
    private $cgmAlmoxarife;

    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * @var boolean
     */
    private $padrao = false;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife
     */
    private $fkAlmoxarifadoAlmoxarife;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    private $fkAlmoxarifadoAlmoxarifado;


    /**
     * Set cgmAlmoxarife
     *
     * @param integer $cgmAlmoxarife
     * @return PermissaoAlmoxarifados
     */
    public function setCgmAlmoxarife($cgmAlmoxarife)
    {
        $this->cgmAlmoxarife = $cgmAlmoxarife;
        return $this;
    }

    /**
     * Get cgmAlmoxarife
     *
     * @return integer
     */
    public function getCgmAlmoxarife()
    {
        return $this->cgmAlmoxarife;
    }

    /**
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return PermissaoAlmoxarifados
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
     * Set padrao
     *
     * @param boolean $padrao
     * @return PermissaoAlmoxarifados
     */
    public function setPadrao($padrao)
    {
        $this->padrao = $padrao;
        return $this;
    }

    /**
     * Get padrao
     *
     * @return boolean
     */
    public function getPadrao()
    {
        return $this->padrao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoAlmoxarife
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife $fkAlmoxarifadoAlmoxarife
     * @return PermissaoAlmoxarifados
     */
    public function setFkAlmoxarifadoAlmoxarife(\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife $fkAlmoxarifadoAlmoxarife)
    {
        $this->cgmAlmoxarife = $fkAlmoxarifadoAlmoxarife->getCgmAlmoxarife();
        $this->fkAlmoxarifadoAlmoxarife = $fkAlmoxarifadoAlmoxarife;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoAlmoxarife
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife
     */
    public function getFkAlmoxarifadoAlmoxarife()
    {
        return $this->fkAlmoxarifadoAlmoxarife;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoAlmoxarifado
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado
     * @return PermissaoAlmoxarifados
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
}
