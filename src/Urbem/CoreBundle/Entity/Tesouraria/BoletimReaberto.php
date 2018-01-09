<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * BoletimReaberto
 */
class BoletimReaberto
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
     * @var \DateTime
     */
    private $timestampReabertura;

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
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado
     */
    private $fkTesourariaBoletimFechado;

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
        $this->timestampFechamento = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampReabertura = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return BoletimReaberto
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
     * @return BoletimReaberto
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
     * @return BoletimReaberto
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
     * @return BoletimReaberto
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
     * Set timestampReabertura
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampReabertura
     * @return BoletimReaberto
     */
    public function setTimestampReabertura(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampReabertura)
    {
        $this->timestampReabertura = $timestampReabertura;
        return $this;
    }

    /**
     * Get timestampReabertura
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampReabertura()
    {
        return $this->timestampReabertura;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return BoletimReaberto
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
     * @return BoletimReaberto
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
     * @return BoletimReaberto
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
     * @return BoletimReaberto
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return BoletimReaberto
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
     * @return BoletimReaberto
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
     * OneToOne (owning side)
     * Set TesourariaBoletimFechado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado
     * @return BoletimReaberto
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
     * OneToOne (owning side)
     * Get fkTesourariaBoletimFechado
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado
     */
    public function getFkTesourariaBoletimFechado()
    {
        return $this->fkTesourariaBoletimFechado;
    }
}
