<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwPermissaoAutorizacao
 */
class SwPermissaoAutorizacao
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
    private $codUnidade;

    /**
     * PK
     * @var integer
     */
    private $codOrgao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SwPermissaoAutorizacao
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
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return SwPermissaoAutorizacao
     */
    public function setCodUnidade($codUnidade)
    {
        $this->codUnidade = $codUnidade;
        return $this;
    }

    /**
     * Get codUnidade
     *
     * @return integer
     */
    public function getCodUnidade()
    {
        return $this->codUnidade;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return SwPermissaoAutorizacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwPermissaoAutorizacao
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
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return SwPermissaoAutorizacao
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
}
