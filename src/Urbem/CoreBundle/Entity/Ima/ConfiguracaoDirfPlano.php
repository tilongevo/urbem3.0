<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoDirfPlano
 */
class ConfiguracaoDirfPlano
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $registroAns;

    /**
     * @var integer
     */
    private $codEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    private $fkImaConfiguracaoDirf;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoDirfPlano
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ConfiguracaoDirfPlano
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
     * Set registroAns
     *
     * @param integer $registroAns
     * @return ConfiguracaoDirfPlano
     */
    public function setRegistroAns($registroAns)
    {
        $this->registroAns = $registroAns;
        return $this;
    }

    /**
     * Get registroAns
     *
     * @return integer
     */
    public function getRegistroAns()
    {
        return $this->registroAns;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return ConfiguracaoDirfPlano
     */
    public function setCodEvento($codEvento)
    {
        $this->codEvento = $codEvento;
        return $this;
    }

    /**
     * Get codEvento
     *
     * @return integer
     */
    public function getCodEvento()
    {
        return $this->codEvento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaConfiguracaoDirf
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf
     * @return ConfiguracaoDirfPlano
     */
    public function setFkImaConfiguracaoDirf(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf)
    {
        $this->exercicio = $fkImaConfiguracaoDirf->getExercicio();
        $this->fkImaConfiguracaoDirf = $fkImaConfiguracaoDirf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaConfiguracaoDirf
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    public function getFkImaConfiguracaoDirf()
    {
        return $this->fkImaConfiguracaoDirf;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return ConfiguracaoDirfPlano
     */
    public function setFkSwCgmPessoaJuridica(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        $this->numcgm = $fkSwCgmPessoaJuridica->getNumcgm();
        $this->fkSwCgmPessoaJuridica = $fkSwCgmPessoaJuridica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    public function getFkSwCgmPessoaJuridica()
    {
        return $this->fkSwCgmPessoaJuridica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return ConfiguracaoDirfPlano
     */
    public function setFkFolhapagamentoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->codEvento = $fkFolhapagamentoEvento->getCodEvento();
        $this->fkFolhapagamentoEvento = $fkFolhapagamentoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento()
    {
        return $this->fkFolhapagamentoEvento;
    }
}
