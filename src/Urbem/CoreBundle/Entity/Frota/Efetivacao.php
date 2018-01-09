<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Efetivacao
 */
class Efetivacao
{
    /**
     * PK
     * @var integer
     */
    private $codAutorizacao;

    /**
     * PK
     * @var integer
     */
    private $codManutencao;

    /**
     * PK
     * @var string
     */
    private $exercicioAutorizacao;

    /**
     * PK
     * @var string
     */
    private $exercicioManutencao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    private $fkFrotaAutorizacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Manutencao
     */
    private $fkFrotaManutencao;


    /**
     * Set codAutorizacao
     *
     * @param integer $codAutorizacao
     * @return Efetivacao
     */
    public function setCodAutorizacao($codAutorizacao)
    {
        $this->codAutorizacao = $codAutorizacao;
        return $this;
    }

    /**
     * Get codAutorizacao
     *
     * @return integer
     */
    public function getCodAutorizacao()
    {
        return $this->codAutorizacao;
    }

    /**
     * Set codManutencao
     *
     * @param integer $codManutencao
     * @return Efetivacao
     */
    public function setCodManutencao($codManutencao)
    {
        $this->codManutencao = $codManutencao;
        return $this;
    }

    /**
     * Get codManutencao
     *
     * @return integer
     */
    public function getCodManutencao()
    {
        return $this->codManutencao;
    }

    /**
     * Set exercicioAutorizacao
     *
     * @param string $exercicioAutorizacao
     * @return Efetivacao
     */
    public function setExercicioAutorizacao($exercicioAutorizacao)
    {
        $this->exercicioAutorizacao = $exercicioAutorizacao;
        return $this;
    }

    /**
     * Get exercicioAutorizacao
     *
     * @return string
     */
    public function getExercicioAutorizacao()
    {
        return $this->exercicioAutorizacao;
    }

    /**
     * Set exercicioManutencao
     *
     * @param string $exercicioManutencao
     * @return Efetivacao
     */
    public function setExercicioManutencao($exercicioManutencao)
    {
        $this->exercicioManutencao = $exercicioManutencao;
        return $this;
    }

    /**
     * Get exercicioManutencao
     *
     * @return string
     */
    public function getExercicioManutencao()
    {
        return $this->exercicioManutencao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao
     * @return Efetivacao
     */
    public function setFkFrotaAutorizacao(\Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao)
    {
        $this->codAutorizacao = $fkFrotaAutorizacao->getCodAutorizacao();
        $this->exercicioAutorizacao = $fkFrotaAutorizacao->getExercicio();
        $this->fkFrotaAutorizacao = $fkFrotaAutorizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaAutorizacao
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    public function getFkFrotaAutorizacao()
    {
        return $this->fkFrotaAutorizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaManutencao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Manutencao $fkFrotaManutencao
     * @return Efetivacao
     */
    public function setFkFrotaManutencao(\Urbem\CoreBundle\Entity\Frota\Manutencao $fkFrotaManutencao)
    {
        $this->codManutencao = $fkFrotaManutencao->getCodManutencao();
        $this->exercicioManutencao = $fkFrotaManutencao->getExercicio();
        $this->fkFrotaManutencao = $fkFrotaManutencao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaManutencao
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Manutencao
     */
    public function getFkFrotaManutencao()
    {
        return $this->fkFrotaManutencao;
    }
}
