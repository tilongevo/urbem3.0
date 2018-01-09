<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * AtributoEstagiarioEstagio
 */
class AtributoEstagiarioEstagio
{
    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

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
     * @var string
     */
    private $valor;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    private $fkEstagioEstagiarioEstagio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoEstagiarioEstagio
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoEstagiarioEstagio
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoEstagiarioEstagio
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return AtributoEstagiarioEstagio
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
     * @return AtributoEstagiarioEstagio
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
     * @return AtributoEstagiarioEstagio
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
     * @return AtributoEstagiarioEstagio
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
     * Set valor
     *
     * @param string $valor
     * @return AtributoEstagiarioEstagio
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return AtributoEstagiarioEstagio
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoEstagiarioEstagio
     */
    public function setFkAdministracaoAtributoDinamico(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        $this->codModulo = $fkAdministracaoAtributoDinamico->getCodModulo();
        $this->codCadastro = $fkAdministracaoAtributoDinamico->getCodCadastro();
        $this->codAtributo = $fkAdministracaoAtributoDinamico->getCodAtributo();
        $this->fkAdministracaoAtributoDinamico = $fkAdministracaoAtributoDinamico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAtributoDinamico
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    public function getFkAdministracaoAtributoDinamico()
    {
        return $this->fkAdministracaoAtributoDinamico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio
     * @return AtributoEstagiarioEstagio
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
     * ManyToOne (inverse side)
     * Get fkEstagioEstagiarioEstagio
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    public function getFkEstagioEstagiarioEstagio()
    {
        return $this->fkEstagioEstagiarioEstagio;
    }
}
