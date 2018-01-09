<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * BoletimLiberadoCancelado
 */
class BoletimLiberadoCancelado
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
    private $timestampLiberado;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampFechamento;

    /**
     * @var \DateTime
     */
    private $timestampCancelado;

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
     * ManyToOne
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
        $this->timestampLiberado = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampFechamento = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampCancelado = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return BoletimLiberadoCancelado
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
     * @return BoletimLiberadoCancelado
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
     * @return BoletimLiberadoCancelado
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
     * Set timestampLiberado
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampLiberado
     * @return BoletimLiberadoCancelado
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
     * @return BoletimLiberadoCancelado
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
     * Set timestampCancelado
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampCancelado
     * @return BoletimLiberadoCancelado
     */
    public function setTimestampCancelado(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampCancelado)
    {
        $this->timestampCancelado = $timestampCancelado;
        return $this;
    }

    /**
     * Get timestampCancelado
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampCancelado()
    {
        return $this->timestampCancelado;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return BoletimLiberadoCancelado
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
     * @return BoletimLiberadoCancelado
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
     * @return BoletimLiberadoCancelado
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
     * @return BoletimLiberadoCancelado
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
     * Set fkTesourariaBoletimFechado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado
     * @return BoletimLiberadoCancelado
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
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return BoletimLiberadoCancelado
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
     * @return BoletimLiberadoCancelado
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
