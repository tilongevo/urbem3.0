<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Permissao
 */
class Permissao
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Acao
     */
    private $fkAdministracaoAcao;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Permissao
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
     * Set codAcao
     *
     * @param integer $codAcao
     * @return Permissao
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return Permissao
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
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Permissao
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
     * ManyToOne (inverse side)
     * Set fkAdministracaoAcao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao
     * @return Permissao
     */
    public function setFkAdministracaoAcao(\Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao)
    {
        $this->codAcao = $fkAdministracaoAcao->getCodAcao();
        $this->fkAdministracaoAcao = $fkAdministracaoAcao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAcao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Acao
     */
    public function getFkAdministracaoAcao()
    {
        return $this->fkAdministracaoAcao;
    }
}
