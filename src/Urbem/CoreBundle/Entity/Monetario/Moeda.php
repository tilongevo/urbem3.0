<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * Moeda
 */
class Moeda
{
    /**
     * PK
     * @var integer
     */
    private $codMoeda;

    /**
     * @var string
     */
    private $descricaoSingular;

    /**
     * @var string
     */
    private $descricaoPlural;

    /**
     * @var string
     */
    private $fracaoSingular;

    /**
     * @var string
     */
    private $fracaoPlural;

    /**
     * @var string
     */
    private $simbolo;

    /**
     * @var \DateTime
     */
    private $inicioVigencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Monetario\RegraConversaoMoeda
     */
    private $fkMonetarioRegraConversaoMoeda;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeMoeda
     */
    private $fkEconomicoAtividadeModalidadeMoedas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeMoeda
     */
    private $fkEconomicoCadEconModalidadeMoedas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoMoeda
     */
    private $fkMonetarioCreditoMoedas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtividadeModalidadeMoedas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoCadEconModalidadeMoedas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioCreditoMoedas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codMoeda
     *
     * @param integer $codMoeda
     * @return Moeda
     */
    public function setCodMoeda($codMoeda)
    {
        $this->codMoeda = $codMoeda;
        return $this;
    }

    /**
     * Get codMoeda
     *
     * @return integer
     */
    public function getCodMoeda()
    {
        return $this->codMoeda;
    }

    /**
     * Set descricaoSingular
     *
     * @param string $descricaoSingular
     * @return Moeda
     */
    public function setDescricaoSingular($descricaoSingular)
    {
        $this->descricaoSingular = $descricaoSingular;
        return $this;
    }

    /**
     * Get descricaoSingular
     *
     * @return string
     */
    public function getDescricaoSingular()
    {
        return $this->descricaoSingular;
    }

    /**
     * Set descricaoPlural
     *
     * @param string $descricaoPlural
     * @return Moeda
     */
    public function setDescricaoPlural($descricaoPlural)
    {
        $this->descricaoPlural = $descricaoPlural;
        return $this;
    }

    /**
     * Get descricaoPlural
     *
     * @return string
     */
    public function getDescricaoPlural()
    {
        return $this->descricaoPlural;
    }

    /**
     * Set fracaoSingular
     *
     * @param string $fracaoSingular
     * @return Moeda
     */
    public function setFracaoSingular($fracaoSingular)
    {
        $this->fracaoSingular = $fracaoSingular;
        return $this;
    }

    /**
     * Get fracaoSingular
     *
     * @return string
     */
    public function getFracaoSingular()
    {
        return $this->fracaoSingular;
    }

    /**
     * Set fracaoPlural
     *
     * @param string $fracaoPlural
     * @return Moeda
     */
    public function setFracaoPlural($fracaoPlural)
    {
        $this->fracaoPlural = $fracaoPlural;
        return $this;
    }

    /**
     * Get fracaoPlural
     *
     * @return string
     */
    public function getFracaoPlural()
    {
        return $this->fracaoPlural;
    }

    /**
     * Set simbolo
     *
     * @param string $simbolo
     * @return Moeda
     */
    public function setSimbolo($simbolo)
    {
        $this->simbolo = $simbolo;
        return $this;
    }

    /**
     * Get simbolo
     *
     * @return string
     */
    public function getSimbolo()
    {
        return $this->simbolo;
    }

    /**
     * Set inicioVigencia
     *
     * @param \DateTime $inicioVigencia
     * @return Moeda
     */
    public function setInicioVigencia(\DateTime $inicioVigencia)
    {
        $this->inicioVigencia = $inicioVigencia;
        return $this;
    }

