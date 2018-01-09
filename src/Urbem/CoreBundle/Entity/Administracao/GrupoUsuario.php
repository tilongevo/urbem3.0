<?php

namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * GrupoUsuario
 */
class GrupoUsuario
{
    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * PK
     * @var integer
     */
    private $codUsuario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Grupo
     */
    private $fkAdministracaoGrupo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;


    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return GrupoUsuario
     */
    public function setCodGrupo($codGrupo)
    {
        $this->codGrupo = $codGrupo;
        return $this;
    }

    /**
     * Get codGrupo
     *
     * @return integer
     */
    public function getCodGrupo()
    {
        return $this->codGrupo;
    }

    /**
     * Set codUsuario
     *
     * @param integer $codUsuario
     * @return GrupoUsuario
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
     * Set fkAdministracaoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Grupo $fkAdministracaoGrupo
     * @return GrupoUsuario
     */
    public function setFkAdministracaoGrupo(\Urbem\CoreBundle\Entity\Administracao\Grupo $fkAdministracaoGrupo)
    {
        $this->codGrupo = $fkAdministracaoGrupo->getCodGrupo();
        $this->fkAdministracaoGrupo = $fkAdministracaoGrupo;

        return $this;
    }

    /**
     * Get fkAdministracaoGrupo
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Grupo
     */
    public function getFkAdministracaoGrupo()
    {
        return $this->fkAdministracaoGrupo;
    }

    /**
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return GrupoUsuario
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->codUsuario = $fkAdministracaoUsuario->getId();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;

        return $this;
    }

    /**
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkAdministracaoUsuario;
    }
}
