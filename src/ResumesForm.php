<?php
namespace HHruApi;

/**
 *
 */
class ResumesForm
{
    public string $last_name;
    public string $first_name;
    public string $middle_name;
    public string $birth_date;

    /** @var string $gender
     *      values:
     *          male
     *          female
     */
    public string $gender = 'male';
    public string $photo;
    public string $portfolio;
    public int $area;
    public ?int $metro = null;

    /** @var array $relocation = [
     *      'type' => string,
     *      'area' => int,
     * ]
     */
    public ?array $relocation = null;

    /**
     * @var ?string $business_trip_readiness
     *      values:
     *          ready
     *          sometimes
     *          never
     */
    public ?string $business_trip_readiness = null;

    /**
     * @var ContactForm[] $contact
     */
    public array $contact = [];

    /**
     * @var ContactForm[] $site
     *  $site = [
     *           'type' => 'linkedin',
     *           'url' => 'https://www.linkedin.com/feed/',
     *          ];
     *
     *      values:
     *          personal
     *          moi_krug
     *          livejournal
     *          linkedin
     *          freelance
     *          facebook
     *          skype
     *          icq
     */
    public array $site = [];
    public string $title = '';

    /** @var string[] $specialization
     *      values: https://api.hh.ru/specializations
     */
    public array $specialization = [];

    /**
     *      currency values:
     *          USD
     *          EUR
     *          RUR
     *          UAH
     *          BYR
     *          GEL
     *          KZT
     *          AZN
     *          KGS
     *          UZS
     */
    public array $salary = [
        'amount' => 0,
        'currency' => 'RUR',
    ];

    /**
     *      values:
     *          full
     *          part
     *          project
     *          volunteer
     *          probation
     */
    public string $employments = 'full';

    /**
     *      values:
     *          full
     *          part
     *          project
     *          volunteer
     *          probation
     */
    public string $schedules = 'full';
    public array $education = [
        /** @var array
         *      [
         *          'year' => string
         *          'name' => string
         * ]
         */
        'elementary' => [],
        'additional' => [],
        'attestation' => [],
        'primary' => [],
        'level' => '',
    ];
}