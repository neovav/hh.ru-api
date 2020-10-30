<?php
namespace HHruApi;

/**
 * Class with queries parameters for vacancies searches
 *
 * https://github.com/hhru/api/blob/master/docs/vacancies.md#search
 *
 * samples: https://api.hh.ru/dictionaries
 */
class VacanciesQuery
{
    /** @var array $text */
    public array $text = [];
    /**
     * @var array $search_field
     * list values: name, company_name, description
     */
    public array $search_field = [];
    /**
     * list values: noExperience, between1And3, between3And6, moreThan6
     */
    public string $experience = '';
    /**
     *  @var array $employment
     * list values: full, part, project, volunteer, probation
     */
    public array $employment = [];
    /**
     * @var array $schedule
     * list values: fullDay, shift, flexible, remote, flyInFlyOut
     */
    public array $schedule = [];
    /**
     * @var array $area
     * list areas: https://api.hh.ru/areas
     */
    public array $area = [];
    /**
     * @var array $metro
     * list areas: https://api.hh.ru/metro
     */
    public array $metro = [];
    /**
     * @var array $specialization
     * list areas: https://api.hh.ru/specializations
     */
    public array $specialization = [];
    /**
     * @var array $industry
     * list areas: https://api.hh.ru/industries
     */
    public array $industry = [];
    public string $employer_id = '';
    public string $currency = '';
    public string $salary = '';
    /**
     * list values: with_address, accept_handicapped, not_from_agency, accept_kids
     */
    public array $label = [];
    public bool $only_with_salary = false;
    public int $period = 30;
    public string $date_from = '';
    public string $date_to = '';
    public ?float $top_lat = null;
    public ?float $bottom_lat = null;
    public ?float $left_lng = null;
    public ?float $right_lng = null;
    /**
     * List values: publication_time, salary_desc, salary_asc, relevance, distance
     */
    public string $order_by = '';
    public ?float $sort_point_lat = null;
    public ?float $sort_point_lng = null;
    public bool $clusters = false;
    public bool $describe_arguments = false;
    public int $per_page = 100;
    public int $page = 0;
    public bool $no_magic = false;
    public bool $premium = false;
    public bool $responses_count_enabled = false;
    public bool $part_time = false;
}