<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * EstagiarioValeTransporte
 */
class EstagiarioValeTransporte
{
    /**
     * PK
     * @var integer
     */
    private $cgmInstituicaoEnsino;

    /**
     * PK
     * @var integer
     */
    private $cgmEstagiario;

    /**
     * PK
     * @var integer
     */
    private $codCurso;

    /**
     * PK
     * @var integer
     */
    private $codEstagio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $valorUnitario;

    /**
     * @var integer
     */
    private $codCalendar;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa
     */
    private $fkEstagioEstagiarioEstagioBolsa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\TipoContagemVale
     */
    private $fkEstagioTipoContagemVale;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro
     */
    private $fkCalendarioCalendarioCadastro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set cgmInstituicaoEnsino
     *
     * @param integer $cgmInstituicaoEnsino
     * @return EstagiarioValeTransporte
     */
    public function setCgmInstituicaoEnsino($cgmInstituicaoEnsino)
    {
        $this->cgmInstituicaoEnsino = $cgmInstituicaoEnsino;
        return $this;
    }

    /**
     * Get cgmInstituicaoEnsino
     *
     * @return integer
     */
    public function getCgmInstituicaoEnsino()
    {
        return $this->cgmInstituicaoEnsino;
    }

    /**
     * Set cgmEstagiario
     *
     * @param integer $cgmEstagiario
     * @return EstagiarioValeTransporte
     */
    public function setCgmEstagiario($cgmEstagiario)
    {
        $this->cgmEstagiario = $cgmEstagiario;
        return $this;
    }

    /**
     * Get cgmEstagiario
     *
     * @return integer
     */
    public function getCgmEstagiario()
    {
        return $this->cgmEstagiario;
    }

    /**
     * Set codCurso
     *
     * @param integer $codCurso
     * @return EstagiarioValeTransporte
     */
    public function setCodCurso($codCurso)
    {
        $this->codCurso = $codCurso;
        return $this;
    }

    /**
     * Get codCurso
     *
     * @return integer
     */
    public function getCodCurso()
    {
        return $this->codCurso;
    }

    /**
     * Set codEstagio
     *
     * @param integer $codEstagio
     * @return EstagiarioValeTransporte
     */
    public function setCodEstagio($codEstagio)
    {
        $this->codEstagio = $codEstagio;
        return $this;
    }

    /**
     * Get codEstagio
     *
     * @return integer
     */
    public function getCodEstagio()
    {
        return $this->codEstagio;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return EstagiarioValeTransporte
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return EstagiarioValeTransporte
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return EstagiarioValeTransporte
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set valorUnitario
     *
     * @param integer $valorUnitario
     * @return EstagiarioValeTransporte
     */
    public function setValorUnitario($valorUnitario)
    {
        $this->valorUnitario = $valorUnitario;
        return $this;
    }

    /**
     * Get valorUnitario
     *
     * @return integer
     */
    public function getValorUnitario()
    {
        return $this->valorUnitario;
    }

    /**
     * Set codCalendar
     *
     * @param integer $codCalendar
     * @return EstagiarioValeTransporte
     */
    public function setCodCalendar($codCalendar = null)
    {
        $this->codCalendar = $codCalendar;
        return $this;
    }

    /**
     * Get codCalendar
     *
     * @return integer
     */
    public function getCodCalendar()
    {
        return $this->codCalendar;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioTipoContagemVale
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\TipoContagemVale $fkEstagioTipoContagemVale
     * @return EstagiarioValeTransporte
     */
    public function setFkEstagioTipoContagemVale(\Urbem\CoreBundle\Entity\Estagio\TipoContagemVale $fkEstagioTipoContagemVale)
    {
        $this->codTipo = $fkEstagioTipoContagemVale->getCodTipo();
        $this->fkEstagioTipoContagemVale = $fkEstagioTipoContagemVale;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEstagioTipoContagemVale
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\TipoContagemVale
     */
    public function getFkEstagioTipoContagemVale()
    {
        return $this->fkEstagioTipoContagemVale;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCalendarioCalendarioCadastro
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro $fkCalendarioCalendarioCadastro
     * @return EstagiarioValeTransporte
     */
    public function setFkCalendarioCalendarioCadastro(\Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro $fkCalendarioCalendarioCadastro)
    {
        $this->codCalendar = $fkCalendarioCalendarioCadastro->getCodCalendar();
        $this->fkCalendarioCalendarioCadastro = $fkCalendarioCalendarioCadastro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCalendarioCalendarioCadastro
     *
     * @return \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro
     */
    public function getFkCalendarioCalendarioCadastro()
    {
        return $this->fkCalendarioCalendarioCadastro;
    }

    /**
     * OneToOne (owning side)
     * Set EstagioEstagiarioEstagioBolsa
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa $fkEstagioEstagiarioEstagioBolsa
     * @return EstagiarioValeTransporte
     */
    public function setFkEstagioEstagiarioEstagioBolsa(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa $fkEstagioEstagiarioEstagioBolsa)
    {
        $this->cgmInstituicaoEnsino = $fkEstagioEstagiarioEstagioBolsa->getCgmInstituicaoEnsino();
        $this->cgmEstagiario = $fkEstagioEstagiarioEstagioBolsa->getCgmEstagiario();
        $this->codCurso = $fkEstagioEstagiarioEstagioBolsa->getCodCurso();
        $this->codEstagio = $fkEstagioEstagiarioEstagioBolsa->getCodEstagio();
        $this->timestamp = $fkEstagioEstagiarioEstagioBolsa->getTimestamp();
        $this->fkEstagioEstagiarioEstagioBolsa = $fkEstagioEstagiarioEstagioBolsa;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEstagioEstagiarioEstagioBolsa
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa
     */
    public function getFkEstagioEstagiarioEstagioBolsa()
    {
        return $this->fkEstagioEstagiarioEstagioBolsa;
    }
}
