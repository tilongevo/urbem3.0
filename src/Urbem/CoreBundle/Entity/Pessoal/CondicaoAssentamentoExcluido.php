<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CondicaoAssentamentoExcluido
 */
class CondicaoAssentamentoExcluido
{
    /**
     * PK
     * @var integer
     */
    private $codCondicao;

    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $timestampExclusao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento
     */
    private $fkPessoalCondicaoAssentamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampExclusao = new \DateTime;
    }

    /**
     * Set codCondicao
     *
     * @param integer $codCondicao
     * @return CondicaoAssentamentoExcluido
     */
    public function setCodCondicao($codCondicao)
    {
        $this->codCondicao = $codCondicao;
        return $this;
    }

    /**
     * Get codCondicao
     *
     * @return integer
     */
    public function getCodCondicao()
    {
        return $this->codCondicao;
    }

    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return CondicaoAssentamentoExcluido
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CondicaoAssentamentoExcluido
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
     * Set timestampExclusao
     *
     * @param \DateTime $timestampExclusao
     * @return CondicaoAssentamentoExcluido
     */
    public function setTimestampExclusao(\DateTime $timestampExclusao)
    {
        $this->timestampExclusao = $timestampExclusao;
        return $this;
    }

    /**
     * Get timestampExclusao
     *
     * @return \DateTime
     */
    public function getTimestampExclusao()
    {
        return $this->timestampExclusao;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalCondicaoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento $fkPessoalCondicaoAssentamento
     * @return CondicaoAssentamentoExcluido
     */
    public function setFkPessoalCondicaoAssentamento(\Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento $fkPessoalCondicaoAssentamento)
    {
        $this->codCondicao = $fkPessoalCondicaoAssentamento->getCodCondicao();
        $this->timestamp = $fkPessoalCondicaoAssentamento->getTimestamp();
        $this->codAssentamento = $fkPessoalCondicaoAssentamento->getCodAssentamento();
        $this->fkPessoalCondicaoAssentamento = $fkPessoalCondicaoAssentamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalCondicaoAssentamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento
     */
    public function getFkPessoalCondicaoAssentamento()
    {
        return $this->fkPessoalCondicaoAssentamento;
    }
}
