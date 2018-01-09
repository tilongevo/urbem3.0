<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * ConfiguracaoParametrosGerais
 */
class ConfiguracaoParametrosGerais
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codDiaDsr;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var boolean
     */
    private $limitarAtrasos = false;

    /**
     * @var \DateTime
     */
    private $horaNoturno1;

    /**
     * @var \DateTime
     */
    private $horaNoturno2;

    /**
     * @var boolean
     */
    private $separarAdicional = false;

    /**
     * @var boolean
     */
    private $lancarAbono = false;

    /**
     * @var boolean
     */
    private $lancarDesconto = false;

    /**
     * @var boolean
     */
    private $trabalhoFeriado = false;

    /**
     * @var boolean
     */
    private $somarExtras = false;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\Atrasos
     */
    private $fkPontoAtrasos;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\Faltas
     */
    private $fkPontoFaltas;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\FaltaDsr
     */
    private $fkPontoFaltaDsr;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\HorasDescontoDsr
     */
    private $fkPontoHorasDescontoDsr;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\FatorMultiplicacao
     */
    private $fkPontoFatorMultiplicacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\HorasExtras
     */
    private $fkPontoHorasExtras;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\HorasPosterior
     */
    private $fkPontoHorasPosterior;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\HorasAnterior
     */
    private $fkPontoHorasAnterior;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\RemarcacoesConsecutivas
     */
    private $fkPontoRemarcacoesConsecutivas;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\ArredondarTempo
     */
    private $fkPontoArredondarTempo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\CalendarioPonto
     */
    private $fkPontoCalendarioPonto;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoLotacao
     */
    private $fkPontoConfiguracaoLotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DiasUteis
     */
    private $fkPontoDiasUteis;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto
     */
    private $fkPontoConfiguracaoRelogioPonto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\DiasSemana
     */
    private $fkAdministracaoDiasSemana;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoConfiguracaoLotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoDiasUteis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoParametrosGerais
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ConfiguracaoParametrosGerais
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
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
     * Set codDiaDsr
     *
     * @param integer $codDiaDsr
     * @return ConfiguracaoParametrosGerais
     */
    public function setCodDiaDsr($codDiaDsr)
    {
        $this->codDiaDsr = $codDiaDsr;
        return $this;
    }

    /**
     * Get codDiaDsr
     *
     * @return integer
     */
    public function getCodDiaDsr()
    {
        return $this->codDiaDsr;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ConfiguracaoParametrosGerais
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set limitarAtrasos
     *
     * @param boolean $limitarAtrasos
     * @return ConfiguracaoParametrosGerais
     */
    public function setLimitarAtrasos($limitarAtrasos)
    {
        $this->limitarAtrasos = $limitarAtrasos;
        return $this;
    }

    /**
     * Get limitarAtrasos
     *
     * @return boolean
     */
    public function getLimitarAtrasos()
    {
        return $this->limitarAtrasos;
    }

    /**
     * Set horaNoturno1
     *
     * @param \DateTime $horaNoturno1
     * @return ConfiguracaoParametrosGerais
     */
    public function setHoraNoturno1(\DateTime $horaNoturno1)
    {
        $this->horaNoturno1 = $horaNoturno1;
        return $this;
    }

    /**
     * Get horaNoturno1
     *
     * @return \DateTime
     */
    public function getHoraNoturno1()
    {
        return $this->horaNoturno1;
    }

    /**
     * Set horaNoturno2
     *
     * @param \DateTime $horaNoturno2
     * @return ConfiguracaoParametrosGerais
     */
    public function setHoraNoturno2(\DateTime $horaNoturno2)
    {
        $this->horaNoturno2 = $horaNoturno2;
        return $this;
    }

    /**
     * Get horaNoturno2
     *
     * @return \DateTime
     */
    public function getHoraNoturno2()
    {
        return $this->horaNoturno2;
    }

    /**
     * Set separarAdicional
     *
     * @param boolean $separarAdicional
     * @return ConfiguracaoParametrosGerais
     */
    public function setSepararAdicional($separarAdicional)
    {
        $this->separarAdicional = $separarAdicional;
        return $this;
    }

    /**
     * Get separarAdicional
     *
     * @return boolean
     */
    public function getSepararAdicional()
    {
        return $this->separarAdicional;
    }

    /**
     * Set lancarAbono
     *
     * @param boolean $lancarAbono
     * @return ConfiguracaoParametrosGerais
     */
    public function setLancarAbono($lancarAbono)
    {
        $this->lancarAbono = $lancarAbono;
        return $this;
    }

    /**
     * Get lancarAbono
     *
     * @return boolean
     */
    public function getLancarAbono()
    {
        return $this->lancarAbono;
    }

    /**
     * Set lancarDesconto
     *
     * @param boolean $lancarDesconto
     * @return ConfiguracaoParametrosGerais
     */
    public function setLancarDesconto($lancarDesconto)
    {
        $this->lancarDesconto = $lancarDesconto;
        return $this;
    }

    /**
     * Get lancarDesconto
     *
     * @return boolean
     */
    public function getLancarDesconto()
    {
        return $this->lancarDesconto;
    }

    /**
     * Set trabalhoFeriado
     *
     * @param boolean $trabalhoFeriado
     * @return ConfiguracaoParametrosGerais
     */
    public function setTrabalhoFeriado($trabalhoFeriado)
    {
        $this->trabalhoFeriado = $trabalhoFeriado;
        return $this;
    }

    /**
     * Get trabalhoFeriado
     *
     * @return boolean
     */
    public function getTrabalhoFeriado()
    {
        return $this->trabalhoFeriado;
    }

    /**
     * Set somarExtras
     *
     * @param boolean $somarExtras
     * @return ConfiguracaoParametrosGerais
     */
    public function setSomarExtras($somarExtras)
    {
        $this->somarExtras = $somarExtras;
        return $this;
    }

    /**
     * Get somarExtras
     *
     * @return boolean
     */
    public function getSomarExtras()
    {
        return $this->somarExtras;
    }

    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return ConfiguracaoParametrosGerais
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
     * OneToMany (owning side)
     * Add PontoConfiguracaoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoLotacao $fkPontoConfiguracaoLotacao
     * @return ConfiguracaoParametrosGerais
     */
    public function addFkPontoConfiguracaoLotacoes(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoLotacao $fkPontoConfiguracaoLotacao)
    {
        if (false === $this->fkPontoConfiguracaoLotacoes->contains($fkPontoConfiguracaoLotacao)) {
            $fkPontoConfiguracaoLotacao->setFkPontoConfiguracaoParametrosGerais($this);
            $this->fkPontoConfiguracaoLotacoes->add($fkPontoConfiguracaoLotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoConfiguracaoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoLotacao $fkPontoConfiguracaoLotacao
     */
    public function removeFkPontoConfiguracaoLotacoes(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoLotacao $fkPontoConfiguracaoLotacao)
    {
        $this->fkPontoConfiguracaoLotacoes->removeElement($fkPontoConfiguracaoLotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoConfiguracaoLotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoLotacao
     */
    public function getFkPontoConfiguracaoLotacoes()
    {
        return $this->fkPontoConfiguracaoLotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add PontoDiasUteis
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DiasUteis $fkPontoDiasUteis
     * @return ConfiguracaoParametrosGerais
     */
    public function addFkPontoDiasUteis(\Urbem\CoreBundle\Entity\Ponto\DiasUteis $fkPontoDiasUteis)
    {
        if (false === $this->fkPontoDiasUteis->contains($fkPontoDiasUteis)) {
            $fkPontoDiasUteis->setFkPontoConfiguracaoParametrosGerais($this);
            $this->fkPontoDiasUteis->add($fkPontoDiasUteis);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoDiasUteis
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DiasUteis $fkPontoDiasUteis
     */
    public function removeFkPontoDiasUteis(\Urbem\CoreBundle\Entity\Ponto\DiasUteis $fkPontoDiasUteis)
    {
        $this->fkPontoDiasUteis->removeElement($fkPontoDiasUteis);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoDiasUteis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DiasUteis
     */
    public function getFkPontoDiasUteis()
    {
        return $this->fkPontoDiasUteis;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoConfiguracaoRelogioPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto $fkPontoConfiguracaoRelogioPonto
     * @return ConfiguracaoParametrosGerais
     */
    public function setFkPontoConfiguracaoRelogioPonto(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto $fkPontoConfiguracaoRelogioPonto)
    {
        $this->codConfiguracao = $fkPontoConfiguracaoRelogioPonto->getCodConfiguracao();
        $this->fkPontoConfiguracaoRelogioPonto = $fkPontoConfiguracaoRelogioPonto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoConfiguracaoRelogioPonto
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto
     */
    public function getFkPontoConfiguracaoRelogioPonto()
    {
        return $this->fkPontoConfiguracaoRelogioPonto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoDiasSemana
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\DiasSemana $fkAdministracaoDiasSemana
     * @return ConfiguracaoParametrosGerais
     */
    public function setFkAdministracaoDiasSemana(\Urbem\CoreBundle\Entity\Administracao\DiasSemana $fkAdministracaoDiasSemana)
    {
        $this->codDiaDsr = $fkAdministracaoDiasSemana->getCodDia();
        $this->fkAdministracaoDiasSemana = $fkAdministracaoDiasSemana;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoDiasSemana
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\DiasSemana
     */
    public function getFkAdministracaoDiasSemana()
    {
        return $this->fkAdministracaoDiasSemana;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoAtrasos
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\Atrasos $fkPontoAtrasos
     * @return ConfiguracaoParametrosGerais
     */
    public function setFkPontoAtrasos(\Urbem\CoreBundle\Entity\Ponto\Atrasos $fkPontoAtrasos)
    {
        $fkPontoAtrasos->setFkPontoConfiguracaoParametrosGerais($this);
        $this->fkPontoAtrasos = $fkPontoAtrasos;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoAtrasos
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\Atrasos
     */
    public function getFkPontoAtrasos()
    {
        return $this->fkPontoAtrasos;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoFaltas
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\Faltas $fkPontoFaltas
     * @return ConfiguracaoParametrosGerais
     */
    public function setFkPontoFaltas(\Urbem\CoreBundle\Entity\Ponto\Faltas $fkPontoFaltas)
    {
        $fkPontoFaltas->setFkPontoConfiguracaoParametrosGerais($this);
        $this->fkPontoFaltas = $fkPontoFaltas;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoFaltas
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\Faltas
     */
    public function getFkPontoFaltas()
    {
        return $this->fkPontoFaltas;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoFaltaDsr
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FaltaDsr $fkPontoFaltaDsr
     * @return ConfiguracaoParametrosGerais
     */
    public function setFkPontoFaltaDsr(\Urbem\CoreBundle\Entity\Ponto\FaltaDsr $fkPontoFaltaDsr)
    {
        $fkPontoFaltaDsr->setFkPontoConfiguracaoParametrosGerais($this);
        $this->fkPontoFaltaDsr = $fkPontoFaltaDsr;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoFaltaDsr
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\FaltaDsr
     */
    public function getFkPontoFaltaDsr()
    {
        return $this->fkPontoFaltaDsr;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoHorasDescontoDsr
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\HorasDescontoDsr $fkPontoHorasDescontoDsr
     * @return ConfiguracaoParametrosGerais
     */
    public function setFkPontoHorasDescontoDsr(\Urbem\CoreBundle\Entity\Ponto\HorasDescontoDsr $fkPontoHorasDescontoDsr)
    {
        $fkPontoHorasDescontoDsr->setFkPontoConfiguracaoParametrosGerais($this);
        $this->fkPontoHorasDescontoDsr = $fkPontoHorasDescontoDsr;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoHorasDescontoDsr
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\HorasDescontoDsr
     */
    public function getFkPontoHorasDescontoDsr()
    {
        return $this->fkPontoHorasDescontoDsr;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoFatorMultiplicacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FatorMultiplicacao $fkPontoFatorMultiplicacao
     * @return ConfiguracaoParametrosGerais
     */
    public function setFkPontoFatorMultiplicacao(\Urbem\CoreBundle\Entity\Ponto\FatorMultiplicacao $fkPontoFatorMultiplicacao)
    {
        $fkPontoFatorMultiplicacao->setFkPontoConfiguracaoParametrosGerais($this);
        $this->fkPontoFatorMultiplicacao = $fkPontoFatorMultiplicacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoFatorMultiplicacao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\FatorMultiplicacao
     */
    public function getFkPontoFatorMultiplicacao()
    {
        return $this->fkPontoFatorMultiplicacao;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoHorasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\HorasExtras $fkPontoHorasExtras
     * @return ConfiguracaoParametrosGerais
     */
    public function setFkPontoHorasExtras(\Urbem\CoreBundle\Entity\Ponto\HorasExtras $fkPontoHorasExtras)
    {
        $fkPontoHorasExtras->setFkPontoConfiguracaoParametrosGerais($this);
        $this->fkPontoHorasExtras = $fkPontoHorasExtras;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoHorasExtras
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\HorasExtras
     */
    public function getFkPontoHorasExtras()
    {
        return $this->fkPontoHorasExtras;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoHorasPosterior
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\HorasPosterior $fkPontoHorasPosterior
     * @return ConfiguracaoParametrosGerais
     */
    public function setFkPontoHorasPosterior(\Urbem\CoreBundle\Entity\Ponto\HorasPosterior $fkPontoHorasPosterior)
    {
        $fkPontoHorasPosterior->setFkPontoConfiguracaoParametrosGerais($this);
        $this->fkPontoHorasPosterior = $fkPontoHorasPosterior;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoHorasPosterior
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\HorasPosterior
     */
    public function getFkPontoHorasPosterior()
    {
        return $this->fkPontoHorasPosterior;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoHorasAnterior
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\HorasAnterior $fkPontoHorasAnterior
     * @return ConfiguracaoParametrosGerais
     */
    public function setFkPontoHorasAnterior(\Urbem\CoreBundle\Entity\Ponto\HorasAnterior $fkPontoHorasAnterior)
    {
        $fkPontoHorasAnterior->setFkPontoConfiguracaoParametrosGerais($this);
        $this->fkPontoHorasAnterior = $fkPontoHorasAnterior;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoHorasAnterior
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\HorasAnterior
     */
    public function getFkPontoHorasAnterior()
    {
        return $this->fkPontoHorasAnterior;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoRemarcacoesConsecutivas
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RemarcacoesConsecutivas $fkPontoRemarcacoesConsecutivas
     * @return ConfiguracaoParametrosGerais
     */
    public function setFkPontoRemarcacoesConsecutivas(\Urbem\CoreBundle\Entity\Ponto\RemarcacoesConsecutivas $fkPontoRemarcacoesConsecutivas)
    {
        $fkPontoRemarcacoesConsecutivas->setFkPontoConfiguracaoParametrosGerais($this);
        $this->fkPontoRemarcacoesConsecutivas = $fkPontoRemarcacoesConsecutivas;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoRemarcacoesConsecutivas
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\RemarcacoesConsecutivas
     */
    public function getFkPontoRemarcacoesConsecutivas()
    {
        return $this->fkPontoRemarcacoesConsecutivas;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoArredondarTempo
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ArredondarTempo $fkPontoArredondarTempo
     * @return ConfiguracaoParametrosGerais
     */
    public function setFkPontoArredondarTempo(\Urbem\CoreBundle\Entity\Ponto\ArredondarTempo $fkPontoArredondarTempo)
    {
        $fkPontoArredondarTempo->setFkPontoConfiguracaoParametrosGerais($this);
        $this->fkPontoArredondarTempo = $fkPontoArredondarTempo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoArredondarTempo
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\ArredondarTempo
     */
    public function getFkPontoArredondarTempo()
    {
        return $this->fkPontoArredondarTempo;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoCalendarioPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\CalendarioPonto $fkPontoCalendarioPonto
     * @return ConfiguracaoParametrosGerais
     */
    public function setFkPontoCalendarioPonto(\Urbem\CoreBundle\Entity\Ponto\CalendarioPonto $fkPontoCalendarioPonto)
    {
        $fkPontoCalendarioPonto->setFkPontoConfiguracaoParametrosGerais($this);
        $this->fkPontoCalendarioPonto = $fkPontoCalendarioPonto;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoCalendarioPonto
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\CalendarioPonto
     */
    public function getFkPontoCalendarioPonto()
    {
        return $this->fkPontoCalendarioPonto;
    }
}
