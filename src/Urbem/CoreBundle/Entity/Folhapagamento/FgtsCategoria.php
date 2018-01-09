<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * FgtsCategoria
 */
class FgtsCategoria
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codCategoria;

    /**
     * PK
     * @var integer
     */
    private $codFgts;

    /**
     * @var integer
     */
    private $aliquotaDeposito;

    /**
     * @var integer
     */
    private $aliquotaContribuicao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Fgts
     */
    private $fkFolhapagamentoFgts;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Categoria
     */
    private $fkPessoalCategoria;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return FgtsCategoria
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return FgtsCategoria
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * Set codFgts
     *
     * @param integer $codFgts
     * @return FgtsCategoria
     */
    public function setCodFgts($codFgts)
    {
        $this->codFgts = $codFgts;
        return $this;
    }

    /**
     * Get codFgts
     *
     * @return integer
     */
    public function getCodFgts()
    {
        return $this->codFgts;
    }

    /**
     * Set aliquotaDeposito
     *
     * @param integer $aliquotaDeposito
     * @return FgtsCategoria
     */
    public function setAliquotaDeposito($aliquotaDeposito = null)
    {
        $this->aliquotaDeposito = $aliquotaDeposito;
        return $this;
    }

    /**
     * Get aliquotaDeposito
     *
     * @return integer
     */
    public function getAliquotaDeposito()
    {
        return $this->aliquotaDeposito;
    }

    /**
     * Set aliquotaContribuicao
     *
     * @param integer $aliquotaContribuicao
     * @return FgtsCategoria
     */
    public function setAliquotaContribuicao($aliquotaContribuicao = null)
    {
        $this->aliquotaContribuicao = $aliquotaContribuicao;
        return $this;
    }

    /**
     * Get aliquotaContribuicao
     *
     * @return integer
     */
    public function getAliquotaContribuicao()
    {
        return $this->aliquotaContribuicao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoFgts
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Fgts $fkFolhapagamentoFgts
     * @return FgtsCategoria
     */
    public function setFkFolhapagamentoFgts(\Urbem\CoreBundle\Entity\Folhapagamento\Fgts $fkFolhapagamentoFgts)
    {
        $this->codFgts = $fkFolhapagamentoFgts->getCodFgts();
        $this->timestamp = $fkFolhapagamentoFgts->getTimestamp();
        $this->fkFolhapagamentoFgts = $fkFolhapagamentoFgts;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoFgts
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Fgts
     */
    public function getFkFolhapagamentoFgts()
    {
        return $this->fkFolhapagamentoFgts;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCategoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Categoria $fkPessoalCategoria
     * @return FgtsCategoria
     */
    public function setFkPessoalCategoria(\Urbem\CoreBundle\Entity\Pessoal\Categoria $fkPessoalCategoria)
    {
        $this->codCategoria = $fkPessoalCategoria->getCodCategoria();
        $this->fkPessoalCategoria = $fkPessoalCategoria;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCategoria
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Categoria
     */
    public function getFkPessoalCategoria()
    {
        return $this->fkPessoalCategoria;
    }
}
