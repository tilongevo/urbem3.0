<?php

namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * Edital
 */
class Edital
{
    /**
     * PK
     * @var integer
     */
    private $numEdital;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $exercicioLicitacao;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codModalidade;

    /**
     * @var integer
     */
    private $codLicitacao;

    /**
     * @var \DateTime
     */
    private $dtEntregaPropostas;

    /**
     * @var string
     */
    private $horaEntregaPropostas;

    /**
     * @var string
     */
    private $localEntregaPropostas;

    /**
     * @var string
     */
    private $localAberturaPropostas;

    /**
     * @var \DateTime
     */
    private $dtAberturaPropostas;

    /**
     * @var string
     */
    private $horaAberturaPropostas;

    /**
     * @var string
     */
    private $localEntregaMaterial;

    /**
     * @var \DateTime
     */
    private $dtValidadeProposta;

    /**
     * @var string
     */
    private $observacaoValidadeProposta;

    /**
     * @var string
     */
    private $condicoesPagamento;

    /**
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var \DateTime
     */
    private $dtAprovacaoJuridico;

    /**
     * @var integer
     */
    private $responsavelJuridico;

    /**
     * @var \DateTime
     */
    private $dtFinalEntregaPropostas;

    /**
     * @var string
     */
    private $horaFinalEntregaPropostas;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\EditalAnulado
     */
    private $fkLicitacaoEditalAnulado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\EditalSuspenso
     */
    private $fkLicitacaoEditalSuspenso;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Ata
     */
    private $fkLicitacaoAtas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado
     */
    private $fkLicitacaoEditalImpugnados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital
     */
    private $fkLicitacaoPublicacaoEditais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoAtas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoEditalImpugnados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoPublicacaoEditais = new \Doctrine\Common\Collections\ArrayCollection();

