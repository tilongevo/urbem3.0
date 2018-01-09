<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAssinaturaDigital
 */
class SwAssinaturaDigital
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
     * @var integer
     */
    private $codUsuario;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwRecebimento
     */
    private $fkSwRecebimento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;


    /**
     * Set codAndamento
     *
     * @param integer $codAndamento
     * @return SwAssinaturaDigital
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
     * @return SwAssinaturaDigital
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
     * @return SwAssinaturaDigital
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
     * @return SwAssinaturaDigital
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
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return SwAssinaturaDigital
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
     * Set SwRecebimento
     *
     * @param \Urbem\CoreBundle\Entity\SwRecebimento $fkSwRecebimento
     * @return SwAssinaturaDigital
     */
    public function setFkSwRecebimento(\Urbem\CoreBundle\Entity\SwRecebimento $fkSwRecebimento)
    {
        $this->codAndamento = $fkSwRecebimento->getCodAndamento();
        $this->codProcesso = $fkSwRecebimento->getCodProcesso();
        $this->anoExercicio = $fkSwRecebimento->getAnoExercicio();
        $this->fkSwRecebimento = $fkSwRecebimento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwRecebimento
     *
     * @return \Urbem\CoreBundle\Entity\SwRecebimento
     */
    public function getFkSwRecebimento()
    {
        return $this->fkSwRecebimento;
    }
}
