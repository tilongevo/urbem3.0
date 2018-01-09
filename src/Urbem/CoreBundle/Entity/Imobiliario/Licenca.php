<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Licenca
 */
class Licenca
{
    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento
     */
    private $fkImobiliarioLicencaDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa
     */
    private $fkImobiliarioLicencaBaixas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaLote
     */
    private $fkImobiliarioLicencaLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico
     */
    private $fkImobiliarioLicencaResponsavelTecnicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaProcesso
     */
    private $fkImobiliarioLicencaProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel
     */
    private $fkImobiliarioLicencaImoveis;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Permissao
     */
    private $fkImobiliarioPermissao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioLicencaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaBaixas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaResponsavelTecnicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaImoveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return Licenca
     */
    public function setCodLicenca($codLicenca)
    {
        $this->codLicenca = $codLicenca;
        return $this;
    }

    /**
     * Get codLicenca
     *
     * @return integer
     */
    public function getCodLicenca()
    {
        return $this->codLicenca;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Licenca
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Licenca
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Licenca
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Licenca
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
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return Licenca
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return Licenca
     */
    public function setDtTermino(\DateTime $dtTermino = null)
    {
        $this->dtTermino = $dtTermino;
        return $this;
    }

    /**
     * Get dtTermino
     *
     * @return \DateTime
     */
    public function getDtTermino()
    {
        return $this->dtTermino;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return Licenca
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento $fkImobiliarioLicencaDocumento
     * @return Licenca
     */
    public function addFkImobiliarioLicencaDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento $fkImobiliarioLicencaDocumento)
    {
        if (false === $this->fkImobiliarioLicencaDocumentos->contains($fkImobiliarioLicencaDocumento)) {
            $fkImobiliarioLicencaDocumento->setFkImobiliarioLicenca($this);
            $this->fkImobiliarioLicencaDocumentos->add($fkImobiliarioLicencaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento $fkImobiliarioLicencaDocumento
     */
    public function removeFkImobiliarioLicencaDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento $fkImobiliarioLicencaDocumento)
    {
        $this->fkImobiliarioLicencaDocumentos->removeElement($fkImobiliarioLicencaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento
     */
    public function getFkImobiliarioLicencaDocumentos()
    {
        return $this->fkImobiliarioLicencaDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa $fkImobiliarioLicencaBaixa
     * @return Licenca
     */
    public function addFkImobiliarioLicencaBaixas(\Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa $fkImobiliarioLicencaBaixa)
    {
        if (false === $this->fkImobiliarioLicencaBaixas->contains($fkImobiliarioLicencaBaixa)) {
            $fkImobiliarioLicencaBaixa->setFkImobiliarioLicenca($this);
            $this->fkImobiliarioLicencaBaixas->add($fkImobiliarioLicencaBaixa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa $fkImobiliarioLicencaBaixa
     */
    public function removeFkImobiliarioLicencaBaixas(\Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa $fkImobiliarioLicencaBaixa)
    {
        $this->fkImobiliarioLicencaBaixas->removeElement($fkImobiliarioLicencaBaixa);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaBaixas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa
     */
    public function getFkImobiliarioLicencaBaixas()
    {
        return $this->fkImobiliarioLicencaBaixas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote
     * @return Licenca
     */
    public function addFkImobiliarioLicencaLotes(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote)
    {
        if (false === $this->fkImobiliarioLicencaLotes->contains($fkImobiliarioLicencaLote)) {
            $fkImobiliarioLicencaLote->setFkImobiliarioLicenca($this);
            $this->fkImobiliarioLicencaLotes->add($fkImobiliarioLicencaLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote
     */
    public function removeFkImobiliarioLicencaLotes(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote)
    {
        $this->fkImobiliarioLicencaLotes->removeElement($fkImobiliarioLicencaLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaLote
     */
    public function getFkImobiliarioLicencaLotes()
    {
        return $this->fkImobiliarioLicencaLotes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico $fkImobiliarioLicencaResponsavelTecnico
     * @return Licenca
     */
    public function addFkImobiliarioLicencaResponsavelTecnicos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico $fkImobiliarioLicencaResponsavelTecnico)
    {
        if (false === $this->fkImobiliarioLicencaResponsavelTecnicos->contains($fkImobiliarioLicencaResponsavelTecnico)) {
            $fkImobiliarioLicencaResponsavelTecnico->setFkImobiliarioLicenca($this);
            $this->fkImobiliarioLicencaResponsavelTecnicos->add($fkImobiliarioLicencaResponsavelTecnico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico $fkImobiliarioLicencaResponsavelTecnico
     */
    public function removeFkImobiliarioLicencaResponsavelTecnicos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico $fkImobiliarioLicencaResponsavelTecnico)
    {
        $this->fkImobiliarioLicencaResponsavelTecnicos->removeElement($fkImobiliarioLicencaResponsavelTecnico);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaResponsavelTecnicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico
     */
    public function getFkImobiliarioLicencaResponsavelTecnicos()
    {
        return $this->fkImobiliarioLicencaResponsavelTecnicos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaProcesso $fkImobiliarioLicencaProcesso
     * @return Licenca
     */
    public function addFkImobiliarioLicencaProcessos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaProcesso $fkImobiliarioLicencaProcesso)
    {
        if (false === $this->fkImobiliarioLicencaProcessos->contains($fkImobiliarioLicencaProcesso)) {
            $fkImobiliarioLicencaProcesso->setFkImobiliarioLicenca($this);
            $this->fkImobiliarioLicencaProcessos->add($fkImobiliarioLicencaProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaProcesso $fkImobiliarioLicencaProcesso
     */
    public function removeFkImobiliarioLicencaProcessos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaProcesso $fkImobiliarioLicencaProcesso)
    {
        $this->fkImobiliarioLicencaProcessos->removeElement($fkImobiliarioLicencaProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaProcesso
     */
    public function getFkImobiliarioLicencaProcessos()
    {
        return $this->fkImobiliarioLicencaProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel $fkImobiliarioLicencaImovel
     * @return Licenca
     */
    public function addFkImobiliarioLicencaImoveis(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel $fkImobiliarioLicencaImovel)
    {
        if (false === $this->fkImobiliarioLicencaImoveis->contains($fkImobiliarioLicencaImovel)) {
            $fkImobiliarioLicencaImovel->setFkImobiliarioLicenca($this);
            $this->fkImobiliarioLicencaImoveis->add($fkImobiliarioLicencaImovel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel $fkImobiliarioLicencaImovel
     */
    public function removeFkImobiliarioLicencaImoveis(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel $fkImobiliarioLicencaImovel)
    {
        $this->fkImobiliarioLicencaImoveis->removeElement($fkImobiliarioLicencaImovel);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaImoveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel
     */
    public function getFkImobiliarioLicencaImoveis()
    {
        return $this->fkImobiliarioLicencaImoveis;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Permissao $fkImobiliarioPermissao
     * @return Licenca
     */
    public function setFkImobiliarioPermissao(\Urbem\CoreBundle\Entity\Imobiliario\Permissao $fkImobiliarioPermissao)
    {
        $this->codTipo = $fkImobiliarioPermissao->getCodTipo();
        $this->numcgm = $fkImobiliarioPermissao->getNumcgm();
        $this->timestamp = $fkImobiliarioPermissao->getTimestamp();
        $this->fkImobiliarioPermissao = $fkImobiliarioPermissao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioPermissao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Permissao
     */
    public function getFkImobiliarioPermissao()
    {
        return $this->fkImobiliarioPermissao;
    }

    /**
     * @return mixed
     */
    public function getOrigem()
    {
        return ($this->fkImobiliarioLicencaImoveis->count())
            ? $this->fkImobiliarioLicencaImoveis->last()->getFkImobiliarioImovel()
            : $this->fkImobiliarioLicencaLotes->last()->getFkImobiliarioLote()->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->codLicenca, $this->exercicio);
    }
}
