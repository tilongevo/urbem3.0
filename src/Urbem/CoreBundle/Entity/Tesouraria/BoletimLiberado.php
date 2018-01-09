<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * BoletimLiberado
 */
class BoletimLiberado
{
    /**
     * PK
     * @var integer
     */
    private $codBoletim;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampLiberado;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampFechamento;

    /**
     * @var integer
     */
    private $codTerminal;

    /**
     * @var \DateTime
     */
    private $timestampTerminal;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoLote
     */
    private $fkTesourariaBoletimLiberadoLotes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado
     */
    private $fkTesourariaBoletimFechado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    private $fkTesourariaUsuarioTerminal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaBoletimLiberadoLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampLiberado = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampFechamento = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return BoletimLiberado
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return BoletimLiberado
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return BoletimLiberado
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
     * Set timestampLiberado
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampLiberado
     * @return BoletimLiberado
     */
    public function setTimestampLiberado(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampLiberado)
    {
        $this->timestampLiberado = $timestampLiberado;
        return $this;
    }

    /**
     * Get timestampLiberado
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampLiberado()
    {
        return $this->timestampLiberado;
    }

    /**
     * Set timestampFechamento
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampFechamento
     * @return BoletimLiberado
     */
    public function setTimestampFechamento(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampFechamento)
    {
        $this->timestampFechamento = $timestampFechamento;
        return $this;
    }

    /**
     * Get timestampFechamento
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampFechamento()
    {
        return $this->timestampFechamento;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return BoletimLiberado
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
     * @return BoletimLiberado
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
     * @return BoletimLiberado
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
     * @return BoletimLiberado
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
     * Add TesourariaBoletimLiberadoLote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoLote $fkTesourariaBoletimLiberadoLote
     * @return BoletimLiberado
     */
    public function addFkTesourariaBoletimLiberadoLotes(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoLote $fkTesourariaBoletimLiberadoLote)
    {
        if (false === $this->fkTesourariaBoletimLiberadoLotes->contains($fkTesourariaBoletimLiberadoLote)) {
            $fkTesourariaBoletimLiberadoLote->setFkTesourariaBoletimLiberado($this);
            $this->fkTesourariaBoletimLiberadoLotes->add($fkTesourariaBoletimLiberadoLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLiberadoLote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoLote $fkTesourariaBoletimLiberadoLote
     */
    public function removeFkTesourariaBoletimLiberadoLotes(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoLote $fkTesourariaBoletimLiberadoLote)
    {
        $this->fkTesourariaBoletimLiberadoLotes->removeElement($fkTesourariaBoletimLiberadoLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLiberadoLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoLote
     */
    public function getFkTesourariaBoletimLiberadoLotes()
    {
        return $this->fkTesourariaBoletimLiberadoLotes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaBoletimFechado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado
     * @return BoletimLiberado
     */
    public function setFkTesourariaBoletimFechado(\Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado)
    {
        $this->codBoletim = $fkTesourariaBoletimFechado->getCodBoletim();
        $this->codEntidade = $fkTesourariaBoletimFechado->getCodEntidade();
        $this->exercicio = $fkTesourariaBoletimFechado->getExercicio();
        $this->timestampFechamento = $fkTesourariaBoletimFechado->getTimestampFechamento();
        $this->fkTesourariaBoletimFechado = $fkTesourariaBoletimFechado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaBoletimFechado
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado
     */
    public function getFkTesourariaBoletimFechado()
    {
        return $this->fkTesourariaBoletimFechado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     * @return BoletimLiberado
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
}
