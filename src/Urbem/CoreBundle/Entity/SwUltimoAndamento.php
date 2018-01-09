<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwUltimoAndamento
 */
class SwUltimoAndamento
{
    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * @var integer
     */
    private $codAndamento;

    /**
     * @var integer
     */
    private $codOrgao;

    /**
     * @var integer
     */
    private $codUsuario;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAndamento
     */
    private $fkSwAndamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;


    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return SwUltimoAndamento
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwUltimoAndamento
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set codAndamento
     *
     * @param integer $codAndamento
     * @return SwUltimoAndamento
     */
    public function setCodAndamento($codAndamento)
    {
        $this->codAndamento = $codAndamento;
        return $this;
    }

    /**
     * Get codAndamento
     *
     * @return integer
     */
    public function getCodAndamento()
    {
        return $this->codAndamento;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return SwUltimoAndamento
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set codUsuario
     *
     * @param integer $codUsuario
     * @return SwUltimoAndamento
     */
    public function setCodUsuario($codUsuario)
    {
        $this->codUsuario = $codUsuario;
        return $this;
    }

    /**
     * Get codUsuario
     *
     * @return integer
     */
    public function getCodUsuario()
    {
        return $this->codUsuario;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SwUltimoAndamento
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
     * ManyToOne (inverse side)
     * Set fkSwAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento
     * @return SwUltimoAndamento
     */
    public function setFkSwAndamento(\Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento)
    {
        $this->codAndamento = $fkSwAndamento->getCodAndamento();
        $this->codProcesso = $fkSwAndamento->getCodProcesso();
        $this->anoExercicio = $fkSwAndamento->getAnoExercicio();
        $this->fkSwAndamento = $fkSwAndamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwAndamento
     *
     * @return \Urbem\CoreBundle\Entity\SwAndamento
     */
    public function getFkSwAndamento()
    {
        return $this->fkSwAndamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return SwUltimoAndamento
     */
    public function setFkOrganogramaOrgao(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgao = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return SwUltimoAndamento
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->codUsuario = $fkAdministracaoUsuario->getNumcgm();
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
     * Set SwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return SwUltimoAndamento
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }
}
