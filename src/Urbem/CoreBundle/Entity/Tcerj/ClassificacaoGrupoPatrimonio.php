<?php
 
namespace Urbem\CoreBundle\Entity\Tcerj;

/**
 * ClassificacaoGrupoPatrimonio
 */
class ClassificacaoGrupoPatrimonio
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
    private $codNatureza;

    /**
     * @var string
     */
    private $sigla;


    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return ClassificacaoGrupoPatrimonio
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
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return ClassificacaoGrupoPatrimonio
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set sigla
     *
     * @param string $sigla
     * @return ClassificacaoGrupoPatrimonio
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
        return $this;
    }

    /**
     * Get sigla
     *
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }
}
