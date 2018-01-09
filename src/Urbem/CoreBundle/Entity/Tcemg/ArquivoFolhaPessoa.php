<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ArquivoFolhaPessoa
 */
class ArquivoFolhaPessoa
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $ano;

    /**
     * @var integer
     */
    private $mes;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var boolean
     */
    private $alterado = false;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ArquivoFolhaPessoa
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
     * Set ano
     *
     * @param string $ano
     * @return ArquivoFolhaPessoa
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
        return $this;
    }

    /**
     * Get ano
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     * @return ArquivoFolhaPessoa
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return ArquivoFolhaPessoa
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set alterado
     *
     * @param boolean $alterado
     * @return ArquivoFolhaPessoa
     */
    public function setAlterado($alterado)
    {
        $this->alterado = $alterado;
        return $this;
    }

    /**
     * Get alterado
     *
     * @return boolean
     */
    public function getAlterado()
    {
        return $this->alterado;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ArquivoFolhaPessoa
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }
}
