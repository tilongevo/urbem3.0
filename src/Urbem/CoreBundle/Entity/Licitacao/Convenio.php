<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * Convenio
 */
class Convenio
{
    /**
     * PK
     * @var integer
     */
    private $numConvenio;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $cgmResponsavel;

    /**
     * @var integer
     */
    private $codObjeto;

    /**
     * @var integer
     */
    private $codTipoConvenio;

    /**
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var \DateTime
     */
    private $dtAssinatura;

    /**
     * @var \DateTime
     */
    private $dtVigencia;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var \DateTime
     */
    private $inicioExecucao;

    /**
     * @var string
     */
    private $fundamentacao;

    /**
     * @var integer
     */
    private $codNormaAutorizativa;

    /**
     * @var integer
     */
    private $codUfTipoConvenio;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\ConvenioAnulado
     */
    private $fkLicitacaoConvenioAnulado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio
     */
    private $fkLicitacaoRescisaoConvenio;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceam\EsferaConvenio
     */
    private $fkTceamEsferaConvenio;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoConvenio
     */
    private $fkComprasSolicitacaoConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio
     */
    private $fkEmpenhoEmpenhoConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos
     */
    private $fkLicitacaoConvenioAditivos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio
     */
    private $fkLicitacaoParticipanteConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoConvenio
     */
    private $fkLicitacaoPublicacaoConvenios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    private $fkComprasObjeto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\TipoConvenio
     */
    private $fkLicitacaoTipoConvenio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasSolicitacaoConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoEmpenhoConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoConvenioAditivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoParticipanteConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoPublicacaoConvenios = new \Doctrine\Common\Collections\ArrayCollection();

