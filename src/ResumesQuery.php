<?php
namespace HHruApi;

/**
 * Class with queries parameters for vacancies searches
 *
 * https://github.com/hhru/api/blob/master/docs/vacancies.md#search
 *
 * samples: https://api.hh.ru/dictionaries
 */
class ResumesQuery
{
    /** @var string[] $text */
    public array $text = [];

    /** @var int $age_from */
    public int $age_from = 0;

    /** @var int $age_to */
    public int $age_to = 99;

    /** @var int $area
     *      values: https://api.hh.ru/areas
     */
    public int $area = 1;

    /** @var string[] $relocation
     *      values:
     *          living_or_relocation
     *          living
     *          living_but_relocation
     *          relocation
     */
    public array $relocation = [];

    /** @var string $date_from */
    public string $date_from = '1900-01-01';

    /** @var string $date_to */
    public string $date_to = '2100-01-01';

    /** @var string[] $education_level
     *      values:
     *          secondary
     *          special_secondary
     *          unfinished_higher
     *          higher
     *          bachelor
     *          master
     *          candidate
     *          doctor
     */
    public array $education_level = [];

    /** @var string[] $employment
     *      values:
     *          full
     *          part
     *          project
     *          volunteer
     *          probation
     */
    public array $employment = [];

    /** @var string[]|null $experience
     *      values:
     *          noExperience
     *          between1And3
     *          between3And6
     *          moreThan6
     */
    public array $experience = [];

    /** @var int[] $skill */
    public array $skill = [];

    /** @var string|null $gender
     *      values:
     *          male
     *          female
     */
    public ?string $gender = null;

    /** @var string[] $label
     *      values:
     *          only_with_photo
     *          only_with_salary
     *          only_with_age
     *          only_with_gender
     *          only_with_vehicle
     *          exclude_viewed_by_user_id
     *          exclude_viewed_by_employer_id
     *          only_in_responses
     */
    public array $label = [];

    /** @var string[] $language */
    public array $language = [];

    /** @var int[] $metro
     *      values: https://api.hh.ru/metro
     */
    public array $metro = [];

    /** @var string $currency
     *      values:
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
    public string $currency = 'RUR';

    /** @var int $salary_from */
    public int $salary_from = 0;

    /** @var int $salary_to */
    public int $salary_to = 1000000;

    /** @var string[] $schedule
     *      values:
     *          fullDay
     *          shift
     *          flexible
     *          remote
     *          flyInFlyOut
     */
    public array $schedule = [];

    /** @var string[] $specialization
     *      values: https://api.hh.ru/specializations
     */
    public array $specialization = [];

    /** @var string $order_by
     *      values:
     *          publication_time
     *          salary_desc
     *          salary_asc
     *          relevance
     */
    public string $order_by = 'publication_time';

    /** @var int[] $citizenship
     *      values: https://api.hh.ru/areas
     */
    public array $citizenship = [];

    /** @var int[] $work_ticket
     *      values: https://api.hh.ru/areas
     */
    public array $work_ticket = [];

    /** @var string[] $educational_institution
     *      values: https://github.com/hhru/api/blob/master/docs/suggests.md
     */
    public array $educational_institution = [];

    /** @var bool $search_in_responses */
    public bool $search_in_responses = false;

    /** @var bool $by_text_prefix */
    public bool $by_text_prefix = false;

    /** @var string|null $driver_license_types
     *      values:
     *          A
     *          B
     *          C
     *          D
     *          E
     *          BE
     *          CE
     *          DE
     *          TM
     *          TB
     */
    public ?string $driver_license_types = null;

    /** @var int|null $vacancy_id */
    public ?int $vacancy_id = null;

    /** @var int $per_page */
    public int $per_page = 50;

    /** @var int $page  */
    public int $page = 1;
}