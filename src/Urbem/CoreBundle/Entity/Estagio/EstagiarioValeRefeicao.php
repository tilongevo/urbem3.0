<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * EstagiarioValeRefeicao
 */
class EstagiarioValeRefeicao
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
    private $quantidade;

    /**
     * @var integer
     */
    private $vlVale;

    /**
     * @var integer
     */
    private $vlDesconto;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa
     */
    private $fkEstagioEstagiarioEstagioBolsa;

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
     * @return EstagiarioValeRefeicao
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
     * @return EstagiarioValeRefeicao
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
     * @return EstagiarioValeRefeicao
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
     * @return EstagiarioValeRefeicao
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
     * @return EstagiarioValeRefeicao
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return EstagiarioValeRefeicao
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
     * Set vlVale
     *
     * @param integer $vlVale
     * @return EstagiarioValeRefeicao
     */
    public function setVlVale($vlVale)
    {
        $this->vlVale = $vlVale;
        return $this;
    }

    /**
     * Get vlVale
     *
     * @return integer
     */
    public function getVlVale()
    {
        return $this->vlVale;
    }

    /**
     * Set vlDesconto
     *
     * @param integer $vlDesconto
     * @return EstagiarioValeRefeicao
     */
    public function setVlDesconto($vlDesconto)
    {
        $this->vlDesconto = $vlDesconto;
        return $this;
    }

    /**
     * Get vlDesconto
     *
     * @return integer
     */
    public function getVlDesconto()
    {
        return $this->vlDesconto;
    }

    /**
     * OneToOne (owning side)
     * Set EstagioEstagiarioEstagioBolsa
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa $fkEstagioEstagiarioEstagioBolsa
     * @return EstagiarioValeRefeicao
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
