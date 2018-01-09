<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * AnulacaoImpugnacaoEdital
 */
class AnulacaoImpugnacaoEdital
{
    /**
     * PK
     * @var integer
     */
    private $numEdital;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $exercicioProcesso;

    /**
     * @var string
     */
    private $parecerJuridico;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado
     */
    private $fkLicitacaoEditalImpugnado;


    /**
     * Set numEdital
     *
     * @param integer $numEdital
     * @return AnulacaoImpugnacaoEdital
     */
    public function setNumEdital($numEdital)
    {
        $this->numEdital = $numEdital;
        return $this;
    }

    /**
     * Get numEdital
     *
     * @return integer
     */
    public function getNumEdital()
    {
        return $this->numEdital;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AnulacaoImpugnacaoEdital
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return AnulacaoImpugnacaoEdital
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set exercicioProcesso
     *
     * @param string $exercicioProcesso
     * @return AnulacaoImpugnacaoEdital
     */
    public function setExercicioProcesso($exercicioProcesso)
    {
        $this->exercicioProcesso = $exercicioProcesso;
        return $this;
    }

    /**
     * Get exercicioProcesso
     *
     * @return string
     */
    public function getExercicioProcesso()
    {
        return $this->exercicioProcesso;
    }

    /**
     * Set parecerJuridico
     *
     * @param string $parecerJuridico
     * @return AnulacaoImpugnacaoEdital
     */
    public function setParecerJuridico($parecerJuridico)
    {
        $this->parecerJuridico = $parecerJuridico;
        return $this;
    }

    /**
     * Get parecerJuridico
     *
     * @return string
     */
    public function getParecerJuridico()
    {
        return $this->parecerJuridico;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoEditalImpugnado
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado $fkLicitacaoEditalImpugnado
     * @return AnulacaoImpugnacaoEdital
     */
    public function setFkLicitacaoEditalImpugnado(\Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado $fkLicitacaoEditalImpugnado)
    {
        $this->numEdital = $fkLicitacaoEditalImpugnado->getNumEdital();
        $this->exercicio = $fkLicitacaoEditalImpugnado->getExercicio();
        $this->exercicioProcesso = $fkLicitacaoEditalImpugnado->getExercicioProcesso();
        $this->codProcesso = $fkLicitacaoEditalImpugnado->getCodProcesso();
        $this->fkLicitacaoEditalImpugnado = $fkLicitacaoEditalImpugnado;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoEditalImpugnado
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado
     */
    public function getFkLicitacaoEditalImpugnado()
    {
        return $this->fkLicitacaoEditalImpugnado;
    }
}
