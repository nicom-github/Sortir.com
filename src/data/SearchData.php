<?php
namespace App\data;

use App\Entity\Campus;
use App\Entity\Sortie;
use DateTimeInterface;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\DateType;


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
     * @var DateTimeType
     */
    public  DateTimeType $dateDebut;

    /**
     * @var DateTimeType
     */
    public DateTimeType $dateFin;

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