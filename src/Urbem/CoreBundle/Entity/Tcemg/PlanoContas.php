<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * Class PlanoContas
 * @package Urbem\CoreBundle\Entity\Tcemg
 */
class PlanoContas
{
    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codUf;

    /**
     * @var integer
     */
    private $codPlano;

    /**
     * @var string
     */
    private $codigoEstrutural;

    /**
     * @return int
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * @param int $codConta
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
    }

    /**
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * @param string $exercicio
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
    }

    /**
     * @return int
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * @param int $codUf
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
    }

    /**
     * @return int
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * @param int $codPlano
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
    }

    /**
     * @return string
     */
    public function getCodigoEstrutural()
    {
        return $this->codigoEstrutural;
    }

    /**
     * @param string $codigoEstrutural
     */
    public function setCodigoEstrutural($codigoEstrutural)
    {
        $this->codigoEstrutural = $codigoEstrutural;
    }
}