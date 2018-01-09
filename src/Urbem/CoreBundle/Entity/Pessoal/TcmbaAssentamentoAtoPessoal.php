<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * TcmbaAssentamentoAtoPessoal
 */
class TcmbaAssentamentoAtoPessoal
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
    private $codTipoAtoPessoal;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    private $fkPessoalAssentamentoAssentamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoAtoPessoal
     */
    private $fkTcmbaTipoAtoPessoal;


    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return TcmbaAssentamentoAtoPessoal
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
     * Set codTipoAtoPessoal
     *
     * @param integer $codTipoAtoPessoal
     * @return TcmbaAssentamentoAtoPessoal
     */
    public function setCodTipoAtoPessoal($codTipoAtoPessoal)
    {
        $this->codTipoAtoPessoal = $codTipoAtoPessoal;
        return $this;
    }

    /**
     * Get codTipoAtoPessoal
     *
     * @return integer
     */
    public function getCodTipoAtoPessoal()
    {
        return $this->codTipoAtoPessoal;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TcmbaAssentamentoAtoPessoal
     */
    public function setExercicio($exercicio)
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
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     * @return TcmbaAssentamentoAtoPessoal
     */
    public function setFkPessoalAssentamentoAssentamento(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        $this->codAssentamento = $fkPessoalAssentamentoAssentamento->getCodAssentamento();
        $this->fkPessoalAssentamentoAssentamento = $fkPessoalAssentamentoAssentamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamentoAssentamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    public function getFkPessoalAssentamentoAssentamento()
    {
        return $this->fkPessoalAssentamentoAssentamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaTipoAtoPessoal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoAtoPessoal $fkTcmbaTipoAtoPessoal
     * @return TcmbaAssentamentoAtoPessoal
     */
    public function setFkTcmbaTipoAtoPessoal(\Urbem\CoreBundle\Entity\Tcmba\TipoAtoPessoal $fkTcmbaTipoAtoPessoal)
    {
        $this->codTipoAtoPessoal = $fkTcmbaTipoAtoPessoal->getCodTipo();
        $this->fkTcmbaTipoAtoPessoal = $fkTcmbaTipoAtoPessoal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoAtoPessoal
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoAtoPessoal
     */
    public function getFkTcmbaTipoAtoPessoal()
    {
        return $this->fkTcmbaTipoAtoPessoal;
    }
}
