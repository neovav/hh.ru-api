<?php
namespace HHruApi;

/**
 * Class with queries parameters for vacancies searches
 *
 * https://github.com/hhru/api/blob/master/docs/employer_vacancies.md#active
 */
class VacanciesQueryActive
{
    public $manager_id;
    public $text;
    public $area;
    public $order_by;
    public $per_page;
    public $page;
}