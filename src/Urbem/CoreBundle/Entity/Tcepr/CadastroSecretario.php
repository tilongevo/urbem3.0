<?php

namespace Urbem\CoreBundle\Entity\Tcepr;

use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;

class CadastroSecretario
{
    /**
     * PK
     * @var integer
     */
    private $numCadastro;

    /**
     * PK
     * @var integer
     */
    private $codOrgao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $codNormaBaixa;

    /**
     * @var \DateTime
     */
    private $dtInicioVinculo;

    /**
     * @var \DateTime
     */
    private $dtBaixa;

    /**
     * @var string
     */
    private $descricaoBaixa;

    /**
     * ManyToOne
     * @var Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNormaBaixa;

    /**
     * Set numCadastro
     *
     * @param integer $numCadastro
     * @return CadastroSecretario
     */
    public function setNumCadastro($numCadastro)
    {
        $this->numCadastro = $numCadastro;
        return $this;
    }

    /**
     * Get numCadastro
     *
     * @return integer
     */
    public function getNumCadastro()
    {
        return $this->numCadastro;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return CadastroSecretario
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return CadastroSecretario
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return CadastroSecretario
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return CadastroSecretario
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set codNormaBaixa
     *
     * @param integer $codNormaBaixa
     * @return CadastroSecretario
     */
    public function setCodNormaBaixa($codNormaBaixa)
    {
        $this->codNormaBaixa = $codNormaBaixa;
        return $this;
    }

    /**
     * @return integer
     */
    public function getCodNormaBaixa()
    {
        return $this->codNormaBaixa;
    }

    /**
     * Set dtInicioVinculo
     *
     * @param \DateTime $dtInicioVinculo
     * @return CadastroSecretario
     */
    public function setDtInicioVinculo(\DateTime $dtInicioVinculo = null)
    {
        $this->dtInicioVinculo = $dtInicioVinculo;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDtInicioVinculo()
    {
        return $this->dtInicioVinculo;
    }

    /**
     * Set dtBaixa
     *
     * @param \DateTime $dtBaixa
     * @return CadastroSecretario
     */
    public function setDtBaixa(\DateTime $dtBaixa = null)
    {
        $this->dtBaixa = $dtBaixa;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDtBaixa()
    {
        return $this->dtBaixa;
    }

    /**
     * Set descricaoBaixa
     *
     * @param string $descricaoBaixa
     * @return CadastroSecretario
     */
    public function setDescricaoBaixa($descricaoBaixa = null)
    {
        $this->descricaoBaixa = $descricaoBaixa;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescricaoBaixa()
    {
        return $this->descricaoBaixa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param Orgao $fkOrganogramaOrgao
     * @return CadastroSecretario
     */
    public function setFkOrganogramaOrgao(Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgao = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return CadastroSecretario
     */
    public function setFkSwCgmPessoaFisica(SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param Norma $fkNormasNorma
     * @return CadastroSecretario
     */
    public function setFkNormasNorma(Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNormaBaixa
     *
     * @param Norma $fkNormasNormaBaixa
     * @return CadastroSecretario
     */
    public function setFkNormasNormaBaixa(Norma $fkNormasNormaBaixa)
    {
        $this->codNormaBaixa = $fkNormasNormaBaixa->getCodNorma();
        $this->fkNormasNormaBaixa = $fkNormasNormaBaixa;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNormaBaixa
     *
     * @return Norma
     */
    public function getFkNormasNormaBaixa()
    {
        return $this->fkNormasNormaBaixa;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->numCadastro, $this->exercicio);
    }
}