        $this->codTipoDocumento = 0;
        $this->codDocumento = 0;
    }

    /**
     * Set numEdital
     *
     * @param integer $numEdital
     * @return Edital
     */
    public function setNumEdital($numEdital)
    {
        $this->numEdital = $numEdital;
        return $this;
    }

    /**
     * Get numEdital
     *
     * @return integer
     */
    public function getNumEdital()
    {
        return $this->numEdital;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Edital
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
     * Set exercicioLicitacao
     *
     * @param string $exercicioLicitacao
     * @return Edital
     */
    public function setExercicioLicitacao($exercicioLicitacao)
    {
        $this->exercicioLicitacao = $exercicioLicitacao;
        return $this;
    }

    /**
     * Get exercicioLicitacao
     *
     * @return string
     */
    public function getExercicioLicitacao()
    {
        return $this->exercicioLicitacao;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Edital
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return Edital
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
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return Edital
     */
    public function setCodLicitacao($codLicitacao)
    {
        $this->codLicitacao = $codLicitacao;
        return $this;
    }

    /**
     * Get codLicitacao
     *
     * @return integer
     */
    public function getCodLicitacao()
    {
        return $this->codLicitacao;
    }

    /**
     * Set dtEntregaPropostas
     *
     * @param \DateTime $dtEntregaPropostas
     * @return Edital
     */
    public function setDtEntregaPropostas(\DateTime $dtEntregaPropostas)
    {
        $this->dtEntregaPropostas = $dtEntregaPropostas;
        return $this;
    }

    /**
     * Get dtEntregaPropostas
     *
     * @return \DateTime
     */
    public function getDtEntregaPropostas()
    {
        return $this->dtEntregaPropostas;
    }

    /**
     * Set horaEntregaPropostas
     *
     * @param string $horaEntregaPropostas
     * @return Edital
     */
    public function setHoraEntregaPropostas($horaEntregaPropostas)
    {
        $this->horaEntregaPropostas = $horaEntregaPropostas;
        return $this;
    }

    /**
     * Get horaEntregaPropostas
     *
     * @return string
     */
    public function getHoraEntregaPropostas()
    {
        return $this->horaEntregaPropostas;
    }

    /**
     * Set localEntregaPropostas
     *
     * @param string $localEntregaPropostas
     * @return Edital
     */
    public function setLocalEntregaPropostas($localEntregaPropostas)
    {
        $this->localEntregaPropostas = $localEntregaPropostas;
        return $this;
    }

    /**
     * Get localEntregaPropostas
     *
     * @return string
     */
    public function getLocalEntregaPropostas()
    {
        return $this->localEntregaPropostas;
    }

    /**
     * Set localAberturaPropostas
     *
     * @param string $localAberturaPropostas
     * @return Edital
     */
    public function setLocalAberturaPropostas($localAberturaPropostas)
    {
        $this->localAberturaPropostas = $localAberturaPropostas;
        return $this;
    }

    /**
     * Get localAberturaPropostas
     *
     * @return string
     */
    public function getLocalAberturaPropostas()
    {
        return $this->localAberturaPropostas;
    }

    /**
     * Set dtAberturaPropostas
     *
     * @param \DateTime $dtAberturaPropostas
     * @return Edital
     */
    public function setDtAberturaPropostas(\DateTime $dtAberturaPropostas)
    {
        $this->dtAberturaPropostas = $dtAberturaPropostas;
        return $this;
    }

    /**
     * Get dtAberturaPropostas
     *
     * @return \DateTime
     */
    public function getDtAberturaPropostas()
    {
        return $this->dtAberturaPropostas;
    }

    /**
     * Set horaAberturaPropostas
     *
     * @param string $horaAberturaPropostas
     * @return Edital
     */
    public function setHoraAberturaPropostas($horaAberturaPropostas)
    {
        $this->horaAberturaPropostas = $horaAberturaPropostas;
        return $this;
    }

    /**
     * Get horaAberturaPropostas
     *
     * @return string
     */
    public function getHoraAberturaPropostas()
    {
        return $this->horaAberturaPropostas;
    }

    /**
     * Set localEntregaMaterial
     *
     * @param string $localEntregaMaterial
     * @return Edital
     */
    public function setLocalEntregaMaterial($localEntregaMaterial)
    {
        $this->localEntregaMaterial = $localEntregaMaterial;
        return $this;
    }

    /**
     * Get localEntregaMaterial
     *
     * @return string
     */
    public function getLocalEntregaMaterial()
    {
        return $this->localEntregaMaterial;
    }

    /**
     * Set dtValidadeProposta
     *
     * @param \DateTime $dtValidadeProposta
     * @return Edital
     */
    public function setDtValidadeProposta(\DateTime $dtValidadeProposta)
    {
        $this->dtValidadeProposta = $dtValidadeProposta;
        return $this;
    }

    /**
     * Get dtValidadeProposta
     *
     * @return \DateTime
     */
    public function getDtValidadeProposta()
    {
        return $this->dtValidadeProposta;
    }

    /**
     * Set observacaoValidadeProposta
     *
     * @param string $observacaoValidadeProposta
     * @return Edital
     */
    public function setObservacaoValidadeProposta($observacaoValidadeProposta = null)
    {
        $this->observacaoValidadeProposta = $observacaoValidadeProposta;
        return $this;
    }

    /**
     * Get observacaoValidadeProposta
     *
     * @return string
     */
    public function getObservacaoValidadeProposta()
    {
        return $this->observacaoValidadeProposta;
    }

    /**
     * Set condicoesPagamento
     *
     * @param string $condicoesPagamento
     * @return Edital
     */
    public function setCondicoesPagamento($condicoesPagamento)
    {
        $this->condicoesPagamento = $condicoesPagamento;
        return $this;
    }

    /**
     * Get condicoesPagamento
     *
     * @return string
     */
    public function getCondicoesPagamento()
    {
        return $this->condicoesPagamento;
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return Edital
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
     * @return Edital
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
     * Set dtAprovacaoJuridico
     *
     * @param \DateTime $dtAprovacaoJuridico
     * @return Edital
     */
    public function setDtAprovacaoJuridico(\DateTime $dtAprovacaoJuridico)
    {
        $this->dtAprovacaoJuridico = $dtAprovacaoJuridico;
        return $this;
    }

    /**
     * Get dtAprovacaoJuridico
     *
     * @return \DateTime
     */
    public function getDtAprovacaoJuridico()
    {
        return $this->dtAprovacaoJuridico;
    }

    /**
     * Set responsavelJuridico
     *
     * @param integer $responsavelJuridico
     * @return Edital
     */
    public function setResponsavelJuridico($responsavelJuridico)
    {
        $this->responsavelJuridico = $responsavelJuridico;
        return $this;
    }

    /**
     * Get responsavelJuridico
     *
     * @return integer
     */
    public function getResponsavelJuridico()
    {
        return $this->responsavelJuridico;
    }

    /**
     * Set dtFinalEntregaPropostas
     *
     * @param \DateTime $dtFinalEntregaPropostas
     * @return Edital
     */
    public function setDtFinalEntregaPropostas(\DateTime $dtFinalEntregaPropostas = null)
    {
        $this->dtFinalEntregaPropostas = $dtFinalEntregaPropostas;
        return $this;
    }

    /**
     * Get dtFinalEntregaPropostas
     *
     * @return \DateTime
     */
    public function getDtFinalEntregaPropostas()
    {
        return $this->dtFinalEntregaPropostas;
    }

    /**
     * Set horaFinalEntregaPropostas
     *
     * @param string $horaFinalEntregaPropostas
     * @return Edital
     */
    public function setHoraFinalEntregaPropostas($horaFinalEntregaPropostas = null)
    {
        $this->horaFinalEntregaPropostas = $horaFinalEntregaPropostas;
        return $this;
    }

    /**
     * Get horaFinalEntregaPropostas
     *
     * @return string
     */
    public function getHoraFinalEntregaPropostas()
    {
        return $this->horaFinalEntregaPropostas;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoAta
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Ata $fkLicitacaoAta
     * @return Edital
     */
    public function addFkLicitacaoAtas(\Urbem\CoreBundle\Entity\Licitacao\Ata $fkLicitacaoAta)
    {
        if (false === $this->fkLicitacaoAtas->contains($fkLicitacaoAta)) {
            $fkLicitacaoAta->setFkLicitacaoEdital($this);
            $this->fkLicitacaoAtas->add($fkLicitacaoAta);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoAta
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Ata $fkLicitacaoAta
     */
    public function removeFkLicitacaoAtas(\Urbem\CoreBundle\Entity\Licitacao\Ata $fkLicitacaoAta)
    {
        $this->fkLicitacaoAtas->removeElement($fkLicitacaoAta);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoAtas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Ata
     */
    public function getFkLicitacaoAtas()
    {
        return $this->fkLicitacaoAtas;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoEditalImpugnado
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado $fkLicitacaoEditalImpugnado
     * @return Edital
     */
    public function addFkLicitacaoEditalImpugnados(\Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado $fkLicitacaoEditalImpugnado)
    {
        if (false === $this->fkLicitacaoEditalImpugnados->contains($fkLicitacaoEditalImpugnado)) {
            $fkLicitacaoEditalImpugnado->setFkLicitacaoEdital($this);
            $this->fkLicitacaoEditalImpugnados->add($fkLicitacaoEditalImpugnado);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoEditalImpugnado
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado $fkLicitacaoEditalImpugnado
     */
    public function removeFkLicitacaoEditalImpugnados(\Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado $fkLicitacaoEditalImpugnado)
    {
        $this->fkLicitacaoEditalImpugnados->removeElement($fkLicitacaoEditalImpugnado);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoEditalImpugnados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado
     */
    public function getFkLicitacaoEditalImpugnados()
    {
        return $this->fkLicitacaoEditalImpugnados;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoPublicacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital $fkLicitacaoPublicacaoEdital
     * @return Edital
     */
    public function addFkLicitacaoPublicacaoEditais(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital $fkLicitacaoPublicacaoEdital)
    {
        if (false === $this->fkLicitacaoPublicacaoEditais->contains($fkLicitacaoPublicacaoEdital)) {
            $fkLicitacaoPublicacaoEdital->setFkLicitacaoEdital($this);
            $this->fkLicitacaoPublicacaoEditais->add($fkLicitacaoPublicacaoEdital);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital $fkLicitacaoPublicacaoEdital
     */
    public function removeFkLicitacaoPublicacaoEditais(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital $fkLicitacaoPublicacaoEdital)
    {
        $this->fkLicitacaoPublicacaoEditais->removeElement($fkLicitacaoPublicacaoEdital);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoEditais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital
     */
    public function getFkLicitacaoPublicacaoEditais()
    {
        return $this->fkLicitacaoPublicacaoEditais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return Edital
     */
    public function setFkLicitacaoLicitacao(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->codLicitacao = $fkLicitacaoLicitacao->getCodLicitacao();
        $this->codModalidade = $fkLicitacaoLicitacao->getCodModalidade();
        $this->codEntidade = $fkLicitacaoLicitacao->getCodEntidade();
        $this->exercicioLicitacao = $fkLicitacaoLicitacao->getExercicio();
        $this->fkLicitacaoLicitacao = $fkLicitacaoLicitacao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacao()
    {
        return $this->fkLicitacaoLicitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return Edital
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
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Edital
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->responsavelJuridico = $fkSwCgm->getNumcgm();
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
     * OneToOne (inverse side)
     * Set LicitacaoEditalAnulado
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\EditalAnulado $fkLicitacaoEditalAnulado
     * @return Edital
     */
    public function setFkLicitacaoEditalAnulado(\Urbem\CoreBundle\Entity\Licitacao\EditalAnulado $fkLicitacaoEditalAnulado)
    {
        $fkLicitacaoEditalAnulado->setFkLicitacaoEdital($this);
        $this->fkLicitacaoEditalAnulado = $fkLicitacaoEditalAnulado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoEditalAnulado
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\EditalAnulado
     */
    public function getFkLicitacaoEditalAnulado()
    {
        return $this->fkLicitacaoEditalAnulado;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoEditalSuspenso
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\EditalSuspenso $fkLicitacaoEditalSuspenso
     * @return Edital
     */
    public function setFkLicitacaoEditalSuspenso(\Urbem\CoreBundle\Entity\Licitacao\EditalSuspenso $fkLicitacaoEditalSuspenso)
    {
        $fkLicitacaoEditalSuspenso->setFkLicitacaoEdital($this);
        $this->fkLicitacaoEditalSuspenso = $fkLicitacaoEditalSuspenso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoEditalSuspenso
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\EditalSuspenso
     */
    public function getFkLicitacaoEditalSuspenso()
    {
        return $this->fkLicitacaoEditalSuspenso;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (is_null($this->numEdital)) {
            return "Edital";
        } else {
            return "{$this->numEdital}/{$this->exercicio}";
        }
    }
}
