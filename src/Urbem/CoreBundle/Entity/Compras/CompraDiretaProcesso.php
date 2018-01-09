<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * CompraDiretaProcesso
 */
class CompraDiretaProcesso
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
    private $exercicioProcesso;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    private $fkComprasCompraDireta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;


    /**
     * Set codCompraDireta
     *
     * @param integer $codCompraDireta
     * @return CompraDiretaProcesso
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
     * @return CompraDiretaProcesso
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
     * @return CompraDiretaProcesso
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
     * @return CompraDiretaProcesso
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
     * Set exercicioProcesso
     *
     * @param string $exercicioProcesso
     * @return CompraDiretaProcesso
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return CompraDiretaProcesso
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
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return CompraDiretaProcesso
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->exercicioProcesso = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }

    /**
     * OneToOne (owning side)
     * Set ComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     * @return CompraDiretaProcesso
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
