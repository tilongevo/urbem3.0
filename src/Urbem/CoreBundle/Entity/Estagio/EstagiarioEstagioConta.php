<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * EstagiarioEstagioConta
 */
class EstagiarioEstagioConta
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $codEstagio;

    /**
     * PK
     * @var integer
     */
    private $codCurso;

    /**
     * PK
     * @var integer
     */
    private $cgmInstituicaoEnsino;

    /**
     * @var integer
     */
    private $codBanco;

    /**
     * @var integer
     */
    private $codAgencia;

    /**
     * @var string
     */
    private $numConta;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    private $fkEstagioEstagiarioEstagio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    private $fkMonetarioAgencia;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return EstagiarioEstagioConta
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set codEstagio
     *
     * @param integer $codEstagio
     * @return EstagiarioEstagioConta
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
     * Set codCurso
     *
     * @param integer $codCurso
     * @return EstagiarioEstagioConta
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
     * Set cgmInstituicaoEnsino
     *
     * @param integer $cgmInstituicaoEnsino
     * @return EstagiarioEstagioConta
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
     * Set codBanco
     *
     * @param integer $codBanco
     * @return EstagiarioEstagioConta
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return EstagiarioEstagioConta
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set numConta
     *
     * @param string $numConta
     * @return EstagiarioEstagioConta
     */
    public function setNumConta($numConta)
    {
        $this->numConta = $numConta;
        return $this;
    }

    /**
     * Get numConta
     *
     * @return string
     */
    public function getNumConta()
    {
        return $this->numConta;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia
     * @return EstagiarioEstagioConta
     */
    public function setFkMonetarioAgencia(\Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia)
    {
        $this->codBanco = $fkMonetarioAgencia->getCodBanco();
        $this->codAgencia = $fkMonetarioAgencia->getCodAgencia();
        $this->fkMonetarioAgencia = $fkMonetarioAgencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioAgencia
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    public function getFkMonetarioAgencia()
    {
        return $this->fkMonetarioAgencia;
    }

    /**
     * OneToOne (owning side)
     * Set EstagioEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio
     * @return EstagiarioEstagioConta
     */
    public function setFkEstagioEstagiarioEstagio(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio)
    {
        $this->codEstagio = $fkEstagioEstagiarioEstagio->getCodEstagio();
        $this->numcgm = $fkEstagioEstagiarioEstagio->getCgmEstagiario();
        $this->codCurso = $fkEstagioEstagiarioEstagio->getCodCurso();
        $this->cgmInstituicaoEnsino = $fkEstagioEstagiarioEstagio->getCgmInstituicaoEnsino();
        $this->fkEstagioEstagiarioEstagio = $fkEstagioEstagiarioEstagio;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEstagioEstagiarioEstagio
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    public function getFkEstagioEstagiarioEstagio()
    {
        return $this->fkEstagioEstagiarioEstagio;
    }
}
