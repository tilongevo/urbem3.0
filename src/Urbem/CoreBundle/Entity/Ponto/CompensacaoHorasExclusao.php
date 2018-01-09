<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * CompensacaoHorasExclusao
 */
class CompensacaoHorasExclusao
{
    /**
     * PK
     * @var integer
     */
    private $codCompensacao;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ponto\CompensacaoHoras
     */
    private $fkPontoCompensacaoHoras;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codCompensacao
     *
     * @param integer $codCompensacao
     * @return CompensacaoHorasExclusao
     */
    public function setCodCompensacao($codCompensacao)
    {
        $this->codCompensacao = $codCompensacao;
        return $this;
    }

    /**
     * Get codCompensacao
     *
     * @return integer
     */
    public function getCodCompensacao()
    {
        return $this->codCompensacao;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return CompensacaoHorasExclusao
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return CompensacaoHorasExclusao
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
     * @param \DateTime $timestamp
     * @return CompensacaoHorasExclusao
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return CompensacaoHorasExclusao
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
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
     * OneToOne (owning side)
     * Set PontoCompensacaoHoras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\CompensacaoHoras $fkPontoCompensacaoHoras
     * @return CompensacaoHorasExclusao
     */
    public function setFkPontoCompensacaoHoras(\Urbem\CoreBundle\Entity\Ponto\CompensacaoHoras $fkPontoCompensacaoHoras)
    {
        $this->codCompensacao = $fkPontoCompensacaoHoras->getCodCompensacao();
        $this->codContrato = $fkPontoCompensacaoHoras->getCodContrato();
        $this->fkPontoCompensacaoHoras = $fkPontoCompensacaoHoras;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPontoCompensacaoHoras
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\CompensacaoHoras
     */
    public function getFkPontoCompensacaoHoras()
    {
        return $this->fkPontoCompensacaoHoras;
    }
}
