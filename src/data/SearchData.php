<?php
namespace App\data;

use App\Entity\Campus;
use App\Entity\Sortie;
use DateTime;


class SearchData {

    /**
     * @var Sortie[]
     */
    public array $sorties = [];

    /**
     * @var Campus
     */
    public Campus $campus;

    /**
     * @var null|string
     */
    public ?string $sortieNom;

    /**
     *
     */
    public ?DateTime $dateDebut=null;

    /**
     *
     */
    public ?DateTime $dateFin=null;

    /**
     * @var boolean
     */
    public bool $isOrganisateur = false;

    /**
     * @var boolean
     */
    public bool $isInscrit = false;

    /**
     * @var boolean
     */
    public bool $isNotInscrit = false;

    /**
     * @var boolean
     */
    public bool $isSortiesFinie = false;
}