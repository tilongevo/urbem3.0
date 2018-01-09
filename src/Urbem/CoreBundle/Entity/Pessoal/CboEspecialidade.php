<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CboEspecialidade
 */
class CboEspecialidade
{
    /**
     * PK
     * @var integer
     */
    private $codEspecialidade;

    /**
     * PK
     * @var integer
     */
    private $codCbo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Especialidade
     */
    private $fkPessoalEspecialidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cbo
     */
    private $fkPessoalCbo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEspecialidade
     *
     * @param integer $codEspecialidade
     * @return CboEspecialidade
     */
    public function setCodEspecialidade($codEspecialidade)
    {
        $this->codEspecialidade = $codEspecialidade;
        return $this;
    }

    /**
     * Get codEspecialidade
     *
     * @return integer
     */
    public function getCodEspecialidade()
    {
        return $this->codEspecialidade;
    }

    /**
     * Set codCbo
     *
     * @param integer $codCbo
     * @return CboEspecialidade
     */
    public function setCodCbo($codCbo)
    {
        $this->codCbo = $codCbo;
        return $this;
    }

    /**
     * Get codCbo
     *
     * @return integer
     */
    public function getCodCbo()
    {
        return $this->codCbo;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CboEspecialidade
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
     * ManyToOne (inverse side)
     * Set fkPessoalEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Especialidade $fkPessoalEspecialidade
     * @return CboEspecialidade
     */
    public function setFkPessoalEspecialidade(\Urbem\CoreBundle\Entity\Pessoal\Especialidade $fkPessoalEspecialidade)
    {
        $this->codEspecialidade = $fkPessoalEspecialidade->getCodEspecialidade();
        $this->fkPessoalEspecialidade = $fkPessoalEspecialidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalEspecialidade
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Especialidade
     */
    public function getFkPessoalEspecialidade()
    {
        return $this->fkPessoalEspecialidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCbo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cbo $fkPessoalCbo
     * @return CboEspecialidade
     */
    public function setFkPessoalCbo(\Urbem\CoreBundle\Entity\Pessoal\Cbo $fkPessoalCbo)
    {
        $this->codCbo = $fkPessoalCbo->getCodCbo();
        $this->fkPessoalCbo = $fkPessoalCbo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCbo
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cbo
     */
    public function getFkPessoalCbo()
    {
        return $this->fkPessoalCbo;
    }
}
