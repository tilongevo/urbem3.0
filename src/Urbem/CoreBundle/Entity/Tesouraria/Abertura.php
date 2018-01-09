<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * Abertura
 */
class Abertura
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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampAbertura;

    /**
     * PK
     * @var integer
     */
    private $codBoletim;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicioBoletim;

    /**
     * @var integer
     */
    private $cgmUsuario;

    /**
     * @var \DateTime
     */
    private $timestampUsuario;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Fechamento
     */
    private $fkTesourariaFechamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Terminal
     */
    private $fkTesourariaTerminal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    private $fkTesourariaUsuarioTerminal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    private $fkTesourariaBoletim;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaFechamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampTerminal = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampAbertura = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return Abertura
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
     * @return Abertura
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
     * Set timestampAbertura
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAbertura
     * @return Abertura
     */
    public function setTimestampAbertura(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAbertura)
    {
        $this->timestampAbertura = $timestampAbertura;
        return $this;
    }

    /**
     * Get timestampAbertura
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampAbertura()
    {
        return $this->timestampAbertura;
    }

    /**
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return Abertura
     */
    public function setCodBoletim($codBoletim)
    {
        $this->codBoletim = $codBoletim;
        return $this;
    }

    /**
     * Get codBoletim
     *
     * @return integer
     */
    public function getCodBoletim()
    {
        return $this->codBoletim;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Abertura
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicioBoletim
     *
     * @param string $exercicioBoletim
     * @return Abertura
     */
    public function setExercicioBoletim($exercicioBoletim)
    {
        $this->exercicioBoletim = $exercicioBoletim;
        return $this;
    }

    /**
     * Get exercicioBoletim
     *
     * @return string
     */
    public function getExercicioBoletim()
    {
        return $this->exercicioBoletim;
    }

    /**
     * Set cgmUsuario
     *
     * @param integer $cgmUsuario
     * @return Abertura
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
     * @return Abertura
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
     * OneToMany (owning side)
     * Add TesourariaFechamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Fechamento $fkTesourariaFechamento
     * @return Abertura
     */
    public function addFkTesourariaFechamentos(\Urbem\CoreBundle\Entity\Tesouraria\Fechamento $fkTesourariaFechamento)
    {
        if (false === $this->fkTesourariaFechamentos->contains($fkTesourariaFechamento)) {
            $fkTesourariaFechamento->setFkTesourariaAbertura($this);
            $this->fkTesourariaFechamentos->add($fkTesourariaFechamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaFechamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Fechamento $fkTesourariaFechamento
     */
    public function removeFkTesourariaFechamentos(\Urbem\CoreBundle\Entity\Tesouraria\Fechamento $fkTesourariaFechamento)
    {
        $this->fkTesourariaFechamentos->removeElement($fkTesourariaFechamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaFechamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Fechamento
     */
    public function getFkTesourariaFechamentos()
    {
        return $this->fkTesourariaFechamentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Terminal $fkTesourariaTerminal
     * @return Abertura
     */
    public function setFkTesourariaTerminal(\Urbem\CoreBundle\Entity\Tesouraria\Terminal $fkTesourariaTerminal)
    {
        $this->codTerminal = $fkTesourariaTerminal->getCodTerminal();
        $this->timestampTerminal = $fkTesourariaTerminal->getTimestampTerminal();
        $this->fkTesourariaTerminal = $fkTesourariaTerminal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaTerminal
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Terminal
     */
    public function getFkTesourariaTerminal()
    {
        return $this->fkTesourariaTerminal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     * @return Abertura
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
     * ManyToOne (inverse side)
     * Get fkTesourariaUsuarioTerminal
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    public function getFkTesourariaUsuarioTerminal()
    {
        return $this->fkTesourariaUsuarioTerminal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     * @return Abertura
     */
    public function setFkTesourariaBoletim(\Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim)
    {
        $this->codBoletim = $fkTesourariaBoletim->getCodBoletim();
        $this->codEntidade = $fkTesourariaBoletim->getCodEntidade();
        $this->exercicioBoletim = $fkTesourariaBoletim->getExercicio();
        $this->fkTesourariaBoletim = $fkTesourariaBoletim;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaBoletim
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    public function getFkTesourariaBoletim()
    {
        return $this->fkTesourariaBoletim;
    }
}
