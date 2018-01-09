<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * LocalizacaoFisica
 */
class LocalizacaoFisica
{
    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * PK
     * @var integer
     */
    private $codLocalizacao;

    /**
     * @var string
     */
    private $localizacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisicaItem
     */
    private $fkAlmoxarifadoLocalizacaoFisicaItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    private $fkAlmoxarifadoAlmoxarifado;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoLocalizacaoFisicaItens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return LocalizacaoFisica
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
     * Set codLocalizacao
     *
     * @param integer $codLocalizacao
     * @return LocalizacaoFisica
     */
    public function setCodLocalizacao($codLocalizacao)
    {
        $this->codLocalizacao = $codLocalizacao;
        return $this;
    }

    /**
     * Get codLocalizacao
     *
     * @return integer
     */
    public function getCodLocalizacao()
    {
        return $this->codLocalizacao;
    }

    /**
     * Set localizacao
     *
     * @param string $localizacao
     * @return LocalizacaoFisica
     */
    public function setLocalizacao($localizacao)
    {
        $this->localizacao = $localizacao;
        return $this;
    }

    /**
     * Get localizacao
     *
     * @return string
     */
    public function getLocalizacao()
    {
        return $this->localizacao;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLocalizacaoFisicaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisicaItem $fkAlmoxarifadoLocalizacaoFisicaItem
     * @return LocalizacaoFisica
     */
    public function addFkAlmoxarifadoLocalizacaoFisicaItens(\Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisicaItem $fkAlmoxarifadoLocalizacaoFisicaItem)
    {
        if (false === $this->fkAlmoxarifadoLocalizacaoFisicaItens->contains($fkAlmoxarifadoLocalizacaoFisicaItem)) {
            $fkAlmoxarifadoLocalizacaoFisicaItem->setFkAlmoxarifadoLocalizacaoFisica($this);
            $this->fkAlmoxarifadoLocalizacaoFisicaItens->add($fkAlmoxarifadoLocalizacaoFisicaItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLocalizacaoFisicaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisicaItem $fkAlmoxarifadoLocalizacaoFisicaItem
     */
    public function removeFkAlmoxarifadoLocalizacaoFisicaItens(\Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisicaItem $fkAlmoxarifadoLocalizacaoFisicaItem)
    {
        $this->fkAlmoxarifadoLocalizacaoFisicaItens->removeElement($fkAlmoxarifadoLocalizacaoFisicaItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLocalizacaoFisicaItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisicaItem
     */
    public function getFkAlmoxarifadoLocalizacaoFisicaItens()
    {
        return $this->fkAlmoxarifadoLocalizacaoFisicaItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoAlmoxarifado
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado
     * @return LocalizacaoFisica
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
     * PrePersist
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     */
    public function generatePkSequence(\Doctrine\Common\Persistence\Event\LifecycleEventArgs $args)
    {
        $this->codLocalizacao = (new \Doctrine\ORM\Id\SequenceGenerator('almoxarifado.localizacao_fisica_cod_localizacao_seq', 1))->generate($args->getObjectManager(), $this);
    }

    public function __toString()
    {
        if (!is_null($this->fkAlmoxarifadoAlmoxarifado)) {
            return "{$this->getFkAlmoxarifadoAlmoxarifado()->getFkSwCgm()->getNomCgm()} - {$this->getLocalizacao()}";
        }
        return 'Localização Física';
    }
}
