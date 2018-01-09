<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwDespacho
 */
class SwDespacho
{
    /**
     * PK
     * @var integer
     */
    private $codAndamento;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * PK
     * @var integer
     */
    private $codUsuario;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAndamento
     */
    private $fkSwAndamento;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAndamento
     *
     * @param integer $codAndamento
     * @return SwDespacho
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwDespacho
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
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return SwDespacho
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
     * Set codUsuario
     *
     * @param integer $codUsuario
     * @return SwDespacho
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
     * Set descricao
     *
     * @param string $descricao
     * @return SwDespacho
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SwDespacho
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
     * @return SwDespacho
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
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return SwDespacho
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
}