    /**
     * Get inicioVigencia
     *
     * @return \DateTime
     */
    public function getInicioVigencia()
    {
        return $this->inicioVigencia;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtividadeModalidadeMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeMoeda $fkEconomicoAtividadeModalidadeMoeda
     * @return Moeda
     */
    public function addFkEconomicoAtividadeModalidadeMoedas(\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeMoeda $fkEconomicoAtividadeModalidadeMoeda)
    {
        if (false === $this->fkEconomicoAtividadeModalidadeMoedas->contains($fkEconomicoAtividadeModalidadeMoeda)) {
            $fkEconomicoAtividadeModalidadeMoeda->setFkMonetarioMoeda($this);
            $this->fkEconomicoAtividadeModalidadeMoedas->add($fkEconomicoAtividadeModalidadeMoeda);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtividadeModalidadeMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeMoeda $fkEconomicoAtividadeModalidadeMoeda
     */
    public function removeFkEconomicoAtividadeModalidadeMoedas(\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeMoeda $fkEconomicoAtividadeModalidadeMoeda)
    {
        $this->fkEconomicoAtividadeModalidadeMoedas->removeElement($fkEconomicoAtividadeModalidadeMoeda);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtividadeModalidadeMoedas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeMoeda
     */
    public function getFkEconomicoAtividadeModalidadeMoedas()
    {
        return $this->fkEconomicoAtividadeModalidadeMoedas;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadEconModalidadeMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadEconModalidadeMoeda $fkEconomicoCadEconModalidadeMoeda
     * @return Moeda
     */
    public function addFkEconomicoCadEconModalidadeMoedas(\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeMoeda $fkEconomicoCadEconModalidadeMoeda)
    {
        if (false === $this->fkEconomicoCadEconModalidadeMoedas->contains($fkEconomicoCadEconModalidadeMoeda)) {
            $fkEconomicoCadEconModalidadeMoeda->setFkMonetarioMoeda($this);
            $this->fkEconomicoCadEconModalidadeMoedas->add($fkEconomicoCadEconModalidadeMoeda);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadEconModalidadeMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadEconModalidadeMoeda $fkEconomicoCadEconModalidadeMoeda
     */
    public function removeFkEconomicoCadEconModalidadeMoedas(\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeMoeda $fkEconomicoCadEconModalidadeMoeda)
    {
        $this->fkEconomicoCadEconModalidadeMoedas->removeElement($fkEconomicoCadEconModalidadeMoeda);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadEconModalidadeMoedas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeMoeda
     */
    public function getFkEconomicoCadEconModalidadeMoedas()
    {
        return $this->fkEconomicoCadEconModalidadeMoedas;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioCreditoMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoMoeda $fkMonetarioCreditoMoeda
     * @return Moeda
     */
    public function addFkMonetarioCreditoMoedas(\Urbem\CoreBundle\Entity\Monetario\CreditoMoeda $fkMonetarioCreditoMoeda)
    {
        if (false === $this->fkMonetarioCreditoMoedas->contains($fkMonetarioCreditoMoeda)) {
            $fkMonetarioCreditoMoeda->setFkMonetarioMoeda($this);
            $this->fkMonetarioCreditoMoedas->add($fkMonetarioCreditoMoeda);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioCreditoMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoMoeda $fkMonetarioCreditoMoeda
     */
    public function removeFkMonetarioCreditoMoedas(\Urbem\CoreBundle\Entity\Monetario\CreditoMoeda $fkMonetarioCreditoMoeda)
    {
        $this->fkMonetarioCreditoMoedas->removeElement($fkMonetarioCreditoMoeda);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioCreditoMoedas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoMoeda
     */
    public function getFkMonetarioCreditoMoedas()
    {
        return $this->fkMonetarioCreditoMoedas;
    }

    /**
     * OneToOne (inverse side)
     * Set MonetarioRegraConversaoMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\RegraConversaoMoeda $fkMonetarioRegraConversaoMoeda
     * @return Moeda
     */
    public function setFkMonetarioRegraConversaoMoeda(\Urbem\CoreBundle\Entity\Monetario\RegraConversaoMoeda $fkMonetarioRegraConversaoMoeda)
    {
        $fkMonetarioRegraConversaoMoeda->setFkMonetarioMoeda($this);
        $this->fkMonetarioRegraConversaoMoeda = $fkMonetarioRegraConversaoMoeda;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkMonetarioRegraConversaoMoeda
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\RegraConversaoMoeda
     */
    public function getFkMonetarioRegraConversaoMoeda()
    {
        return $this->fkMonetarioRegraConversaoMoeda;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->descricaoSingular;
    }
}
