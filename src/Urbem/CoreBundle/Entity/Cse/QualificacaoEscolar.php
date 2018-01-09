<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * QualificacaoEscolar
 */
class QualificacaoEscolar
{
    /**
     * PK
     * @var integer
     */
    private $codGrau;

    /**
     * PK
     * @var integer
     */
    private $codInstituicao;

    /**
     * PK
     * @var integer
     */
    private $codCidadao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtCadastro;

    /**
     * @var string
     */
    private $serie;

    /**
     * @var string
     */
    private $frequencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\GrauEscolar
     */
    private $fkCseGrauEscolar;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\InstituicaoEducacional
     */
    private $fkCseInstituicaoEducacional;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    private $fkCseCidadao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtCadastro = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codGrau
     *
     * @param integer $codGrau
     * @return QualificacaoEscolar
     */
    public function setCodGrau($codGrau)
    {
        $this->codGrau = $codGrau;
        return $this;
    }

    /**
     * Get codGrau
     *
     * @return integer
     */
    public function getCodGrau()
    {
        return $this->codGrau;
    }

    /**
     * Set codInstituicao
     *
     * @param integer $codInstituicao
     * @return QualificacaoEscolar
     */
    public function setCodInstituicao($codInstituicao)
    {
        $this->codInstituicao = $codInstituicao;
        return $this;
    }

    /**
     * Get codInstituicao
     *
     * @return integer
     */
    public function getCodInstituicao()
    {
        return $this->codInstituicao;
    }

    /**
     * Set codCidadao
     *
     * @param integer $codCidadao
     * @return QualificacaoEscolar
     */
    public function setCodCidadao($codCidadao)
    {
        $this->codCidadao = $codCidadao;
        return $this;
    }

    /**
     * Get codCidadao
     *
     * @return integer
     */
    public function getCodCidadao()
    {
        return $this->codCidadao;
    }

    /**
     * Set dtCadastro
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtCadastro
     * @return QualificacaoEscolar
     */
    public function setDtCadastro(\Urbem\CoreBundle\Helper\DatePK $dtCadastro)
    {
        $this->dtCadastro = $dtCadastro;
        return $this;
    }

    /**
     * Get dtCadastro
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * Set serie
     *
     * @param string $serie
     * @return QualificacaoEscolar
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set frequencia
     *
     * @param string $frequencia
     * @return QualificacaoEscolar
     */
    public function setFrequencia($frequencia)
    {
        $this->frequencia = $frequencia;
        return $this;
    }

    /**
     * Get frequencia
     *
     * @return string
     */
    public function getFrequencia()
    {
        return $this->frequencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseGrauEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Cse\GrauEscolar $fkCseGrauEscolar
     * @return QualificacaoEscolar
     */
    public function setFkCseGrauEscolar(\Urbem\CoreBundle\Entity\Cse\GrauEscolar $fkCseGrauEscolar)
    {
        $this->codGrau = $fkCseGrauEscolar->getCodGrau();
        $this->fkCseGrauEscolar = $fkCseGrauEscolar;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseGrauEscolar
     *
     * @return \Urbem\CoreBundle\Entity\Cse\GrauEscolar
     */
    public function getFkCseGrauEscolar()
    {
        return $this->fkCseGrauEscolar;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseInstituicaoEducacional
     *
     * @param \Urbem\CoreBundle\Entity\Cse\InstituicaoEducacional $fkCseInstituicaoEducacional
     * @return QualificacaoEscolar
     */
    public function setFkCseInstituicaoEducacional(\Urbem\CoreBundle\Entity\Cse\InstituicaoEducacional $fkCseInstituicaoEducacional)
    {
        $this->codInstituicao = $fkCseInstituicaoEducacional->getCodInstituicao();
        $this->fkCseInstituicaoEducacional = $fkCseInstituicaoEducacional;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseInstituicaoEducacional
     *
     * @return \Urbem\CoreBundle\Entity\Cse\InstituicaoEducacional
     */
    public function getFkCseInstituicaoEducacional()
    {
        return $this->fkCseInstituicaoEducacional;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return QualificacaoEscolar
     */
    public function setFkCseCidadao(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        $this->codCidadao = $fkCseCidadao->getCodCidadao();
        $this->fkCseCidadao = $fkCseCidadao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseCidadao
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    public function getFkCseCidadao()
    {
        return $this->fkCseCidadao;
    }
}
