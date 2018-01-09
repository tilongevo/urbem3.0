<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * BoletimFechado
 */
class BoletimFechado
{
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
    private $exercicio;

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
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto
     */
    private $fkTesourariaBoletimReaberto;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado
     */
    private $fkTesourariaBoletimLiberados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado
     */
    private $fkTesourariaBoletimLiberadoCancelados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    private $fkTesourariaBoletim;

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
        $this->fkTesourariaBoletimLiberados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimLiberadoCancelados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampFechamento = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return BoletimFechado
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
     * @return BoletimFechado
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return BoletimFechado
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
     * Set timestampFechamento
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampFechamento
     * @return BoletimFechado
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
     * @return BoletimFechado
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
     * @return BoletimFechado
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
     * @return BoletimFechado
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
     * @return BoletimFechado
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
     * Add TesourariaBoletimLiberado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado $fkTesourariaBoletimLiberado
     * @return BoletimFechado
     */
    public function addFkTesourariaBoletimLiberados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado $fkTesourariaBoletimLiberado)
    {
        if (false === $this->fkTesourariaBoletimLiberados->contains($fkTesourariaBoletimLiberado)) {
            $fkTesourariaBoletimLiberado->setFkTesourariaBoletimFechado($this);
            $this->fkTesourariaBoletimLiberados->add($fkTesourariaBoletimLiberado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLiberado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado $fkTesourariaBoletimLiberado
     */
    public function removeFkTesourariaBoletimLiberados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado $fkTesourariaBoletimLiberado)
    {
        $this->fkTesourariaBoletimLiberados->removeElement($fkTesourariaBoletimLiberado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLiberados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado
     */
    public function getFkTesourariaBoletimLiberados()
    {
        return $this->fkTesourariaBoletimLiberados;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimLiberadoCancelado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado $fkTesourariaBoletimLiberadoCancelado
     * @return BoletimFechado
     */
    public function addFkTesourariaBoletimLiberadoCancelados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado $fkTesourariaBoletimLiberadoCancelado)
    {
        if (false === $this->fkTesourariaBoletimLiberadoCancelados->contains($fkTesourariaBoletimLiberadoCancelado)) {
            $fkTesourariaBoletimLiberadoCancelado->setFkTesourariaBoletimFechado($this);
            $this->fkTesourariaBoletimLiberadoCancelados->add($fkTesourariaBoletimLiberadoCancelado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLiberadoCancelado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado $fkTesourariaBoletimLiberadoCancelado
     */
    public function removeFkTesourariaBoletimLiberadoCancelados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado $fkTesourariaBoletimLiberadoCancelado)
    {
        $this->fkTesourariaBoletimLiberadoCancelados->removeElement($fkTesourariaBoletimLiberadoCancelado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLiberadoCancelados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado
     */
    public function getFkTesourariaBoletimLiberadoCancelados()
    {
        return $this->fkTesourariaBoletimLiberadoCancelados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     * @return BoletimFechado
     */
    public function setFkTesourariaBoletim(\Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim)
    {
        $this->codBoletim = $fkTesourariaBoletim->getCodBoletim();
        $this->codEntidade = $fkTesourariaBoletim->getCodEntidade();
        $this->exercicio = $fkTesourariaBoletim->getExercicio();
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

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return BoletimFechado
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
     * @return BoletimFechado
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
     * Set TesourariaBoletimReaberto
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto $fkTesourariaBoletimReaberto
     * @return BoletimFechado
     */
    public function setFkTesourariaBoletimReaberto(\Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto $fkTesourariaBoletimReaberto)
    {
        $fkTesourariaBoletimReaberto->setFkTesourariaBoletimFechado($this);
        $this->fkTesourariaBoletimReaberto = $fkTesourariaBoletimReaberto;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaBoletimReaberto
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto
     */
    public function getFkTesourariaBoletimReaberto()
    {
        return $this->fkTesourariaBoletimReaberto;
    }
}
