<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * MetasArrecadacaoReceita
 */
class MetasArrecadacaoReceita
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $metaArrecadacao1Bi;

    /**
     * @var integer
     */
    private $metaArrecadacao2Bi;

    /**
     * @var integer
     */
    private $metaArrecadacao3Bi;

    /**
     * @var integer
     */
    private $metaArrecadacao4Bi;

    /**
     * @var integer
     */
    private $metaArrecadacao5Bi;

    /**
     * @var integer
     */
    private $metaArrecadacao6Bi;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return MetasArrecadacaoReceita
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
     * Set metaArrecadacao1Bi
     *
     * @param integer $metaArrecadacao1Bi
     * @return MetasArrecadacaoReceita
     */
    public function setMetaArrecadacao1Bi($metaArrecadacao1Bi = null)
    {
        $this->metaArrecadacao1Bi = $metaArrecadacao1Bi;
        return $this;
    }

    /**
     * Get metaArrecadacao1Bi
     *
     * @return integer
     */
    public function getMetaArrecadacao1Bi()
    {
        return $this->metaArrecadacao1Bi;
    }

    /**
     * Set metaArrecadacao2Bi
     *
     * @param integer $metaArrecadacao2Bi
     * @return MetasArrecadacaoReceita
     */
    public function setMetaArrecadacao2Bi($metaArrecadacao2Bi = null)
    {
        $this->metaArrecadacao2Bi = $metaArrecadacao2Bi;
        return $this;
    }

    /**
     * Get metaArrecadacao2Bi
     *
     * @return integer
     */
    public function getMetaArrecadacao2Bi()
    {
        return $this->metaArrecadacao2Bi;
    }

    /**
     * Set metaArrecadacao3Bi
     *
     * @param integer $metaArrecadacao3Bi
     * @return MetasArrecadacaoReceita
     */
    public function setMetaArrecadacao3Bi($metaArrecadacao3Bi = null)
    {
        $this->metaArrecadacao3Bi = $metaArrecadacao3Bi;
        return $this;
    }

    /**
     * Get metaArrecadacao3Bi
     *
     * @return integer
     */
    public function getMetaArrecadacao3Bi()
    {
        return $this->metaArrecadacao3Bi;
    }

    /**
     * Set metaArrecadacao4Bi
     *
     * @param integer $metaArrecadacao4Bi
     * @return MetasArrecadacaoReceita
     */
    public function setMetaArrecadacao4Bi($metaArrecadacao4Bi = null)
    {
        $this->metaArrecadacao4Bi = $metaArrecadacao4Bi;
        return $this;
    }

    /**
     * Get metaArrecadacao4Bi
     *
     * @return integer
     */
    public function getMetaArrecadacao4Bi()
    {
        return $this->metaArrecadacao4Bi;
    }

    /**
     * Set metaArrecadacao5Bi
     *
     * @param integer $metaArrecadacao5Bi
     * @return MetasArrecadacaoReceita
     */
    public function setMetaArrecadacao5Bi($metaArrecadacao5Bi = null)
    {
        $this->metaArrecadacao5Bi = $metaArrecadacao5Bi;
        return $this;
    }

    /**
     * Get metaArrecadacao5Bi
     *
     * @return integer
     */
    public function getMetaArrecadacao5Bi()
    {
        return $this->metaArrecadacao5Bi;
    }

    /**
     * Set metaArrecadacao6Bi
     *
     * @param integer $metaArrecadacao6Bi
     * @return MetasArrecadacaoReceita
     */
    public function setMetaArrecadacao6Bi($metaArrecadacao6Bi = null)
    {
        $this->metaArrecadacao6Bi = $metaArrecadacao6Bi;
        return $this;
    }

    /**
     * Get metaArrecadacao6Bi
     *
     * @return integer
     */
    public function getMetaArrecadacao6Bi()
    {
        return $this->metaArrecadacao6Bi;
    }
}
