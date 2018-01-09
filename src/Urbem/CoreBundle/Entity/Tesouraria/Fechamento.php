<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * Fechamento
 */
class Fechamento
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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampFechamento;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Abertura
     */
    private $fkTesourariaAbertura;

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
        $this->timestampTerminal = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampAbertura = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampFechamento = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return Fechamento
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
     * @return Fechamento
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
     * @return Fechamento
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
     * Set timestampFechamento
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampFechamento
     * @return Fechamento
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
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return Fechamento
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
     * @return Fechamento
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
     * @return Fechamento
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
     * @return Fechamento
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
     * @return Fechamento
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
     * Set fkTesourariaAbertura
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Abertura $fkTesourariaAbertura
     * @return Fechamento
     */
    public function setFkTesourariaAbertura(\Urbem\CoreBundle\Entity\Tesouraria\Abertura $fkTesourariaAbertura)
    {
        $this->codTerminal = $fkTesourariaAbertura->getCodTerminal();
        $this->timestampTerminal = $fkTesourariaAbertura->getTimestampTerminal();
        $this->timestampAbertura = $fkTesourariaAbertura->getTimestampAbertura();
        $this->codBoletim = $fkTesourariaAbertura->getCodBoletim();
        $this->codEntidade = $fkTesourariaAbertura->getCodEntidade();
        $this->exercicioBoletim = $fkTesourariaAbertura->getExercicioBoletim();
        $this->fkTesourariaAbertura = $fkTesourariaAbertura;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaAbertura
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Abertura
     */
    public function getFkTesourariaAbertura()
    {
        return $this->fkTesourariaAbertura;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     * @return Fechamento
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
     * @return Fechamento
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
