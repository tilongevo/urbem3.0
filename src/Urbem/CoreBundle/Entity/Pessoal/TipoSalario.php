<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * TipoSalario
 */
class TipoSalario
{
    /**
     * PK
     * @var integer
     */
    private $codTipoSalario;

    /**
     * @var string
     */
    private $descricao;


    /**
     * Set codTipoSalario
     *
     * @param integer $codTipoSalario
     * @return TipoSalario
     */
    public function setCodTipoSalario($codTipoSalario)
    {
        $this->codTipoSalario = $codTipoSalario;
        return $this;
    }

    /**
     * Get codTipoSalario
     *
     * @return integer
     */
    public function getCodTipoSalario()
    {
        return $this->codTipoSalario;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoSalario
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
}
