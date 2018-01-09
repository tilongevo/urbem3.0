<?php

namespace Urbem\CoreBundle\Entity\Divida;

/**
 * Parcelamento
 */
class Parcelamento
{
    /**
     * PK
     * @var integer
     */
    private $numParcelamento;

    /**
     * @var integer
     */
    private $numcgmUsuario;

    /**
     * @var \DateTime
     */
    private $timestampModalidade;

    /**
     * @var integer
     */
    private $codModalidade;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $numeroParcelamento;

    /**
     * @var boolean
     */
    private $judicial = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Divida\ParcelamentoCancelamento
     */
    private $fkDividaParcelamentoCancelamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Documento
     */
    private $fkDividaDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaOrigem
     */
    private $fkDividaParcelaOrigens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaParcelamento
     */
    private $fkDividaDividaParcelamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Parcela
     */
    private $fkDividaParcelas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

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
        $this->fkDividaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaParcelaOrigens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaParcelamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaParcelas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set numParcelamento
     *
     * @param integer $numParcelamento
     * @return Parcelamento
     */
    public function setNumParcelamento($numParcelamento)
    {
        $this->numParcelamento = $numParcelamento;
        return $this;
    }

    /**
     * Get numParcelamento
     *
     * @return integer
     */
    public function getNumParcelamento()
    {
        return $this->numParcelamento;
    }

    /**
     * Set numcgmUsuario
     *
     * @param integer $numcgmUsuario
     * @return Parcelamento
     */
    public function setNumcgmUsuario($numcgmUsuario)
    {
        $this->numcgmUsuario = $numcgmUsuario;
        return $this;
    }

    /**
     * Get numcgmUsuario
     *
     * @return integer
     */
    public function getNumcgmUsuario()
    {
        return $this->numcgmUsuario;
    }

    /**
     * Set timestampModalidade
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampModalidade
     * @return Parcelamento
     */
    public function setTimestampModalidade(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampModalidade)
    {
        $this->timestampModalidade = $timestampModalidade;
        return $this;
    }

    /**
     * Get timestampModalidade
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampModalidade()
    {
        return $this->timestampModalidade;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return Parcelamento
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
     * @return Parcelamento
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Parcelamento
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
     * Set numeroParcelamento
     *
     * @param integer $numeroParcelamento
     * @return Parcelamento
     */
    public function setNumeroParcelamento($numeroParcelamento)
    {
        $this->numeroParcelamento = $numeroParcelamento;
        return $this;
    }

    /**
     * Get numeroParcelamento
     *
     * @return integer
     */
    public function getNumeroParcelamento()
    {
        return $this->numeroParcelamento;
    }

    /**
     * Set judicial
     *
     * @param boolean $judicial
     * @return Parcelamento
     */
    public function setJudicial($judicial)
    {
        $this->judicial = $judicial;
        return $this;
    }

