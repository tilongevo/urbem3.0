<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * UsuarioImpressora
 */
class UsuarioImpressora
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
    private $codImpressora;

    /**
     * @var boolean
     */
    private $impressoraPadrao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Impressora
     */
    private $fkAdministracaoImpressora;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return UsuarioImpressora
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
     * Set codImpressora
     *
     * @param integer $codImpressora
     * @return UsuarioImpressora
     */
    public function setCodImpressora($codImpressora)
    {
        $this->codImpressora = $codImpressora;
        return $this;
    }

    /**
     * Get codImpressora
     *
     * @return integer
     */
    public function getCodImpressora()
    {
        return $this->codImpressora;
    }

    /**
     * Set impressoraPadrao
     *
     * @param boolean $impressoraPadrao
     * @return UsuarioImpressora
     */
    public function setImpressoraPadrao($impressoraPadrao)
    {
        $this->impressoraPadrao = $impressoraPadrao;
        return $this;
    }

    /**
     * Get impressoraPadrao
     *
     * @return boolean
     */
    public function getImpressoraPadrao()
    {
        return $this->impressoraPadrao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return UsuarioImpressora
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
     * Set fkAdministracaoImpressora
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Impressora $fkAdministracaoImpressora
     * @return UsuarioImpressora
     */
    public function setFkAdministracaoImpressora(\Urbem\CoreBundle\Entity\Administracao\Impressora $fkAdministracaoImpressora)
    {
        $this->codImpressora = $fkAdministracaoImpressora->getCodImpressora();
        $this->fkAdministracaoImpressora = $fkAdministracaoImpressora;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoImpressora
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Impressora
     */
    public function getFkAdministracaoImpressora()
    {
        return $this->fkAdministracaoImpressora;
    }
}
