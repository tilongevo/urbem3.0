<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * Procurador
 */
class Procurador
{
    /**
     * PK
     * @var integer
     */
    private $codAutoridade;

    /**
     * @var string
     */
    private $oab;

    /**
     * @var integer
     */
    private $codUf;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Divida\Autoridade
     */
    private $fkDividaAutoridade;


    /**
     * Set codAutoridade
     *
     * @param integer $codAutoridade
     * @return Procurador
     */
    public function setCodAutoridade($codAutoridade)
    {
        $this->codAutoridade = $codAutoridade;
        return $this;
    }

    /**
     * Get codAutoridade
     *
     * @return integer
     */
    public function getCodAutoridade()
    {
        return $this->codAutoridade;
    }

    /**
     * Set oab
     *
     * @param string $oab
     * @return Procurador
     */
    public function setOab($oab)
    {
        $this->oab = $oab;
        return $this;
    }

    /**
     * Get oab
     *
     * @return string
     */
    public function getOab()
    {
        return $this->oab;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return Procurador
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * OneToOne (owning side)
     * Set DividaAutoridade
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade
     * @return Procurador
     */
    public function setFkDividaAutoridade(\Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade)
    {
        $this->codAutoridade = $fkDividaAutoridade->getCodAutoridade();
        $this->fkDividaAutoridade = $fkDividaAutoridade;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkDividaAutoridade
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Autoridade
     */
    public function getFkDividaAutoridade()
    {
        return $this->fkDividaAutoridade;
    }
}
