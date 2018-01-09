<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * Permissao
 */
class Permissao
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
    private $numcgm;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito
     */
    private $fkArrecadacaoGrupoCredito;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;


    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return Permissao
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
     * Set fkArrecadacaoGrupoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito $fkArrecadacaoGrupoCredito
     * @return Permissao
     */
    public function setFkArrecadacaoGrupoCredito(\Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito $fkArrecadacaoGrupoCredito)
    {
        $this->codGrupo = $fkArrecadacaoGrupoCredito->getCodGrupo();
        $this->anoExercicio = $fkArrecadacaoGrupoCredito->getAnoExercicio();
        $this->fkArrecadacaoGrupoCredito = $fkArrecadacaoGrupoCredito;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoGrupoCredito
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito
     */
    public function getFkArrecadacaoGrupoCredito()
    {
        return $this->fkArrecadacaoGrupoCredito;
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
}
