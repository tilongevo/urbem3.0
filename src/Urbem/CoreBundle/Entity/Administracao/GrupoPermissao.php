<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * GrupoPermissao
 */
class GrupoPermissao
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
    private $codRota;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Grupo
     */
    private $fkAdministracaoGrupo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Rota
     */
    private $fkAdministracaoRota;


    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return GrupoPermissao
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
     * Set codRota
     *
     * @param integer $codRota
     * @return GrupoPermissao
     */
    public function setCodRota($codRota)
    {
        $this->codRota = $codRota;
        return $this;
    }

    /**
     * Get codRota
     *
     * @return integer
     */
    public function getCodRota()
    {
        return $this->codRota;
    }

    /**
     * Set fkAdministracaoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Grupo $fkAdministracaoGrupo
     * @return GrupoPermissao
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
     * Set fkAdministracaoRota
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Rota $fkAdministracaoRota
     * @return GrupoPermissao
     */
    public function setFkAdministracaoRota(\Urbem\CoreBundle\Entity\Administracao\Rota $fkAdministracaoRota)
    {
        $this->codRota = $fkAdministracaoRota->getCodRota();
        $this->fkAdministracaoRota = $fkAdministracaoRota;
        
        return $this;
    }

    /**
     * Get fkAdministracaoRota
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Rota
     */
    public function getFkAdministracaoRota()
    {
        return $this->fkAdministracaoRota;
    }
}