        // TODO: Gera um arquivo ODT
        $this->codTipoDocumento = 0;
        $this->codDocumento = 0;
    }

    /**
     * Set numConvenio
     *
     * @param integer $numConvenio
     * @return Convenio
     */
    public function setNumConvenio($numConvenio)
    {
        $this->numConvenio = $numConvenio;
        return $this;
    }

    /**
     * Get numConvenio
     *
     * @return integer
     */
    public function getNumConvenio()
    {
        return $this->numConvenio;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Convenio
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
     * Set cgmResponsavel
     *
     * @param integer $cgmResponsavel
     * @return Convenio
     */
    public function setCgmResponsavel($cgmResponsavel)
    {
        $this->cgmResponsavel = $cgmResponsavel;
        return $this;
    }

    /**
     * Get cgmResponsavel
     *
     * @return integer
     */
    public function getCgmResponsavel()
    {
        return $this->cgmResponsavel;
    }

    /**
     * Set codObjeto
     *
     * @param integer $codObjeto
     * @return Convenio
     */
    public function setCodObjeto($codObjeto)
    {
        $this->codObjeto = $codObjeto;
        return $this;
    }

    /**
     * Get codObjeto
     *
     * @return integer
     */
    public function getCodObjeto()
    {
        return $this->codObjeto;
    }

    /**
     * Set codTipoConvenio
     *
     * @param integer $codTipoConvenio
     * @return Convenio
     */
    public function setCodTipoConvenio($codTipoConvenio)
    {
        $this->codTipoConvenio = $codTipoConvenio;
        return $this;
    }

    /**
     * Get codTipoConvenio
     *
     * @return integer
     */
    public function getCodTipoConvenio()
    {
        return $this->codTipoConvenio;
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return Convenio
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return Convenio
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return Convenio
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
     * Set dtAssinatura
     *
     * @param \DateTime $dtAssinatura
     * @return Convenio
     */
    public function setDtAssinatura(\DateTime $dtAssinatura)
    {
        $this->dtAssinatura = $dtAssinatura;
        return $this;
    }

    /**
     * Get dtAssinatura
     *
     * @return \DateTime
     */
    public function getDtAssinatura()
    {
        return $this->dtAssinatura;
    }

    /**
     * Set dtVigencia
     *
     * @param \DateTime $dtVigencia
     * @return Convenio
     */
    public function setDtVigencia(\DateTime $dtVigencia)
    {
        $this->dtVigencia = $dtVigencia;
        return $this;
    }

    /**
     * Get dtVigencia
     *
     * @return \DateTime
     */
    public function getDtVigencia()
    {
        return $this->dtVigencia;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return Convenio
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set inicioExecucao
     *
     * @param \DateTime $inicioExecucao
     * @return Convenio
     */
    public function setInicioExecucao(\DateTime $inicioExecucao)
    {
        $this->inicioExecucao = $inicioExecucao;
        return $this;
    }

    /**
     * Get inicioExecucao
     *
     * @return \DateTime
     */
    public function getInicioExecucao()
    {
        return $this->inicioExecucao;
    }

    /**
     * Set fundamentacao
     *
     * @param string $fundamentacao
     * @return Convenio
     */
    public function setFundamentacao($fundamentacao)
    {
        $this->fundamentacao = $fundamentacao;
        return $this;
    }

    /**
     * Get fundamentacao
     *
     * @return string
     */
    public function getFundamentacao()
    {
        return $this->fundamentacao;
    }

    /**
     * Set codNormaAutorizativa
     *
     * @param integer $codNormaAutorizativa
     * @return Convenio
     */
    public function setCodNormaAutorizativa($codNormaAutorizativa)
    {
        $this->codNormaAutorizativa = $codNormaAutorizativa;
        return $this;
    }

    /**
     * Get codNormaAutorizativa
     *
     * @return integer
     */
    public function getCodNormaAutorizativa()
    {
        return $this->codNormaAutorizativa;
    }

    /**
     * Set codUfTipoConvenio
     *
     * @param integer $codUfTipoConvenio
     * @return Convenio
     */
    public function setCodUfTipoConvenio($codUfTipoConvenio)
    {
        $this->codUfTipoConvenio = $codUfTipoConvenio;
        return $this;
    }

    /**
     * Get codUfTipoConvenio
     *
     * @return integer
     */
    public function getCodUfTipoConvenio()
    {
        return $this->codUfTipoConvenio;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoConvenio $fkComprasSolicitacaoConvenio
     * @return Convenio
     */
    public function addFkComprasSolicitacaoConvenios(\Urbem\CoreBundle\Entity\Compras\SolicitacaoConvenio $fkComprasSolicitacaoConvenio)
    {
        if (false === $this->fkComprasSolicitacaoConvenios->contains($fkComprasSolicitacaoConvenio)) {
            $fkComprasSolicitacaoConvenio->setFkLicitacaoConvenio($this);
            $this->fkComprasSolicitacaoConvenios->add($fkComprasSolicitacaoConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoConvenio $fkComprasSolicitacaoConvenio
     */
    public function removeFkComprasSolicitacaoConvenios(\Urbem\CoreBundle\Entity\Compras\SolicitacaoConvenio $fkComprasSolicitacaoConvenio)
    {
        $this->fkComprasSolicitacaoConvenios->removeElement($fkComprasSolicitacaoConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoConvenio
     */
    public function getFkComprasSolicitacaoConvenios()
    {
        return $this->fkComprasSolicitacaoConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoEmpenhoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio $fkEmpenhoEmpenhoConvenio
     * @return Convenio
     */
    public function addFkEmpenhoEmpenhoConvenios(\Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio $fkEmpenhoEmpenhoConvenio)
    {
        if (false === $this->fkEmpenhoEmpenhoConvenios->contains($fkEmpenhoEmpenhoConvenio)) {
            $fkEmpenhoEmpenhoConvenio->setFkLicitacaoConvenio($this);
            $this->fkEmpenhoEmpenhoConvenios->add($fkEmpenhoEmpenhoConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoEmpenhoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio $fkEmpenhoEmpenhoConvenio
     */
    public function removeFkEmpenhoEmpenhoConvenios(\Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio $fkEmpenhoEmpenhoConvenio)
    {
        $this->fkEmpenhoEmpenhoConvenios->removeElement($fkEmpenhoEmpenhoConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoEmpenhoConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio
     */
    public function getFkEmpenhoEmpenhoConvenios()
    {
        return $this->fkEmpenhoEmpenhoConvenios;
    }

    /**
     * @param $fkEmpenhoEmpenhoConvenios
     */
    public function setFkEmpenhoEmpenhoConvenios($fkEmpenhoEmpenhoConvenios)
    {
        foreach ($fkEmpenhoEmpenhoConvenios as $fkEmpenhoEmpenhoConvenio) {
            $this->addFkEmpenhoEmpenhoConvenios($fkEmpenhoEmpenhoConvenio);
        }
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoConvenioAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos $fkLicitacaoConvenioAditivos
     * @return Convenio
     */
    public function addFkLicitacaoConvenioAditivos(\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos $fkLicitacaoConvenioAditivos)
    {
        if (false === $this->fkLicitacaoConvenioAditivos->contains($fkLicitacaoConvenioAditivos)) {
            $fkLicitacaoConvenioAditivos->setFkLicitacaoConvenio($this);
            $this->fkLicitacaoConvenioAditivos->add($fkLicitacaoConvenioAditivos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoConvenioAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos $fkLicitacaoConvenioAditivos
     */
    public function removeFkLicitacaoConvenioAditivos(\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos $fkLicitacaoConvenioAditivos)
    {
        $this->fkLicitacaoConvenioAditivos->removeElement($fkLicitacaoConvenioAditivos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoConvenioAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos
     */
    public function getFkLicitacaoConvenioAditivos()
    {
        return $this->fkLicitacaoConvenioAditivos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoParticipanteConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio $fkLicitacaoParticipanteConvenio
     * @return Convenio
     */
    public function addFkLicitacaoParticipanteConvenios(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio $fkLicitacaoParticipanteConvenio)
    {
        if (false === $this->fkLicitacaoParticipanteConvenios->contains($fkLicitacaoParticipanteConvenio)) {
            $fkLicitacaoParticipanteConvenio->setFkLicitacaoConvenio($this);
            $this->fkLicitacaoParticipanteConvenios->add($fkLicitacaoParticipanteConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipanteConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio $fkLicitacaoParticipanteConvenio
     */
    public function removeFkLicitacaoParticipanteConvenios(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio $fkLicitacaoParticipanteConvenio)
    {
        $this->fkLicitacaoParticipanteConvenios->removeElement($fkLicitacaoParticipanteConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipanteConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio
     */
    public function getFkLicitacaoParticipanteConvenios()
    {
        return $this->fkLicitacaoParticipanteConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoPublicacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoConvenio $fkLicitacaoPublicacaoConvenio
     * @return Convenio
     */
    public function addFkLicitacaoPublicacaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoConvenio $fkLicitacaoPublicacaoConvenio)
    {
        if (false === $this->fkLicitacaoPublicacaoConvenios->contains($fkLicitacaoPublicacaoConvenio)) {
            $fkLicitacaoPublicacaoConvenio->setFkLicitacaoConvenio($this);
            $this->fkLicitacaoPublicacaoConvenios->add($fkLicitacaoPublicacaoConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoConvenio $fkLicitacaoPublicacaoConvenio
     */
    public function removeFkLicitacaoPublicacaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoConvenio $fkLicitacaoPublicacaoConvenio)
    {
        $this->fkLicitacaoPublicacaoConvenios->removeElement($fkLicitacaoPublicacaoConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoConvenio
     */
    public function getFkLicitacaoPublicacaoConvenios()
    {
        return $this->fkLicitacaoPublicacaoConvenios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Convenio
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmResponsavel = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasObjeto
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Objeto $fkComprasObjeto
     * @return Convenio
     */
    public function setFkComprasObjeto(\Urbem\CoreBundle\Entity\Compras\Objeto $fkComprasObjeto)
    {
        $this->codObjeto = $fkComprasObjeto->getCodObjeto();
        $this->fkComprasObjeto = $fkComprasObjeto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasObjeto
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    public function getFkComprasObjeto()
    {
        return $this->fkComprasObjeto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoTipoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\TipoConvenio $fkLicitacaoTipoConvenio
     * @return Convenio
     */
    public function setFkLicitacaoTipoConvenio(\Urbem\CoreBundle\Entity\Licitacao\TipoConvenio $fkLicitacaoTipoConvenio)
    {
        $this->codTipoConvenio = $fkLicitacaoTipoConvenio->getCodTipoConvenio();
        $this->codUfTipoConvenio = $fkLicitacaoTipoConvenio->getCodUfTipoConvenio();
        $this->fkLicitacaoTipoConvenio = $fkLicitacaoTipoConvenio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoTipoConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\TipoConvenio
     */
    public function getFkLicitacaoTipoConvenio()
    {
        return $this->fkLicitacaoTipoConvenio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return Convenio
     */
    public function setFkAdministracaoModeloDocumento(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->codDocumento = $fkAdministracaoModeloDocumento->getCodDocumento();
        $this->codTipoDocumento = $fkAdministracaoModeloDocumento->getCodTipoDocumento();
        $this->fkAdministracaoModeloDocumento = $fkAdministracaoModeloDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModeloDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    public function getFkAdministracaoModeloDocumento()
    {
        return $this->fkAdministracaoModeloDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Convenio
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNormaAutorizativa = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoConvenioAnulado
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ConvenioAnulado $fkLicitacaoConvenioAnulado
     * @return Convenio
     */
    public function setFkLicitacaoConvenioAnulado(\Urbem\CoreBundle\Entity\Licitacao\ConvenioAnulado $fkLicitacaoConvenioAnulado)
    {
        $fkLicitacaoConvenioAnulado->setFkLicitacaoConvenio($this);
        $this->fkLicitacaoConvenioAnulado = $fkLicitacaoConvenioAnulado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoConvenioAnulado
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ConvenioAnulado
     */
    public function getFkLicitacaoConvenioAnulado()
    {
        return $this->fkLicitacaoConvenioAnulado;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoRescisaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio $fkLicitacaoRescisaoConvenio
     * @return Convenio
     */
    public function setFkLicitacaoRescisaoConvenio(\Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio $fkLicitacaoRescisaoConvenio)
    {
        $fkLicitacaoRescisaoConvenio->setFkLicitacaoConvenio($this);
        $this->fkLicitacaoRescisaoConvenio = $fkLicitacaoRescisaoConvenio;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoRescisaoConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio
     */
    public function getFkLicitacaoRescisaoConvenio()
    {
        return $this->fkLicitacaoRescisaoConvenio;
    }

    /**
     * OneToOne (inverse side)
     * Set TceamEsferaConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\EsferaConvenio $fkTceamEsferaConvenio
     * @return Convenio
     */
    public function setFkTceamEsferaConvenio(\Urbem\CoreBundle\Entity\Tceam\EsferaConvenio $fkTceamEsferaConvenio)
    {
        $fkTceamEsferaConvenio->setFkLicitacaoConvenio($this);
        $this->fkTceamEsferaConvenio = $fkTceamEsferaConvenio;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTceamEsferaConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Tceam\EsferaConvenio
     */
    public function getFkTceamEsferaConvenio()
    {
        return $this->fkTceamEsferaConvenio;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->numConvenio.'/'.$this->exercicio;
    }
}
