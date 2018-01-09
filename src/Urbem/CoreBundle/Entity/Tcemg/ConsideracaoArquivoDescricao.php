<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ConsideracaoArquivoDescricao
 */
class ConsideracaoArquivoDescricao
{
    /**
     * PK
     * @var integer
     */
    private $codArquivo;

    /**
     * PK
     * @var integer
     */
    private $periodo;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var string
     */
    private $moduloSicom;

    /**
     * @var string
     */
    private $descricao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivo
     */
    private $fkTcemgConsideracaoArquivo;


    /**
     * Set codArquivo
     *
     * @param integer $codArquivo
     * @return ConsideracaoArquivoDescricao
     */
    public function setCodArquivo($codArquivo)
    {
        $this->codArquivo = $codArquivo;
        return $this;
    }

    /**
     * Get codArquivo
     *
     * @return integer
     */
    public function getCodArquivo()
    {
        return $this->codArquivo;
    }

    /**
     * Set periodo
     *
     * @param integer $periodo
     * @return ConsideracaoArquivoDescricao
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
        return $this;
    }

    /**
     * Get periodo
     *
     * @return integer
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ConsideracaoArquivoDescricao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConsideracaoArquivoDescricao
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
     * Set moduloSicom
     *
     * @param string $moduloSicom
     * @return ConsideracaoArquivoDescricao
     */
    public function setModuloSicom($moduloSicom)
    {
        $this->moduloSicom = $moduloSicom;
        return $this;
    }

    /**
     * Get moduloSicom
     *
     * @return string
     */
    public function getModuloSicom()
    {
        return $this->moduloSicom;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ConsideracaoArquivoDescricao
     */
    public function setDescricao($descricao = null)
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
     * ManyToOne (inverse side)
     * Set fkTcemgConsideracaoArquivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivo $fkTcemgConsideracaoArquivo
     * @return ConsideracaoArquivoDescricao
     */
    public function setFkTcemgConsideracaoArquivo(\Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivo $fkTcemgConsideracaoArquivo)
    {
        $this->codArquivo = $fkTcemgConsideracaoArquivo->getCodArquivo();
        $this->fkTcemgConsideracaoArquivo = $fkTcemgConsideracaoArquivo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgConsideracaoArquivo
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivo
     */
    public function getFkTcemgConsideracaoArquivo()
    {
        return $this->fkTcemgConsideracaoArquivo;
    }
}
