<?php
 
namespace Urbem\CoreBundle\Entity\Tcers;

/**
 * Uniorcam
 */
class Uniorcam
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
    private $numUnidade;

    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $identificador;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridica;

    /**
     * @var array
     */
    public static $identificadorList = [
        1 => "01 - Prefeitura",
        2 => "02 - Câmara Municipal",
        3 => "03 - Secretaria da Educação",
        4 => "04 - Secretaria da Saúde",
        5 => "05 - RPPS (exceto Autarquia)",
        6 => "06 - Autarquia (exceto RPPS)",
        7 => "07 - Autarquia (RPPS)",
        8 => "08 - Fundação",
        9 => "09 - Empresa Estatal Dependente",
        10 => "10 - Empresa Estatal Não Dependente",
        11 => "11 - Consórcio",
        12 => "12 - Outras",
    ];

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Uniorcam
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
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return Uniorcam
     */
    public function setNumUnidade($numUnidade)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return Uniorcam
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Uniorcam
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set identificador
     *
     * @param integer $identificador
     * @return Uniorcam
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;
        return $this;
    }

    /**
     * Get identificador
     *
     * @return integer
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return Uniorcam
     */
    public function setFkSwCgmPessoaJuridica(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        $this->numcgm = $fkSwCgmPessoaJuridica->getNumcgm();
        $this->fkSwCgmPessoaJuridica = $fkSwCgmPessoaJuridica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    public function getFkSwCgmPessoaJuridica()
    {
        return $this->fkSwCgmPessoaJuridica;
    }
}
