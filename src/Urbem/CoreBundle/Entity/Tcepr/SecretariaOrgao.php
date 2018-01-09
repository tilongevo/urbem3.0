<?php

namespace Urbem\CoreBundle\Entity\Tcepr;

use Urbem\CoreBundle\Entity\Organograma\Orgao;

class SecretariaOrgao
{
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
    private $idSecretariaTce;

    /**
     * @var \DateTime
     */
    private $dtCadastro;

    /**
     * ManyToOne
     * @var Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return SecretariaOrgao
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
     * @return SecretariaOrgao
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
     * Set idSecretariaTce
     *
     * @param integer $idSecretariaTce
     * @return SecretariaOrgao
     */
    public function setIdSecretariaTce($idSecretariaTce)
    {
        $this->idSecretariaTce = $idSecretariaTce;
        return $this;
    }

    /**
     * @return integer
     */
    public function getIdSecretariaTce()
    {
        return $this->idSecretariaTce;
    }

    /**
     * Set dtBaixa
     *
     * @param \DateTime $dtBaixa
     * @return SecretariaOrgao
     */
    public function setDtCadastro(\DateTime $dtCadastro = null)
    {
        $this->dtCadastro = $dtCadastro;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param Orgao $fkOrganogramaOrgao
     * @return SecretariaOrgao
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
}
