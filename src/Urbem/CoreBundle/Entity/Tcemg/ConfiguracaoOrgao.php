<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ConfiguracaoOrgao
 */
class ConfiguracaoOrgao
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $tipoResponsavel;

    /**
     * PK
     * @var integer
     */
    private $numCgm;

    /**
     * @var string
     */
    private $crcContador;

    /**
     * @var string
     */
    private $ufCrccontador;

    /**
     * @var string
     */
    private $cargoOrdenadorDespesa;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtFim;

    /**
     * @var string
     */
    private $email;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ConfiguracaoOrgao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoOrgao
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
     * Set tipoResponsavel
     *
     * @param integer $tipoResponsavel
     * @return ConfiguracaoOrgao
     */
    public function setTipoResponsavel($tipoResponsavel)
    {
        $this->tipoResponsavel = $tipoResponsavel;
        return $this;
    }

    /**
     * Get tipoResponsavel
     *
     * @return integer
     */
    public function getTipoResponsavel()
    {
        return $this->tipoResponsavel;
    }

    /**
     * Set numCgm
     *
     * @param integer $numCgm
     * @return ConfiguracaoOrgao
     */
    public function setNumCgm($numCgm)
    {
        $this->numCgm = $numCgm;
        return $this;
    }

    /**
     * Get numCgm
     *
     * @return integer
     */
    public function getNumCgm()
    {
        return $this->numCgm;
    }

    /**
     * Set crcContador
     *
     * @param string $crcContador
     * @return ConfiguracaoOrgao
     */
    public function setCrcContador($crcContador = null)
    {
        $this->crcContador = $crcContador;
        return $this;
    }

    /**
     * Get crcContador
     *
     * @return string
     */
    public function getCrcContador()
    {
        return $this->crcContador;
    }

    /**
     * Set ufCrccontador
     *
     * @param string $ufCrccontador
     * @return ConfiguracaoOrgao
     */
    public function setUfCrccontador($ufCrccontador = null)
    {
        $this->ufCrccontador = $ufCrccontador;
        return $this;
    }

    /**
     * Get ufCrccontador
     *
     * @return string
     */
    public function getUfCrccontador()
    {
        return $this->ufCrccontador;
    }

    /**
     * Set cargoOrdenadorDespesa
     *
     * @param string $cargoOrdenadorDespesa
     * @return ConfiguracaoOrgao
     */
    public function setCargoOrdenadorDespesa($cargoOrdenadorDespesa = null)
    {
        $this->cargoOrdenadorDespesa = $cargoOrdenadorDespesa;
        return $this;
    }

    /**
     * Get cargoOrdenadorDespesa
     *
     * @return string
     */
    public function getCargoOrdenadorDespesa()
    {
        return $this->cargoOrdenadorDespesa;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return ConfiguracaoOrgao
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
     * Set dtFim
     *
     * @param \DateTime $dtFim
     * @return ConfiguracaoOrgao
     */
    public function setDtFim(\DateTime $dtFim)
    {
        $this->dtFim = $dtFim;
        return $this;
    }

    /**
     * Get dtFim
     *
     * @return \DateTime
     */
    public function getDtFim()
    {
        return $this->dtFim;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return ConfiguracaoOrgao
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ConfiguracaoOrgao
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numCgm = $fkSwCgm->getNumcgm();
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
}
