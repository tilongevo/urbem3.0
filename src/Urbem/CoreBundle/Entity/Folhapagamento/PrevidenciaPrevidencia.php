<?php

namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * PrevidenciaPrevidencia
 */
class PrevidenciaPrevidencia
{
    /**
     * PK
     * @var integer
     */
    private $codPrevidencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $aliquota;

    /**
     * @var string
     */
    private $tipoPrevidencia;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaRegimeRat
     */
    private $fkFolhapagamentoPrevidenciaRegimeRat;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPrevidenciaValor
     */
    private $fkFolhapagamentoAtributoPrevidenciaValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FaixaDesconto
     */
    private $fkFolhapagamentoFaixaDescontos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento
     */
    private $fkFolhapagamentoPrevidenciaEventos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Previdencia
     */
    private $fkFolhapagamentoPrevidencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoAtributoPrevidenciaValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoFaixaDescontos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoPrevidenciaEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->vigencia = new \DateTime();
    }

    /**
     * Set codPrevidencia
     *
     * @param integer $codPrevidencia
     * @return PrevidenciaPrevidencia
     */
    public function setCodPrevidencia($codPrevidencia)
    {
        $this->codPrevidencia = $codPrevidencia;
        return $this;
    }

    /**
     * Get codPrevidencia
     *
     * @return integer
     */
    public function getCodPrevidencia()
    {
        return $this->codPrevidencia;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return PrevidenciaPrevidencia
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
     * Set descricao
     *
     * @param string $descricao
     * @return PrevidenciaPrevidencia
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
     * Set aliquota
     *
     * @param integer $aliquota
     * @return PrevidenciaPrevidencia
     */
    public function setAliquota($aliquota)
    {
        $this->aliquota = $aliquota;
        return $this;
    }

    /**
     * Get aliquota
     *
     * @return integer
     */
    public function getAliquota()
    {
        return $this->aliquota;
    }

    /**
     * Set tipoPrevidencia
     *
     * @param string $tipoPrevidencia
     * @return PrevidenciaPrevidencia
     */
    public function setTipoPrevidencia($tipoPrevidencia)
    {
        $this->tipoPrevidencia = $tipoPrevidencia;
        return $this;
    }

    /**
     * Get tipoPrevidencia
     *
     * @return string
     */
    public function getTipoPrevidencia()
    {
        return $this->tipoPrevidencia;
    }

    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return PrevidenciaPrevidencia
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
     * OneToMany (owning side)
     * Add FolhapagamentoAtributoPrevidenciaValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\AtributoPrevidenciaValor $fkFolhapagamentoAtributoPrevidenciaValor
     * @return PrevidenciaPrevidencia
     */
    public function addFkFolhapagamentoAtributoPrevidenciaValores(\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPrevidenciaValor $fkFolhapagamentoAtributoPrevidenciaValor)
    {
        if (false === $this->fkFolhapagamentoAtributoPrevidenciaValores->contains($fkFolhapagamentoAtributoPrevidenciaValor)) {
            $fkFolhapagamentoAtributoPrevidenciaValor->setFkFolhapagamentoPrevidenciaPrevidencia($this);
            $this->fkFolhapagamentoAtributoPrevidenciaValores->add($fkFolhapagamentoAtributoPrevidenciaValor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoAtributoPrevidenciaValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\AtributoPrevidenciaValor $fkFolhapagamentoAtributoPrevidenciaValor
     */
    public function removeFkFolhapagamentoAtributoPrevidenciaValores(\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPrevidenciaValor $fkFolhapagamentoAtributoPrevidenciaValor)
    {
        $this->fkFolhapagamentoAtributoPrevidenciaValores->removeElement($fkFolhapagamentoAtributoPrevidenciaValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoAtributoPrevidenciaValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPrevidenciaValor
     */
    public function getFkFolhapagamentoAtributoPrevidenciaValores()
    {
        return $this->fkFolhapagamentoAtributoPrevidenciaValores;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $faixaDescontos
     * @return PrevidenciaPrevidencia
     */
    public function setFkFolhapagamentoFaixaDescontos(\Doctrine\Common\Collections\Collection $faixaDescontos)
    {
        foreach ($faixaDescontos as $faixaDesconto) {
            $this->addFkFolhapagamentoFaixaDescontos($faixaDesconto);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoFaixaDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FaixaDesconto $fkFolhapagamentoFaixaDesconto
     * @return PrevidenciaPrevidencia
     */
    public function addFkFolhapagamentoFaixaDescontos(\Urbem\CoreBundle\Entity\Folhapagamento\FaixaDesconto $fkFolhapagamentoFaixaDesconto)
    {
        if (false === $this->fkFolhapagamentoFaixaDescontos->contains($fkFolhapagamentoFaixaDesconto)) {
            $fkFolhapagamentoFaixaDesconto->setFkFolhapagamentoPrevidenciaPrevidencia($this);
            $this->fkFolhapagamentoFaixaDescontos->add($fkFolhapagamentoFaixaDesconto);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoFaixaDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FaixaDesconto $fkFolhapagamentoFaixaDesconto
     */
    public function removeFkFolhapagamentoFaixaDesconto(\Urbem\CoreBundle\Entity\Folhapagamento\FaixaDesconto $fkFolhapagamentoFaixaDesconto)
    {
        $this->fkFolhapagamentoFaixaDescontos->removeElement($fkFolhapagamentoFaixaDesconto);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoFaixaDescontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FaixaDesconto
     */
    public function getFkFolhapagamentoFaixaDescontos()
    {
        return $this->fkFolhapagamentoFaixaDescontos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoPrevidenciaEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento $fkFolhapagamentoPrevidenciaEvento
     * @return PrevidenciaPrevidencia
     */
    public function addFkFolhapagamentoPrevidenciaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento $fkFolhapagamentoPrevidenciaEvento)
    {
        if (false === $this->fkFolhapagamentoPrevidenciaEventos->contains($fkFolhapagamentoPrevidenciaEvento)) {
            $fkFolhapagamentoPrevidenciaEvento->setFkFolhapagamentoPrevidenciaPrevidencia($this);
            $this->fkFolhapagamentoPrevidenciaEventos->add($fkFolhapagamentoPrevidenciaEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoPrevidenciaEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento $fkFolhapagamentoPrevidenciaEvento
     */
    public function removeFkFolhapagamentoPrevidenciaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento $fkFolhapagamentoPrevidenciaEvento)
    {
        $this->fkFolhapagamentoPrevidenciaEventos->removeElement($fkFolhapagamentoPrevidenciaEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoPrevidenciaEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento
     */
    public function getFkFolhapagamentoPrevidenciaEventos()
    {
        return $this->fkFolhapagamentoPrevidenciaEventos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia
     * @return PrevidenciaPrevidencia
     */
    public function setFkFolhapagamentoPrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia)
    {
        $this->codPrevidencia = $fkFolhapagamentoPrevidencia->getCodPrevidencia();
        $this->fkFolhapagamentoPrevidencia = $fkFolhapagamentoPrevidencia;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Previdencia
     */
    public function getFkFolhapagamentoPrevidencia()
    {
        return $this->fkFolhapagamentoPrevidencia;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoPrevidenciaRegimeRat
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaRegimeRat $fkFolhapagamentoPrevidenciaRegimeRat
     * @return PrevidenciaPrevidencia
     */
    public function setFkFolhapagamentoPrevidenciaRegimeRat(\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaRegimeRat $fkFolhapagamentoPrevidenciaRegimeRat)
    {
        $fkFolhapagamentoPrevidenciaRegimeRat->setFkFolhapagamentoPrevidenciaPrevidencia($this);
        $this->fkFolhapagamentoPrevidenciaRegimeRat = $fkFolhapagamentoPrevidenciaRegimeRat;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoPrevidenciaRegimeRat
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaRegimeRat
     */
    public function getFkFolhapagamentoPrevidenciaRegimeRat()
    {
        return $this->fkFolhapagamentoPrevidenciaRegimeRat;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
