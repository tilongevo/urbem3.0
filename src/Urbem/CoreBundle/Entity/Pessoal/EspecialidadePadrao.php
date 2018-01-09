<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * EspecialidadePadrao
 */
class EspecialidadePadrao
{
    /**
     * PK
     * @var integer
     */
    private $codPadrao;

    /**
     * PK
     * @var integer
     */
    private $codEspecialidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Padrao
     */
    private $fkFolhapagamentoPadrao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Especialidade
     */
    private $fkPessoalEspecialidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codPadrao
     *
     * @param integer $codPadrao
     * @return EspecialidadePadrao
     */
    public function setCodPadrao($codPadrao)
    {
        $this->codPadrao = $codPadrao;
        return $this;
    }

    /**
     * Get codPadrao
     *
     * @return integer
     */
    public function getCodPadrao()
    {
        return $this->codPadrao;
    }

    /**
     * Set codEspecialidade
     *
     * @param integer $codEspecialidade
     * @return EspecialidadePadrao
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return EspecialidadePadrao
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
     * Set fkFolhapagamentoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Padrao $fkFolhapagamentoPadrao
     * @return EspecialidadePadrao
     */
    public function setFkFolhapagamentoPadrao(\Urbem\CoreBundle\Entity\Folhapagamento\Padrao $fkFolhapagamentoPadrao)
    {
        $this->codPadrao = $fkFolhapagamentoPadrao->getCodPadrao();
        $this->fkFolhapagamentoPadrao = $fkFolhapagamentoPadrao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPadrao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Padrao
     */
    public function getFkFolhapagamentoPadrao()
    {
        return $this->fkFolhapagamentoPadrao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Especialidade $fkPessoalEspecialidade
     * @return EspecialidadePadrao
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
}
