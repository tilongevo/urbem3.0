<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * RescisaoContrato
 */
class RescisaoContrato
{
    /**
     * PK
     * @var string
     */
    private $exercicioContrato;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $numContrato;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $numRescisao;

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
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\RescisaoContratoResponsavelJuridico
     */
    private $fkLicitacaoRescisaoContratoResponsavelJuridico;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContrato;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoContrato
     */
    private $fkLicitacaoPublicacaoRescisaoContratos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoPublicacaoRescisaoContratos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicioContrato
     *
     * @param string $exercicioContrato
     * @return RescisaoContrato
     */
    public function setExercicioContrato($exercicioContrato)
    {
        $this->exercicioContrato = $exercicioContrato;
        return $this;
    }

    /**
     * Get exercicioContrato
     *
     * @return string
     */
    public function getExercicioContrato()
    {
        return $this->exercicioContrato;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return RescisaoContrato
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
     * Set numContrato
     *
     * @param integer $numContrato
     * @return RescisaoContrato
     */
    public function setNumContrato($numContrato)
    {
        $this->numContrato = $numContrato;
        return $this;
    }

    /**
     * Get numContrato
     *
     * @return integer
     */
    public function getNumContrato()
    {
        return $this->numContrato;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return RescisaoContrato
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
     * @return RescisaoContrato
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
     * Set dtRescisao
     *
     * @param \DateTime $dtRescisao
     * @return RescisaoContrato
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
     * @return RescisaoContrato
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
     * @return RescisaoContrato
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
     * @return RescisaoContrato
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
     * Add LicitacaoPublicacaoRescisaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoContrato $fkLicitacaoPublicacaoRescisaoContrato
     * @return RescisaoContrato
     */
    public function addFkLicitacaoPublicacaoRescisaoContratos(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoContrato $fkLicitacaoPublicacaoRescisaoContrato)
    {
        if (false === $this->fkLicitacaoPublicacaoRescisaoContratos->contains($fkLicitacaoPublicacaoRescisaoContrato)) {
            $fkLicitacaoPublicacaoRescisaoContrato->setFkLicitacaoRescisaoContrato($this);
            $this->fkLicitacaoPublicacaoRescisaoContratos->add($fkLicitacaoPublicacaoRescisaoContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoRescisaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoContrato $fkLicitacaoPublicacaoRescisaoContrato
     */
    public function removeFkLicitacaoPublicacaoRescisaoContratos(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoContrato $fkLicitacaoPublicacaoRescisaoContrato)
    {
        $this->fkLicitacaoPublicacaoRescisaoContratos->removeElement($fkLicitacaoPublicacaoRescisaoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoRescisaoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoContrato
     */
    public function getFkLicitacaoPublicacaoRescisaoContratos()
    {
        return $this->fkLicitacaoPublicacaoRescisaoContratos;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoRescisaoContratoResponsavelJuridico
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\RescisaoContratoResponsavelJuridico $fkLicitacaoRescisaoContratoResponsavelJuridico
     * @return RescisaoContrato
     */
    public function setFkLicitacaoRescisaoContratoResponsavelJuridico(\Urbem\CoreBundle\Entity\Licitacao\RescisaoContratoResponsavelJuridico $fkLicitacaoRescisaoContratoResponsavelJuridico)
    {
        $fkLicitacaoRescisaoContratoResponsavelJuridico->setFkLicitacaoRescisaoContrato($this);
        $this->fkLicitacaoRescisaoContratoResponsavelJuridico = $fkLicitacaoRescisaoContratoResponsavelJuridico;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoRescisaoContratoResponsavelJuridico
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\RescisaoContratoResponsavelJuridico
     */
    public function getFkLicitacaoRescisaoContratoResponsavelJuridico()
    {
        return $this->fkLicitacaoRescisaoContratoResponsavelJuridico;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return RescisaoContrato
     */
    public function setFkLicitacaoContrato(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->exercicioContrato = $fkLicitacaoContrato->getExercicio();
        $this->codEntidade = $fkLicitacaoContrato->getCodEntidade();
        $this->numContrato = $fkLicitacaoContrato->getNumContrato();
        $this->fkLicitacaoContrato = $fkLicitacaoContrato;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoContrato
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContrato()
    {
        return $this->fkLicitacaoContrato;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->numRescisao;
    }
}
