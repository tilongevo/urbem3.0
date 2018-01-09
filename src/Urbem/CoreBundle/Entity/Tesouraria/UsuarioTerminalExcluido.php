<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * UsuarioTerminalExcluido
 */
class UsuarioTerminalExcluido
{
    /**
     * PK
     * @var integer
     */
    private $codTerminal;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampTerminal;

    /**
     * PK
     * @var integer
     */
    private $cgmUsuario;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampUsuario;

    /**
     * @var \DateTime
     */
    private $timestampExcluido;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    private $fkTesourariaUsuarioTerminal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampTerminal = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampUsuario = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampExcluido = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return UsuarioTerminalExcluido
     */
    public function setCodTerminal($codTerminal)
    {
        $this->codTerminal = $codTerminal;
        return $this;
    }

    /**
     * Get codTerminal
     *
     * @return integer
     */
    public function getCodTerminal()
    {
        return $this->codTerminal;
    }

    /**
     * Set timestampTerminal
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTerminal
     * @return UsuarioTerminalExcluido
     */
    public function setTimestampTerminal(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTerminal)
    {
        $this->timestampTerminal = $timestampTerminal;
        return $this;
    }

    /**
     * Get timestampTerminal
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampTerminal()
    {
        return $this->timestampTerminal;
    }

    /**
     * Set cgmUsuario
     *
     * @param integer $cgmUsuario
     * @return UsuarioTerminalExcluido
     */
    public function setCgmUsuario($cgmUsuario)
    {
        $this->cgmUsuario = $cgmUsuario;
        return $this;
    }

    /**
     * Get cgmUsuario
     *
     * @return integer
     */
    public function getCgmUsuario()
    {
        return $this->cgmUsuario;
    }

    /**
     * Set timestampUsuario
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampUsuario
     * @return UsuarioTerminalExcluido
     */
    public function setTimestampUsuario(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampUsuario)
    {
        $this->timestampUsuario = $timestampUsuario;
        return $this;
    }

    /**
     * Get timestampUsuario
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampUsuario()
    {
        return $this->timestampUsuario;
    }

    /**
     * Set timestampExcluido
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampExcluido
     * @return UsuarioTerminalExcluido
     */
    public function setTimestampExcluido(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampExcluido = null)
    {
        $this->timestampExcluido = $timestampExcluido;
        return $this;
    }

    /**
     * Get timestampExcluido
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampExcluido()
    {
        return $this->timestampExcluido;
    }

    /**
     * OneToOne (owning side)
     * Set TesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     * @return UsuarioTerminalExcluido
     */
    public function setFkTesourariaUsuarioTerminal(\Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal)
    {
        $this->codTerminal = $fkTesourariaUsuarioTerminal->getCodTerminal();
        $this->timestampTerminal = $fkTesourariaUsuarioTerminal->getTimestampTerminal();
        $this->cgmUsuario = $fkTesourariaUsuarioTerminal->getCgmUsuario();
        $this->timestampUsuario = $fkTesourariaUsuarioTerminal->getTimestampUsuario();
        $this->fkTesourariaUsuarioTerminal = $fkTesourariaUsuarioTerminal;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkTesourariaUsuarioTerminal
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    public function getFkTesourariaUsuarioTerminal()
    {
        return $this->fkTesourariaUsuarioTerminal;
    }
}
