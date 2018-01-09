<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * Depreciacao
 */
class Depreciacao
{
    /**
     * PK
     * @var integer
     */
    private $codDepreciacao;

    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $vlDepreciado;

    /**
     * @var \DateTime
     */
    private $dtDepreciacao;

    /**
     * @var string
     */
    private $competencia;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var boolean
     */
    private $acelerada;

    /**
     * @var integer
     */
    private $quotaUtilizada;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoAnulada
     */
    private $fkPatrimonioDepreciacaoAnulada;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoReavaliacao
     */
    private $fkPatrimonioDepreciacaoReavaliacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao
     */
    private $fkContabilidadeLancamentoDepreciacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeLancamentoDepreciacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codDepreciacao
     *
     * @param integer $codDepreciacao
     * @return Depreciacao
     */
    public function setCodDepreciacao($codDepreciacao)
    {
        $this->codDepreciacao = $codDepreciacao;
        return $this;
    }

    /**
     * Get codDepreciacao
     *
     * @return integer
     */
    public function getCodDepreciacao()
    {
        return $this->codDepreciacao;
    }

    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return Depreciacao
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return Depreciacao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set vlDepreciado
     *
     * @param integer $vlDepreciado
     * @return Depreciacao
     */
    public function setVlDepreciado($vlDepreciado)
    {
        $this->vlDepreciado = $vlDepreciado;
        return $this;
    }

    /**
     * Get vlDepreciado
     *
     * @return integer
     */
    public function getVlDepreciado()
    {
        return $this->vlDepreciado;
    }

    /**
     * Set dtDepreciacao
     *
     * @param \DateTime $dtDepreciacao
     * @return Depreciacao
     */
    public function setDtDepreciacao(\DateTime $dtDepreciacao)
    {
        $this->dtDepreciacao = $dtDepreciacao;
        return $this;
    }

    /**
     * Get dtDepreciacao
     *
     * @return \DateTime
     */
    public function getDtDepreciacao()
    {
        return $this->dtDepreciacao;
    }

    /**
     * Set competencia
     *
     * @param string $competencia
     * @return Depreciacao
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;
        return $this;
    }

    /**
     * Get competencia
     *
     * @return string
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return Depreciacao
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
     * Set acelerada
     *
     * @param boolean $acelerada
     * @return Depreciacao
     */
    public function setAcelerada($acelerada)
    {
        $this->acelerada = $acelerada;
        return $this;
    }

    /**
     * Get acelerada
     *
     * @return boolean
     */
    public function getAcelerada()
    {
        return $this->acelerada;
    }

    /**
     * Set quotaUtilizada
     *
     * @param integer $quotaUtilizada
     * @return Depreciacao
     */
    public function setQuotaUtilizada($quotaUtilizada)
    {
        $this->quotaUtilizada = $quotaUtilizada;
        return $this;
    }

    /**
     * Get quotaUtilizada
     *
     * @return integer
     */
    public function getQuotaUtilizada()
    {
        return $this->quotaUtilizada;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao $fkContabilidadeLancamentoDepreciacao
     * @return Depreciacao
     */
    public function addFkContabilidadeLancamentoDepreciacoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao $fkContabilidadeLancamentoDepreciacao)
    {
        if (false === $this->fkContabilidadeLancamentoDepreciacoes->contains($fkContabilidadeLancamentoDepreciacao)) {
            $fkContabilidadeLancamentoDepreciacao->setFkPatrimonioDepreciacao($this);
            $this->fkContabilidadeLancamentoDepreciacoes->add($fkContabilidadeLancamentoDepreciacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamentoDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao $fkContabilidadeLancamentoDepreciacao
     */
    public function removeFkContabilidadeLancamentoDepreciacoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao $fkContabilidadeLancamentoDepreciacao)
    {
        $this->fkContabilidadeLancamentoDepreciacoes->removeElement($fkContabilidadeLancamentoDepreciacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentoDepreciacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao
     */
    public function getFkContabilidadeLancamentoDepreciacoes()
    {
        return $this->fkContabilidadeLancamentoDepreciacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return Depreciacao
     */
    public function setFkPatrimonioBem(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->codBem = $fkPatrimonioBem->getCodBem();
        $this->fkPatrimonioBem = $fkPatrimonioBem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBem()
    {
        return $this->fkPatrimonioBem;
    }

    /**
     * OneToOne (inverse side)
     * Set PatrimonioDepreciacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoAnulada $fkPatrimonioDepreciacaoAnulada
     * @return Depreciacao
     */
    public function setFkPatrimonioDepreciacaoAnulada(\Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoAnulada $fkPatrimonioDepreciacaoAnulada)
    {
        $fkPatrimonioDepreciacaoAnulada->setFkPatrimonioDepreciacao($this);
        $this->fkPatrimonioDepreciacaoAnulada = $fkPatrimonioDepreciacaoAnulada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPatrimonioDepreciacaoAnulada
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoAnulada
     */
    public function getFkPatrimonioDepreciacaoAnulada()
    {
        return $this->fkPatrimonioDepreciacaoAnulada;
    }

    /**
     * OneToOne (inverse side)
     * Set PatrimonioDepreciacaoReavaliacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoReavaliacao $fkPatrimonioDepreciacaoReavaliacao
     * @return Depreciacao
     */
    public function setFkPatrimonioDepreciacaoReavaliacao(\Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoReavaliacao $fkPatrimonioDepreciacaoReavaliacao)
    {
        $fkPatrimonioDepreciacaoReavaliacao->setFkPatrimonioDepreciacao($this);
        $this->fkPatrimonioDepreciacaoReavaliacao = $fkPatrimonioDepreciacaoReavaliacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPatrimonioDepreciacaoReavaliacao
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoReavaliacao
     */
    public function getFkPatrimonioDepreciacaoReavaliacao()
    {
        return $this->fkPatrimonioDepreciacaoReavaliacao;
    }

    public function __toString()
    {
        return (string) $this->getCompetencia();
    }
}
