<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * BemComprado
 */
class BemComprado
{
    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var string
     */
    private $notaFiscal;

    /**
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $numUnidade;

    /**
     * @var \DateTime
     */
    private $dataNotaFiscal;

    /**
     * @var string
     */
    private $caminhoNf;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceal\BemCompradoTipoDocumentoFiscal
     */
    private $fkTcealBemCompradoTipoDocumentoFiscal;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;


    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return BemComprado
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return BemComprado
     */
    public function setCodEmpenho($codEmpenho = null)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return BemComprado
     */
    public function setExercicio($exercicio = null)
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return BemComprado
     */
    public function setCodEntidade($codEntidade = null)
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
     * Set notaFiscal
     *
     * @param string $notaFiscal
     * @return BemComprado
     */
    public function setNotaFiscal($notaFiscal = null)
    {
        $this->notaFiscal = $notaFiscal;
        return $this;
    }

    /**
     * Get notaFiscal
     *
     * @return string
     */
    public function getNotaFiscal()
    {
        return $this->notaFiscal;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return BemComprado
     */
    public function setNumOrgao($numOrgao = null)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return BemComprado
     */
    public function setNumUnidade($numUnidade = null)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set dataNotaFiscal
     *
     * @param \DateTime $dataNotaFiscal
     * @return BemComprado
     */
    public function setDataNotaFiscal(\DateTime $dataNotaFiscal = null)
    {
        $this->dataNotaFiscal = $dataNotaFiscal;
        return $this;
    }

    /**
     * Get dataNotaFiscal
     *
     * @return \DateTime
     */
    public function getDataNotaFiscal()
    {
        return $this->dataNotaFiscal;
    }

    /**
     * Set caminhoNf
     *
     * @param string $caminhoNf
     * @return BemComprado
     */
    public function setCaminhoNf($caminhoNf = null)
    {
        $this->caminhoNf = $caminhoNf;
        return $this;
    }

    /**
     * Get caminhoNf
     *
     * @return string
     */
    public function getCaminhoNf()
    {
        return $this->caminhoNf;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return BemComprado
     */
    public function setFkOrcamentoUnidade(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->exercicio = $fkOrcamentoUnidade->getExercicio();
        $this->numUnidade = $fkOrcamentoUnidade->getNumUnidade();
        $this->numOrgao = $fkOrcamentoUnidade->getNumOrgao();
        $this->fkOrcamentoUnidade = $fkOrcamentoUnidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoUnidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function getFkOrcamentoUnidade()
    {
        return $this->fkOrcamentoUnidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return BemComprado
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
     * OneToOne (inverse side)
     * Set TcealBemCompradoTipoDocumentoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\BemCompradoTipoDocumentoFiscal $fkTcealBemCompradoTipoDocumentoFiscal
     * @return BemComprado
     */
    public function setFkTcealBemCompradoTipoDocumentoFiscal(\Urbem\CoreBundle\Entity\Tceal\BemCompradoTipoDocumentoFiscal $fkTcealBemCompradoTipoDocumentoFiscal)
    {
        $fkTcealBemCompradoTipoDocumentoFiscal->setFkPatrimonioBemComprado($this);
        $this->fkTcealBemCompradoTipoDocumentoFiscal = $fkTcealBemCompradoTipoDocumentoFiscal;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcealBemCompradoTipoDocumentoFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Tceal\BemCompradoTipoDocumentoFiscal
     */
    public function getFkTcealBemCompradoTipoDocumentoFiscal()
    {
        return $this->fkTcealBemCompradoTipoDocumentoFiscal;
    }

    /**
     * OneToOne (owning side)
     * Set PatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return BemComprado
     */
    public function setFkPatrimonioBem(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->codBem = $fkPatrimonioBem->getCodBem();
        $this->fkPatrimonioBem = $fkPatrimonioBem;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPatrimonioBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBem()
    {
        return $this->fkPatrimonioBem;
    }
}
