<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * JustificativaRazao
 */
class JustificativaRazao
{
    /**
     * PK
     * @var integer
     */
    private $codCompraDireta;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicioEntidade;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var string
     */
    private $razao;

    /**
     * @var string
     */
    private $fundamentacaoLegal;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    private $fkComprasCompraDireta;


    /**
     * Set codCompraDireta
     *
     * @param integer $codCompraDireta
     * @return JustificativaRazao
     */
    public function setCodCompraDireta($codCompraDireta)
    {
        $this->codCompraDireta = $codCompraDireta;
        return $this;
    }

    /**
     * Get codCompraDireta
     *
     * @return integer
     */
    public function getCodCompraDireta()
    {
        return $this->codCompraDireta;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return JustificativaRazao
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
     * Set exercicioEntidade
     *
     * @param string $exercicioEntidade
     * @return JustificativaRazao
     */
    public function setExercicioEntidade($exercicioEntidade)
    {
        $this->exercicioEntidade = $exercicioEntidade;
        return $this;
    }

    /**
     * Get exercicioEntidade
     *
     * @return string
     */
    public function getExercicioEntidade()
    {
        return $this->exercicioEntidade;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return JustificativaRazao
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
     * Set justificativa
     *
     * @param string $justificativa
     * @return JustificativaRazao
     */
    public function setJustificativa($justificativa)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * Set razao
     *
     * @param string $razao
     * @return JustificativaRazao
     */
    public function setRazao($razao)
    {
        $this->razao = $razao;
        return $this;
    }

    /**
     * Get razao
     *
     * @return string
     */
    public function getRazao()
    {
        return $this->razao;
    }

    /**
     * Set fundamentacaoLegal
     *
     * @param string $fundamentacaoLegal
     * @return JustificativaRazao
     */
    public function setFundamentacaoLegal($fundamentacaoLegal)
    {
        $this->fundamentacaoLegal = $fundamentacaoLegal;
        return $this;
    }

    /**
     * Get fundamentacaoLegal
     *
     * @return string
     */
    public function getFundamentacaoLegal()
    {
        return $this->fundamentacaoLegal;
    }

    /**
     * OneToOne (owning side)
     * Set ComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     * @return JustificativaRazao
     */
    public function setFkComprasCompraDireta(\Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta)
    {
        $this->codCompraDireta = $fkComprasCompraDireta->getCodCompraDireta();
        $this->codEntidade = $fkComprasCompraDireta->getCodEntidade();
        $this->exercicioEntidade = $fkComprasCompraDireta->getExercicioEntidade();
        $this->codModalidade = $fkComprasCompraDireta->getCodModalidade();
        $this->fkComprasCompraDireta = $fkComprasCompraDireta;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkComprasCompraDireta
     *
     * @return \Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    public function getFkComprasCompraDireta()
    {
        return $this->fkComprasCompraDireta;
    }
}
