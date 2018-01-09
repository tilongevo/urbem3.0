<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * Dote
 */
class Dote
{
    /**
     * PK
     * @var integer
     */
    private $codDote;

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
     * @var integer
     */
    private $codTerminal;

    /**
     * @var integer
     */
    private $cgmUsuario;

    /**
     * @var \DateTime
     */
    private $timestampTerminal;

    /**
     * @var \DateTime
     */
    private $timestampUsuario;

    /**
     * @var \DateTime
     */
    private $timestampDote;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado
     */
    private $fkTesourariaDoteProcessado;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote
     */
    private $fkTesourariaTransferenciasDotes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

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
        $this->fkTesourariaTransferenciasDotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampDote = new \DateTime;
    }

    /**
     * Set codDote
     *
     * @param integer $codDote
     * @return Dote
     */
    public function setCodDote($codDote)
    {
        $this->codDote = $codDote;
        return $this;
    }

    /**
     * Get codDote
     *
     * @return integer
     */
    public function getCodDote()
    {
        return $this->codDote;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Dote
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
     * @return Dote
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
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return Dote
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
     * Set cgmUsuario
     *
     * @param integer $cgmUsuario
     * @return Dote
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
     * Set timestampTerminal
     *
     * @param \DateTime $timestampTerminal
     * @return Dote
     */
    public function setTimestampTerminal(\DateTime $timestampTerminal)
    {
        $this->timestampTerminal = $timestampTerminal;
        return $this;
    }

    /**
     * Get timestampTerminal
     *
     * @return \DateTime
     */
    public function getTimestampTerminal()
    {
        return $this->timestampTerminal;
    }

    /**
     * Set timestampUsuario
     *
     * @param \DateTime $timestampUsuario
     * @return Dote
     */
    public function setTimestampUsuario(\DateTime $timestampUsuario)
    {
        $this->timestampUsuario = $timestampUsuario;
        return $this;
    }

    /**
     * Get timestampUsuario
     *
     * @return \DateTime
     */
    public function getTimestampUsuario()
    {
        return $this->timestampUsuario;
    }

    /**
     * Set timestampDote
     *
     * @param \DateTime $timestampDote
     * @return Dote
     */
    public function setTimestampDote(\DateTime $timestampDote)
    {
        $this->timestampDote = $timestampDote;
        return $this;
    }

    /**
     * Get timestampDote
     *
     * @return \DateTime
     */
    public function getTimestampDote()
    {
        return $this->timestampDote;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferenciasDote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote $fkTesourariaTransferenciasDote
     * @return Dote
     */
    public function addFkTesourariaTransferenciasDotes(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote $fkTesourariaTransferenciasDote)
    {
        if (false === $this->fkTesourariaTransferenciasDotes->contains($fkTesourariaTransferenciasDote)) {
            $fkTesourariaTransferenciasDote->setFkTesourariaDote($this);
            $this->fkTesourariaTransferenciasDotes->add($fkTesourariaTransferenciasDote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferenciasDote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote $fkTesourariaTransferenciasDote
     */
    public function removeFkTesourariaTransferenciasDotes(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote $fkTesourariaTransferenciasDote)
    {
        $this->fkTesourariaTransferenciasDotes->removeElement($fkTesourariaTransferenciasDote);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferenciasDotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote
     */
    public function getFkTesourariaTransferenciasDotes()
    {
        return $this->fkTesourariaTransferenciasDotes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Dote
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     * @return Dote
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
     * OneToOne (inverse side)
     * Set TesourariaDoteProcessado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado $fkTesourariaDoteProcessado
     * @return Dote
     */
    public function setFkTesourariaDoteProcessado(\Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado $fkTesourariaDoteProcessado)
    {
        $fkTesourariaDoteProcessado->setFkTesourariaDote($this);
        $this->fkTesourariaDoteProcessado = $fkTesourariaDoteProcessado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaDoteProcessado
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado
     */
    public function getFkTesourariaDoteProcessado()
    {
        return $this->fkTesourariaDoteProcessado;
    }
}