    /**
     * Get judicial
     *
     * @return boolean
     */
    public function getJudicial()
    {
        return $this->judicial;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Documento $fkDividaDocumento
     * @return Parcelamento
     */
    public function addFkDividaDocumentos(\Urbem\CoreBundle\Entity\Divida\Documento $fkDividaDocumento)
    {
        if (false === $this->fkDividaDocumentos->contains($fkDividaDocumento)) {
            $fkDividaDocumento->setFkDividaParcelamento($this);
            $this->fkDividaDocumentos->add($fkDividaDocumento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Documento $fkDividaDocumento
     */
    public function removeFkDividaDocumentos(\Urbem\CoreBundle\Entity\Divida\Documento $fkDividaDocumento)
    {
        $this->fkDividaDocumentos->removeElement($fkDividaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Documento
     */
    public function getFkDividaDocumentos()
    {
        return $this->fkDividaDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaParcelaOrigem
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaOrigem $fkDividaParcelaOrigem
     * @return Parcelamento
     */
    public function addFkDividaParcelaOrigens(\Urbem\CoreBundle\Entity\Divida\ParcelaOrigem $fkDividaParcelaOrigem)
    {
        if (false === $this->fkDividaParcelaOrigens->contains($fkDividaParcelaOrigem)) {
            $fkDividaParcelaOrigem->setFkDividaParcelamento($this);
            $this->fkDividaParcelaOrigens->add($fkDividaParcelaOrigem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaParcelaOrigem
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaOrigem $fkDividaParcelaOrigem
     */
    public function removeFkDividaParcelaOrigens(\Urbem\CoreBundle\Entity\Divida\ParcelaOrigem $fkDividaParcelaOrigem)
    {
        $this->fkDividaParcelaOrigens->removeElement($fkDividaParcelaOrigem);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaParcelaOrigens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaOrigem
     */
    public function getFkDividaParcelaOrigens()
    {
        return $this->fkDividaParcelaOrigens;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaParcelamento $fkDividaDividaParcelamento
     * @return Parcelamento
     */
    public function addFkDividaDividaParcelamentos(\Urbem\CoreBundle\Entity\Divida\DividaParcelamento $fkDividaDividaParcelamento)
    {
        if (false === $this->fkDividaDividaParcelamentos->contains($fkDividaDividaParcelamento)) {
            $fkDividaDividaParcelamento->setFkDividaParcelamento($this);
            $this->fkDividaDividaParcelamentos->add($fkDividaDividaParcelamento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaParcelamento $fkDividaDividaParcelamento
     */
    public function removeFkDividaDividaParcelamentos(\Urbem\CoreBundle\Entity\Divida\DividaParcelamento $fkDividaDividaParcelamento)
    {
        $this->fkDividaDividaParcelamentos->removeElement($fkDividaDividaParcelamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaParcelamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaParcelamento
     */
    public function getFkDividaDividaParcelamentos()
    {
        return $this->fkDividaDividaParcelamentos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaParcela
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcela $fkDividaParcela
     * @return Parcelamento
     */
    public function addFkDividaParcelas(\Urbem\CoreBundle\Entity\Divida\Parcela $fkDividaParcela)
    {
        if (false === $this->fkDividaParcelas->contains($fkDividaParcela)) {
            $fkDividaParcela->setFkDividaParcelamento($this);
            $this->fkDividaParcelas->add($fkDividaParcela);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaParcela
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcela $fkDividaParcela
     */
    public function removeFkDividaParcelas(\Urbem\CoreBundle\Entity\Divida\Parcela $fkDividaParcela)
    {
        $this->fkDividaParcelas->removeElement($fkDividaParcela);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaParcelas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Parcela
     */
    public function getFkDividaParcelas()
    {
        return $this->fkDividaParcelas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Parcelamento
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgmUsuario = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaModalidadeVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia
     * @return Parcelamento
     */
    public function setFkDividaModalidadeVigencia(\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia)
    {
        $this->codModalidade = $fkDividaModalidadeVigencia->getCodModalidade();
        $this->timestampModalidade = $fkDividaModalidadeVigencia->getTimestamp();
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

    /**
     * OneToOne (inverse side)
     * Set DividaParcelamentoCancelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelamentoCancelamento $fkDividaParcelamentoCancelamento
     * @return Parcelamento
     */
    public function setFkDividaParcelamentoCancelamento(\Urbem\CoreBundle\Entity\Divida\ParcelamentoCancelamento $fkDividaParcelamentoCancelamento)
    {
        $fkDividaParcelamentoCancelamento->setFkDividaParcelamento($this);
        $this->fkDividaParcelamentoCancelamento = $fkDividaParcelamentoCancelamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkDividaParcelamentoCancelamento
     *
     * @return \Urbem\CoreBundle\Entity\Divida\ParcelamentoCancelamento
     */
    public function getFkDividaParcelamentoCancelamento()
    {
        return $this->fkDividaParcelamentoCancelamento;
    }
}
