<?php

namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * SalarioFamilia
 */
class SalarioFamilia
{
    /**
     * PK
     * @var integer
     */
    private $codRegimePrevidencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * @var integer
     */
    private $idadeLimite;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FaixaPagamentoSalarioFamilia
     */
    private $fkFolhapagamentoFaixaPagamentoSalarioFamilias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento
     */
    private $fkFolhapagamentoSalarioFamiliaEventos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia
     */
    private $fkFolhapagamentoRegimePrevidencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoFaixaPagamentoSalarioFamilias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoSalarioFamiliaEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codRegimePrevidencia
     *
     * @param integer $codRegimePrevidencia
     * @return SalarioFamilia
     */
    public function setCodRegimePrevidencia($codRegimePrevidencia)
    {
        $this->codRegimePrevidencia = $codRegimePrevidencia;
        return $this;
    }

    /**
     * Get codRegimePrevidencia
     *
     * @return integer
     */
    public function getCodRegimePrevidencia()
    {
        return $this->codRegimePrevidencia;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SalarioFamilia
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
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return SalarioFamilia
     */
    public function setVigencia(\DateTime $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * Set idadeLimite
     *
     * @param integer $idadeLimite
     * @return SalarioFamilia
     */
    public function setIdadeLimite($idadeLimite)
    {
        $this->idadeLimite = $idadeLimite;
        return $this;
    }

    /**
     * Get idadeLimite
     *
     * @return integer
     */
    public function getIdadeLimite()
    {
        return $this->idadeLimite;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoFaixaPagamentoSalarioFamilia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FaixaPagamentoSalarioFamilia $fkFolhapagamentoFaixaPagamentoSalarioFamilia
     * @return SalarioFamilia
     */
    public function addFkFolhapagamentoFaixaPagamentoSalarioFamilias(\Urbem\CoreBundle\Entity\Folhapagamento\FaixaPagamentoSalarioFamilia $fkFolhapagamentoFaixaPagamentoSalarioFamilia)
    {
        if (false === $this->fkFolhapagamentoFaixaPagamentoSalarioFamilias->contains($fkFolhapagamentoFaixaPagamentoSalarioFamilia)) {
            $fkFolhapagamentoFaixaPagamentoSalarioFamilia->setFkFolhapagamentoSalarioFamilia($this);
            $this->fkFolhapagamentoFaixaPagamentoSalarioFamilias->add($fkFolhapagamentoFaixaPagamentoSalarioFamilia);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoFaixaPagamentoSalarioFamilia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FaixaPagamentoSalarioFamilia $fkFolhapagamentoFaixaPagamentoSalarioFamilia
     */
    public function removeFkFolhapagamentoFaixaPagamentoSalarioFamilias(\Urbem\CoreBundle\Entity\Folhapagamento\FaixaPagamentoSalarioFamilia $fkFolhapagamentoFaixaPagamentoSalarioFamilia)
    {
        $this->fkFolhapagamentoFaixaPagamentoSalarioFamilias->removeElement($fkFolhapagamentoFaixaPagamentoSalarioFamilia);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoFaixaPagamentoSalarioFamilias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FaixaPagamentoSalarioFamilia
     */
    public function getFkFolhapagamentoFaixaPagamentoSalarioFamilias()
    {
        return $this->fkFolhapagamentoFaixaPagamentoSalarioFamilias;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoSalarioFamiliaEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento $fkFolhapagamentoSalarioFamiliaEvento
     * @return SalarioFamilia
     */
    public function addFkFolhapagamentoSalarioFamiliaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento $fkFolhapagamentoSalarioFamiliaEvento)
    {
        if (false === $this->fkFolhapagamentoSalarioFamiliaEventos->contains($fkFolhapagamentoSalarioFamiliaEvento)) {
            $fkFolhapagamentoSalarioFamiliaEvento->setFkFolhapagamentoSalarioFamilia($this);
            $this->fkFolhapagamentoSalarioFamiliaEventos->add($fkFolhapagamentoSalarioFamiliaEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoSalarioFamiliaEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento $fkFolhapagamentoSalarioFamiliaEvento
     */
    public function removeFkFolhapagamentoSalarioFamiliaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento $fkFolhapagamentoSalarioFamiliaEvento)
    {
        $this->fkFolhapagamentoSalarioFamiliaEventos->removeElement($fkFolhapagamentoSalarioFamiliaEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoSalarioFamiliaEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento
     */
    public function getFkFolhapagamentoSalarioFamiliaEventos()
    {
        return $this->fkFolhapagamentoSalarioFamiliaEventos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoRegimePrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia $fkFolhapagamentoRegimePrevidencia
     * @return SalarioFamilia
     */
    public function setFkFolhapagamentoRegimePrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia $fkFolhapagamentoRegimePrevidencia)
    {
        $this->codRegimePrevidencia = $fkFolhapagamentoRegimePrevidencia->getCodRegimePrevidencia();
        $this->fkFolhapagamentoRegimePrevidencia = $fkFolhapagamentoRegimePrevidencia;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoRegimePrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia
     */
    public function getFkFolhapagamentoRegimePrevidencia()
    {
        return $this->fkFolhapagamentoRegimePrevidencia;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->fkFolhapagamentoRegimePrevidencia, $this->vigencia->format('d/m/Y'));
    }
}
