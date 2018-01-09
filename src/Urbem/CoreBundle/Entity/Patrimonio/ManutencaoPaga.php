<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * ManutencaoPaga
 */
class ManutencaoPaga
{
    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtAgendamento;

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
     * @var integer
     */
    private $valor;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Manutencao
     */
    private $fkPatrimonioManutencao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtAgendamento = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return ManutencaoPaga
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
     * Set dtAgendamento
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtAgendamento
     * @return ManutencaoPaga
     */
    public function setDtAgendamento(\Urbem\CoreBundle\Helper\DatePK $dtAgendamento)
    {
        $this->dtAgendamento = $dtAgendamento;
        return $this;
    }

    /**
     * Get dtAgendamento
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtAgendamento()
    {
        return $this->dtAgendamento;
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return ManutencaoPaga
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
     * @return ManutencaoPaga
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ManutencaoPaga
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
     * Set valor
     *
     * @param integer $valor
     * @return ManutencaoPaga
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * OneToOne (owning side)
     * Set PatrimonioManutencao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Manutencao $fkPatrimonioManutencao
     * @return ManutencaoPaga
     */
    public function setFkPatrimonioManutencao(\Urbem\CoreBundle\Entity\Patrimonio\Manutencao $fkPatrimonioManutencao)
    {
        $this->codBem = $fkPatrimonioManutencao->getCodBem();
        $this->dtAgendamento = $fkPatrimonioManutencao->getDtAgendamento();
        $this->fkPatrimonioManutencao = $fkPatrimonioManutencao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPatrimonioManutencao
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Manutencao
     */
    public function getFkPatrimonioManutencao()
    {
        return $this->fkPatrimonioManutencao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (is_null($this->getFkPatrimonioManutencao())) {
            return "Manutenção";
        } else {
            return sprintf('%s', $this->getFkPatrimonioManutencao());
        }
    }
}
