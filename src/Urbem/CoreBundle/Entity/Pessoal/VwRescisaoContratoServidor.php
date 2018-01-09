<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

class VwRescisaoContratoServidor
{
    /**
     * @var int
     */
    private $registro;

    /**
     * @var string
     */
    private $dtNomeacao;

    /**
     * @var string
     */
    private $dtPosse;

    /**
     * @var string
     */
    private $dtAdmissao;

    /**
     * @var string
     */
    private $orgao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var int
     */
    private $numcgm;

    /**
     * @var string
     */
    private $nomCgm;

    /**
     * @var int
     */
    private $codSubDivisao;

    /**
     * @var int
     */
    private $codContrato;

    /**
     * @return int
     */
    public function getRegistro()
    {
        return $this->registro;
    }

    /**
     * @param int $registro
     * @return VwRescisaoContratoServidor
     */
    public function setRegistro($registro)
    {
        $this->registro = $registro;
        return $this;
    }

    /**
     * @return string
     */
    public function getDtNomeacao()
    {
        return $this->dtNomeacao;
    }

    /**
     * @param string $dtNomeacao
     * @return VwRescisaoContratoServidor
     */
    public function setDtNomeacao($dtNomeacao)
    {
        $this->dtNomeacao = $dtNomeacao;
        return $this;
    }

    /**
     * @return string
     */
    public function getDtPosse()
    {
        return $this->dtPosse;
    }

    /**
     * @param string $dtPosse
     * @return VwRescisaoContratoServidor
     */
    public function setDtPosse($dtPosse)
    {
        $this->dtPosse = $dtPosse;
        return $this;
    }

    /**
     * @return string
     */
    public function getDtAdmissao()
    {
        return $this->dtAdmissao;
    }

    /**
     * @param string $dtAdmissao
     * @return VwRescisaoContratoServidor
     */
    public function setDtAdmissao($dtAdmissao)
    {
        $this->dtAdmissao = $dtAdmissao;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrgao()
    {
        return $this->orgao;
    }

    /**
     * @param string $orgao
     * @return VwRescisaoContratoServidor
     */
    public function setOrgao($orgao)
    {
        $this->orgao = $orgao;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     * @return VwRescisaoContratoServidor
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * @param int $numcgm
     * @return VwRescisaoContratoServidor
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomCgm()
    {
        return $this->nomCgm;
    }

    /**
     * @param string $nomCgm
     * @return VwRescisaoContratoServidor
     */
    public function setNomCgm($nomCgm)
    {
        $this->nomCgm = $nomCgm;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodSubDivisao()
    {
        return $this->codSubDivisao;
    }

    /**
     * @param int $codSubDivisao
     * @return VwRescisaoContratoServidor
     */
    public function setCodSubDivisao($codSubDivisao)
    {
        $this->codSubDivisao = $codSubDivisao;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * @param int $codContrato
     * @return VwRescisaoContratoServidor
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }
}
