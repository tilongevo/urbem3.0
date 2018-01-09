<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * DoteProcessado
 */
class DoteProcessado
{
    /**
     * PK
     * @var integer
     */
    private $codDote;

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
     * @var integer
     */
    private $codLote;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var integer
     */
    private $codBoletim;

    /**
     * @var string
     */
    private $exercicioBoletim;

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
     * @var \DateTime
     */
    private $timestampProcessado;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Dote
     */
    private $fkTesourariaDote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    private $fkTesourariaBoletim;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Lote
     */
    private $fkContabilidadeLote;

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
        $this->timestampProcessado = new \DateTime;
    }

    /**
     * Set codDote
     *
     * @param integer $codDote
     * @return DoteProcessado
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return DoteProcessado
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
     * @return DoteProcessado
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
     * Set codLote
     *
     * @param integer $codLote
     * @return DoteProcessado
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return DoteProcessado
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return DoteProcessado
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
     * Set exercicioBoletim
     *
     * @param string $exercicioBoletim
     * @return DoteProcessado
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
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return DoteProcessado
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
     * @param \DateTime $timestampTerminal
     * @return DoteProcessado
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
     * Set cgmUsuario
     *
     * @param integer $cgmUsuario
     * @return DoteProcessado
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
     * @param \DateTime $timestampUsuario
     * @return DoteProcessado
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
     * Set timestampProcessado
     *
     * @param \DateTime $timestampProcessado
     * @return DoteProcessado
     */
    public function setTimestampProcessado(\DateTime $timestampProcessado)
    {
        $this->timestampProcessado = $timestampProcessado;
        return $this;
    }

    /**
     * Get timestampProcessado
     *
     * @return \DateTime
     */
    public function getTimestampProcessado()
    {
        return $this->timestampProcessado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     * @return DoteProcessado
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

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeLote
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lote $fkContabilidadeLote
     * @return DoteProcessado
     */
    public function setFkContabilidadeLote(\Urbem\CoreBundle\Entity\Contabilidade\Lote $fkContabilidadeLote)
    {
        $this->codLote = $fkContabilidadeLote->getCodLote();
        $this->exercicio = $fkContabilidadeLote->getExercicio();
        $this->tipo = $fkContabilidadeLote->getTipo();
        $this->codEntidade = $fkContabilidadeLote->getCodEntidade();
        $this->fkContabilidadeLote = $fkContabilidadeLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeLote
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\Lote
     */
    public function getFkContabilidadeLote()
    {
        return $this->fkContabilidadeLote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     * @return DoteProcessado
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
     * Set TesourariaDote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Dote $fkTesourariaDote
     * @return DoteProcessado
     */
    public function setFkTesourariaDote(\Urbem\CoreBundle\Entity\Tesouraria\Dote $fkTesourariaDote)
    {
        $this->codDote = $fkTesourariaDote->getCodDote();
        $this->exercicio = $fkTesourariaDote->getExercicio();
        $this->codEntidade = $fkTesourariaDote->getCodEntidade();
        $this->fkTesourariaDote = $fkTesourariaDote;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkTesourariaDote
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Dote
     */
    public function getFkTesourariaDote()
    {
        return $this->fkTesourariaDote;
    }
}
