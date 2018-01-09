<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * RescisaoConvenio
 */
class RescisaoConvenio
{
    /**
     * PK
     * @var string
     */
    private $exercicioConvenio;

    /**
     * PK
     * @var integer
     */
    private $numConvenio;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $numRescisao;

    /**
     * @var integer
     */
    private $responsavelJuridico;

    /**
     * @var \DateTime
     */
    private $dtRescisao;

    /**
     * @var integer
     */
    private $vlrMulta = 0;

    /**
     * @var integer
     */
    private $vlrIndenizacao = 0;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    private $fkLicitacaoConvenio;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio
     */
    private $fkLicitacaoPublicacaoRescisaoConvenios;

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
        $this->fkLicitacaoPublicacaoRescisaoConvenios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicioConvenio
     *
     * @param string $exercicioConvenio
     * @return RescisaoConvenio
     */
    public function setExercicioConvenio($exercicioConvenio)
    {
        $this->exercicioConvenio = $exercicioConvenio;
        return $this;
    }

    /**
     * Get exercicioConvenio
     *
     * @return string
     */
    public function getExercicioConvenio()
    {
        return $this->exercicioConvenio;
    }

    /**
     * Set numConvenio
     *
     * @param integer $numConvenio
     * @return RescisaoConvenio
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
     * @return RescisaoConvenio
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
     * Set numRescisao
     *
     * @param integer $numRescisao
     * @return RescisaoConvenio
     */
    public function setNumRescisao($numRescisao)
    {
        $this->numRescisao = $numRescisao;
        return $this;
    }

    /**
     * Get numRescisao
     *
     * @return integer
     */
    public function getNumRescisao()
    {
        return $this->numRescisao;
    }

    /**
     * Set responsavelJuridico
     *
     * @param integer $responsavelJuridico
     * @return RescisaoConvenio
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
     * Set dtRescisao
     *
     * @param \DateTime $dtRescisao
     * @return RescisaoConvenio
     */
    public function setDtRescisao(\DateTime $dtRescisao)
    {
        $this->dtRescisao = $dtRescisao;
        return $this;
    }

    /**
     * Get dtRescisao
     *
     * @return \DateTime
     */
    public function getDtRescisao()
    {
        return $this->dtRescisao;
    }

    /**
     * Set vlrMulta
     *
     * @param integer $vlrMulta
     * @return RescisaoConvenio
     */
    public function setVlrMulta($vlrMulta)
    {
        $this->vlrMulta = $vlrMulta;
        return $this;
    }

    /**
     * Get vlrMulta
     *
     * @return integer
     */
    public function getVlrMulta()
    {
        return $this->vlrMulta;
    }

    /**
     * Set vlrIndenizacao
     *
     * @param integer $vlrIndenizacao
     * @return RescisaoConvenio
     */
    public function setVlrIndenizacao($vlrIndenizacao)
    {
        $this->vlrIndenizacao = $vlrIndenizacao;
        return $this;
    }

    /**
     * Get vlrIndenizacao
     *
     * @return integer
     */
    public function getVlrIndenizacao()
    {
        return $this->vlrIndenizacao;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return RescisaoConvenio
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoPublicacaoRescisaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio $fkLicitacaoPublicacaoRescisaoConvenio
     * @return RescisaoConvenio
     */
    public function addFkLicitacaoPublicacaoRescisaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio $fkLicitacaoPublicacaoRescisaoConvenio)
    {
        if (false === $this->fkLicitacaoPublicacaoRescisaoConvenios->contains($fkLicitacaoPublicacaoRescisaoConvenio)) {
            $fkLicitacaoPublicacaoRescisaoConvenio->setFkLicitacaoRescisaoConvenio($this);
            $this->fkLicitacaoPublicacaoRescisaoConvenios->add($fkLicitacaoPublicacaoRescisaoConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoRescisaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio $fkLicitacaoPublicacaoRescisaoConvenio
     */
    public function removeFkLicitacaoPublicacaoRescisaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio $fkLicitacaoPublicacaoRescisaoConvenio)
    {
        $this->fkLicitacaoPublicacaoRescisaoConvenios->removeElement($fkLicitacaoPublicacaoRescisaoConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoRescisaoConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio
     */
    public function getFkLicitacaoPublicacaoRescisaoConvenios()
    {
        return $this->fkLicitacaoPublicacaoRescisaoConvenios;
    }

    /**
     * OneToMany (owning side)
     * Set fkLicitacaoPublicacaoRescisaoConvenios
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio $fkLicitacaoPublicacaoRescisaoConvenio
     * @return \Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio
     */
    public function setFkLicitacaoPublicacaoRescisaoConvenios($fkLicitacaoPublicacaoRescisaoConvenio)
    {
        return $this->fkLicitacaoPublicacaoRescisaoConvenios = $fkLicitacaoPublicacaoRescisaoConvenio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return RescisaoConvenio
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
     * OneToOne (owning side)
     * Set LicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     * @return RescisaoConvenio
     */
    public function setFkLicitacaoConvenio(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        $this->numConvenio = $fkLicitacaoConvenio->getNumConvenio();
        $this->exercicioConvenio = $fkLicitacaoConvenio->getExercicio();
        $this->fkLicitacaoConvenio = $fkLicitacaoConvenio;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    public function getFkLicitacaoConvenio()
    {
        return $this->fkLicitacaoConvenio;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s Rescindido',
            $this->fkLicitacaoConvenio
        );
    }
}
