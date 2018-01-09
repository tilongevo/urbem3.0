<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * ModalidadeCredito
 */
class ModalidadeCredito
{
    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codEspecie;

    /**
     * PK
     * @var integer
     */
    private $codGenero;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var integer
     */
    private $codCredito;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoCredito
     */
    private $fkDividaModalidadeReducaoCreditos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    private $fkDividaModalidadeVigencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkDividaModalidadeReducaoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ModalidadeCredito
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ModalidadeCredito
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return ModalidadeCredito
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * Set codGenero
     *
     * @param integer $codGenero
     * @return ModalidadeCredito
     */
    public function setCodGenero($codGenero)
    {
        $this->codGenero = $codGenero;
        return $this;
    }

    /**
     * Get codGenero
     *
     * @return integer
     */
    public function getCodGenero()
    {
        return $this->codGenero;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return ModalidadeCredito
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set codCredito
     *
     * @param integer $codCredito
     * @return ModalidadeCredito
     */
    public function setCodCredito($codCredito)
    {
        $this->codCredito = $codCredito;
        return $this;
    }

    /**
     * Get codCredito
     *
     * @return integer
     */
    public function getCodCredito()
    {
        return $this->codCredito;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeReducaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoCredito $fkDividaModalidadeReducaoCredito
     * @return ModalidadeCredito
     */
    public function addFkDividaModalidadeReducaoCreditos(\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoCredito $fkDividaModalidadeReducaoCredito)
    {
        if (false === $this->fkDividaModalidadeReducaoCreditos->contains($fkDividaModalidadeReducaoCredito)) {
            $fkDividaModalidadeReducaoCredito->setFkDividaModalidadeCredito($this);
            $this->fkDividaModalidadeReducaoCreditos->add($fkDividaModalidadeReducaoCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeReducaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoCredito $fkDividaModalidadeReducaoCredito
     */
    public function removeFkDividaModalidadeReducaoCreditos(\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoCredito $fkDividaModalidadeReducaoCredito)
    {
        $this->fkDividaModalidadeReducaoCreditos->removeElement($fkDividaModalidadeReducaoCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeReducaoCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoCredito
     */
    public function getFkDividaModalidadeReducaoCreditos()
    {
        return $this->fkDividaModalidadeReducaoCreditos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaModalidadeVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia
     * @return ModalidadeCredito
     */
    public function setFkDividaModalidadeVigencia(\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia)
    {
        $this->codModalidade = $fkDividaModalidadeVigencia->getCodModalidade();
        $this->timestamp = $fkDividaModalidadeVigencia->getTimestamp();
        $this->fkDividaModalidadeVigencia = $fkDividaModalidadeVigencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaModalidadeVigencia
     *
     * @return \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    public function getFkDividaModalidadeVigencia()
    {
        return $this->fkDividaModalidadeVigencia;
    }
}
