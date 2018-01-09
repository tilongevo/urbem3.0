<?php

namespace Urbem\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Public.vw_pessoa_fisica_juridica
 *
 * @ORM\Table(name="public.vw_pessoa_fisica_juridica")
 * @ORM\Entity(repositoryClass="Urbem\CoreBundle\Repository\PessoaFisicaJuridicaRepository")
 */
class PessoaFisicaJuridicaView
{
    /**
     * @var integer
     *
     * @ORM\Column(name="rnum", type="integer", nullable=false)
     * @ORM\Id
     */
    private $rowNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="numcgm", type="integer", nullable=true)
     */
    private $numcgm;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_cgm", type="string")
     */
    private $nomCgm;

    /**
     * @var string
     *
     * @ORM\Column(name="cpf", type="string")
     */
    private $cpf;

    /**
     * @var string
     *
     * @ORM\Column(name="cnpj", type="string")
     */
    private $cnpj;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string")
     */
    private $documento;

    /**
     * @return int
     */
    public function getRowNumber()
    {
        return $this->rowNumber;
    }

    /**
     * @param int $rowNumber
     */
    public function setRowNumber($rowNumber)
    {
        $this->rowNumber = $rowNumber;
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
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
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
     */
    public function setNomCgm($nomCgm)
    {
        $this->nomCgm = $nomCgm;
    }

    /**
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return string
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param string $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    /**
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * @param string $documento
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }
}
