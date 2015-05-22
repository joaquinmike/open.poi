<?php

namespace Sys\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SysPartners
 *
 * @ORM\Table(name="sys_partners")
 * @ORM\Entity
 */
class SysPartners
{
    /**
     * @var integer
     *
     * @ORM\Column(name="partner_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $partnerId;

    /**
     * @var string
     *
     * @ORM\Column(name="partner_nombre", type="string", length=64, nullable=false)
     */
    private $partnerNombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="partner_estado", type="integer", nullable=true)
     */
    private $partnerEstado;

    /**
     * @var string
     *
     * @ORM\Column(name="partner_uri", type="string", length=128, nullable=true)
     */
    private $partnerUri;

    /**
     * @var string
     *
     * @ORM\Column(name="partner_logo", type="string", length=200, nullable=true)
     */
    private $partnerLogo;

    /**
     * @var string
     *
     * @ORM\Column(name="partner_direccion", type="string", length=128, nullable=true)
     */
    private $partnerDireccion;

    /**
     * @var string
     *
     * @ORM\Column(name="partner_telf", type="string", length=16, nullable=true)
     */
    private $partnerTelf;

    /**
     * @var string
     *
     * @ORM\Column(name="partner_pagina_web", type="string", length=200, nullable=true)
     */
    private $partnerPaginaWeb;



    /**
     * Get partnerId
     *
     * @return integer 
     */
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    /**
     * Set partnerNombre
     *
     * @param string $partnerNombre
     * @return SysPartners
     */
    public function setPartnerNombre($partnerNombre)
    {
        $this->partnerNombre = $partnerNombre;

        return $this;
    }

    /**
     * Get partnerNombre
     *
     * @return string 
     */
    public function getPartnerNombre()
    {
        return $this->partnerNombre;
    }

    /**
     * Set partnerEstado
     *
     * @param integer $partnerEstado
     * @return SysPartners
     */
    public function setPartnerEstado($partnerEstado)
    {
        $this->partnerEstado = $partnerEstado;

        return $this;
    }

    /**
     * Get partnerEstado
     *
     * @return integer 
     */
    public function getPartnerEstado()
    {
        return $this->partnerEstado;
    }

    /**
     * Set partnerUri
     *
     * @param string $partnerUri
     * @return SysPartners
     */
    public function setPartnerUri($partnerUri)
    {
        $this->partnerUri = $partnerUri;

        return $this;
    }

    /**
     * Get partnerUri
     *
     * @return string 
     */
    public function getPartnerUri()
    {
        return $this->partnerUri;
    }

    /**
     * Set partnerLogo
     *
     * @param string $partnerLogo
     * @return SysPartners
     */
    public function setPartnerLogo($partnerLogo)
    {
        $this->partnerLogo = $partnerLogo;

        return $this;
    }

    /**
     * Get partnerLogo
     *
     * @return string 
     */
    public function getPartnerLogo()
    {
        return $this->partnerLogo;
    }

    /**
     * Set partnerDireccion
     *
     * @param string $partnerDireccion
     * @return SysPartners
     */
    public function setPartnerDireccion($partnerDireccion)
    {
        $this->partnerDireccion = $partnerDireccion;

        return $this;
    }

    /**
     * Get partnerDireccion
     *
     * @return string 
     */
    public function getPartnerDireccion()
    {
        return $this->partnerDireccion;
    }

    /**
     * Set partnerTelf
     *
     * @param string $partnerTelf
     * @return SysPartners
     */
    public function setPartnerTelf($partnerTelf)
    {
        $this->partnerTelf = $partnerTelf;

        return $this;
    }

    /**
     * Get partnerTelf
     *
     * @return string 
     */
    public function getPartnerTelf()
    {
        return $this->partnerTelf;
    }

    /**
     * Set partnerPaginaWeb
     *
     * @param string $partnerPaginaWeb
     * @return SysPartners
     */
    public function setPartnerPaginaWeb($partnerPaginaWeb)
    {
        $this->partnerPaginaWeb = $partnerPaginaWeb;

        return $this;
    }

    /**
     * Get partnerPaginaWeb
     *
     * @return string 
     */
    public function getPartnerPaginaWeb()
    {
        return $this->partnerPaginaWeb;
    }
}
