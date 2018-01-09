<?php
 
namespace Urbem\CoreBundle\Entity\Tcems;

/**
 * DespesasNaoComputadas
 */
class DespesasNaoComputadas
{
    /**
     * PK
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $quadrimestre1 = 0;

    /**
     * @var integer
     */
    private $quadrimestre2 = 0;

    /**
     * @var integer
     */
    private $quadrimestre3 = 0;


    /**
     * Set id
     *
     * @param integer $id
     * @return DespesasNaoComputadas
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DespesasNaoComputadas
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
     * Set descricao
     *
     * @param string $descricao
     * @return DespesasNaoComputadas
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
     * Set quadrimestre1
     *
     * @param integer $quadrimestre1
     * @return DespesasNaoComputadas
     */
    public function setQuadrimestre1($quadrimestre1)
    {
        $this->quadrimestre1 = $quadrimestre1;
        return $this;
    }

    /**
     * Get quadrimestre1
     *
     * @return integer
     */
    public function getQuadrimestre1()
    {
        return $this->quadrimestre1;
    }

    /**
     * Set quadrimestre2
     *
     * @param integer $quadrimestre2
     * @return DespesasNaoComputadas
     */
    public function setQuadrimestre2($quadrimestre2)
    {
        $this->quadrimestre2 = $quadrimestre2;
        return $this;
    }

    /**
     * Get quadrimestre2
     *
     * @return integer
     */
    public function getQuadrimestre2()
    {
        return $this->quadrimestre2;
    }

    /**
     * Set quadrimestre3
     *
     * @param integer $quadrimestre3
     * @return DespesasNaoComputadas
     */
    public function setQuadrimestre3($quadrimestre3)
    {
        $this->quadrimestre3 = $quadrimestre3;
        return $this;
    }

    /**
     * Get quadrimestre3
     *
     * @return integer
     */
    public function getQuadrimestre3()
    {
        return $this->quadrimestre3;
    }
}
