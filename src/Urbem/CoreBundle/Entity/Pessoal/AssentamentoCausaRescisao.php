<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoCausaRescisao
 */
class AssentamentoCausaRescisao
{
    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * PK
     * @var integer
     */
    private $codCausaRescisao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Assentamento
     */
    private $fkPessoalAssentamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\CausaRescisao
     */
    private $fkPessoalCausaRescisao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return AssentamentoCausaRescisao
     */
    public function setCodAssentamento($codAssentamento)
    {
        $this->codAssentamento = $codAssentamento;
        return $this;
    }

    /**
     * Get codAssentamento
     *
     * @return integer
     */
    public function getCodAssentamento()
    {
        return $this->codAssentamento;
    }

    /**
     * Set codCausaRescisao
     *
     * @param integer $codCausaRescisao
     * @return AssentamentoCausaRescisao
     */
    public function setCodCausaRescisao($codCausaRescisao)
    {
        $this->codCausaRescisao = $codCausaRescisao;
        return $this;
    }

    /**
     * Get codCausaRescisao
     *
     * @return integer
     */
    public function getCodCausaRescisao()
    {
        return $this->codCausaRescisao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AssentamentoCausaRescisao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
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
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return AssentamentoCausaRescisao
     */
    public function setVigencia(\DateTime $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento
     * @return AssentamentoCausaRescisao
     */
    public function setFkPessoalAssentamento(\Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento)
    {
        $this->codAssentamento = $fkPessoalAssentamento->getCodAssentamento();
        $this->timestamp = $fkPessoalAssentamento->getTimestamp();
        $this->fkPessoalAssentamento = $fkPessoalAssentamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Assentamento
     */
    public function getFkPessoalAssentamento()
    {
        return $this->fkPessoalAssentamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCausaRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao
     * @return AssentamentoCausaRescisao
     */
    public function setFkPessoalCausaRescisao(\Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao)
    {
        $this->codCausaRescisao = $fkPessoalCausaRescisao->getCodCausaRescisao();
        $this->fkPessoalCausaRescisao = $fkPessoalCausaRescisao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCausaRescisao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\CausaRescisao
     */
    public function getFkPessoalCausaRescisao()
    {
        return $this->fkPessoalCausaRescisao;
    }
}
