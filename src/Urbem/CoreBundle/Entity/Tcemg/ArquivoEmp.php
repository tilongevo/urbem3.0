<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ArquivoEmp
 */
class ArquivoEmp
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
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var integer
     */
    private $codLicitacao;

    /**
     * @var string
     */
    private $exercicioLicitacao;

    /**
     * @var integer
     */
    private $codModalidade;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Modalidade
     */
    private $fkComprasModalidade;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ArquivoEmp
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
     * @return ArquivoEmp
     */
    public function setCodEntidade($codEntidade)
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
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return ArquivoEmp
     */
    public function setCodEmpenho($codEmpenho)
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
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return ArquivoEmp
     */
    public function setCodLicitacao($codLicitacao)
    {
        $this->codLicitacao = $codLicitacao;
        return $this;
    }

    /**
     * Get codLicitacao
     *
     * @return integer
     */
    public function getCodLicitacao()
    {
        return $this->codLicitacao;
    }

    /**
     * Set exercicioLicitacao
     *
     * @param string $exercicioLicitacao
     * @return ArquivoEmp
     */
    public function setExercicioLicitacao($exercicioLicitacao)
    {
        $this->exercicioLicitacao = $exercicioLicitacao;
        return $this;
    }

    /**
     * Get exercicioLicitacao
     *
     * @return string
     */
    public function getExercicioLicitacao()
    {
        return $this->exercicioLicitacao;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ArquivoEmp
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Modalidade $fkComprasModalidade
     * @return ArquivoEmp
     */
    public function setFkComprasModalidade(\Urbem\CoreBundle\Entity\Compras\Modalidade $fkComprasModalidade)
    {
        $this->codModalidade = $fkComprasModalidade->getCodModalidade();
        $this->fkComprasModalidade = $fkComprasModalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasModalidade
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Modalidade
     */
    public function getFkComprasModalidade()
    {
        return $this->fkComprasModalidade;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return ArquivoEmp
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicio = $fkEmpenhoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenho->getCodEntidade();
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }
}
